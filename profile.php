<?php 
    session_start();

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn']))
    {
        header('Location: login.php');
    }

    include_once __DIR__ . '/sqlstuff/animeModel.php';
    $error = "";

    if(isset($_GET['action']))
    {
        $action = filter_input(INPUT_GET, 'action');
        $userID = filter_input(INPUT_GET, 'userID');
        

        if($action == "view" OR $action == "edit")
        {
            $row = getProfile($userID);

            $username = $row['username'];

            $encPword = $row['encPword'];

            $phoneNumber = $row['phoneNumber'];

            $pronouns = $row['pronouns'];

            $isActive = $row['isActive'];

            $isAdmin = $row['isAdmin'];

            $profilePic = $row['profilePic'];

            $salt = $row['salt'];

            $email = $row['email'];

            $bio = $row['bio'];

        }else
        {
            $username = filter_input(INPUT_POST, 'username');

            $encPword = filter_input(INPUT_POST, 'encPword');
            
            $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
            if ($phoneNumber == "") 
            {
                $error .= "<li>Enter a Phone Number</li>";
            }

            $pronouns = filter_input(INPUT_POST, 'pronouns');
            
            $isActive = filter_input(INPUT_POST, 'isActive');
            
            $isAdmin = filter_input(INPUT_POST, 'isAdmin');

            $profilePic = filter_input(INPUT_POST, 'profilePic');

            $salt = filter_input(INPUT_POST, 'salt');

            $email = filter_input(INPUT_POST, 'email');

            $bio = filter_input(INPUT_POST, 'bio');
        }

    } elseif (isset($_POST['action']))
    {
        $action = filter_input(INPUT_POST, 'action');

        $userID = filter_input(INPUT_POST, 'userID');
        
        $username = filter_input(INPUT_POST, 'username');

        $encPword = filter_input(INPUT_POST, 'encPword');
        
        $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
        if ($phoneNumber == "") 
        {
            $error .= "<li>Enter a Phone Number</li>";
        }

        $pronouns = filter_input(INPUT_POST, 'pronouns');
        
        $isActive = filter_input(INPUT_POST, 'isActive');
        
        $isAdmin = filter_input(INPUT_POST, 'isAdmin');

        $profilePic = filter_input(INPUT_POST, 'profilePic');

        $salt = filter_input(INPUT_POST, 'salt');

        $email = filter_input(INPUT_POST, 'email');

        $bio = filter_input(INPUT_POST, 'bio');
    }

    if (isPostRequest() AND $action == 'edit')
    {
        if ($error != "") 
        {
            echo "<p class='error'>Please fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }else 
        {
            $result = editAUser($userID, $username, $encPword, $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email, $bio); 

            header('Location: social.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="stylesheet.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chathura:wght@400;700&display=swap" rel="stylesheet">

    

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    

    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>

    <header>
        <a href="homePage.php" class="logo">Animedia</a>
        <div class="group">
            <ul class="navigation">
                <li><a href="homePage.php">Home</a></li>
                <li><a href="social.php">Social</a></li>
                <li><a href="settings.php?action=empty">Settings</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>

            <div class="search">
                <span class="icon"><form method='post' action='results.php'>
                    <ion-icon name="search-outline" class="searchBtn"></ion-icon>
                    <ion-icon name="close-outline" class="closeBtn"></ion-icon>
                </form></span>
            </div>

            <ion-icon name="menu-outline" class="menuToggle"></ion-icon>

        </div>
        <form class="searchBox" method='post' action='results.php'>
            <input type="text" placeholder="Search for an Anime..." name="titleInput">
        </form>
    </header>
    <?=var_dump($_POST);?>
    <br><br><br><br>

    <form class="col-lg-6 offset-lg-3" action = 'profile.php' method='post'>

        <input type='hidden' name='action' value='<?= $action ?>'>
        <input type='hidden' name='userID' value='<?= $userID ?>'>
        <br/>
        
        <div id="profile">
        
            <div class="container">

                <div class="user">
                    
                    <div class="u_pronouns">

                        <?php if ( $action == 'view'): ?>
                            <p id="user" readonly class='form-control' id='username' name='username'><?= $username ?></p>
                        <?php else: ?>
                            <input type='text' class='form-control' id='username' name='username' placeholder='Enter Username Here...' value='<?= $username ?>'>
                        <?php endif; ?>

                        <?php if ( $action == 'view'): ?>
                            <p id="Pronouns"><?= $pronouns ?></p>
                        <?php else: ?>
                            <input type='text' class='form-control' id='pronouns' name='pronouns' placeholder='Enter Pronouns Here...' value='<?= $pronouns ?>'>
                        <?php endif; ?>

                        <?php if ( $action == 'edit' AND $_SESSION['isAdmin'] == 1): ?>
                            <input type='text' style="display: none;" class='form-control' id='encPword' name='encPword' placeholder='Enter a Password...' value='<?= $encPword ?>'>
                        <?php endif; ?>

                        <?php if ( $action == 'edit' AND $_SESSION['isAdmin'] == 1): ?>
                            <input type='text' class='form-control' id='phoneNumber' name='phoneNumber' placeholder='Enter a Phone Number...' value='<?= $phoneNumber ?>'>
                        <?php endif; ?>

                    </div>

                    <br>

                    <div id="align">

                        <?php if ($isAdmin == 1): ?>
                            <p id="Membership">Admin</p>
                        <?php elseif ($isAdmin == 0): ?>
                            <p id="Membership">Basic Member</p>
                        <?php endif; ?>

                        <?php if ( $action == 'edit' AND $_SESSION['isAdmin'] == 1): ?>
                            <?php if ($isAdmin == 1): ?>
                                <input type="radio" name="isAdmin" value="1" checked>Admin <input type="radio" name="isAdmin" value="0">Basic Member

                            <?php elseif($isAdmin == 0): ?>
                                <input type="radio" name="isAdmin" value="1">Admin <input type="radio" name="isAdmin" value="0" checked>Basic Member

                            <?php else:?>
                                <input type="radio" name="isAdmin" value="1">Admin <input type="radio" name="isAdmin" value="0">Basic Member

                            <?php endif;?>
                        <?php endif; ?>

                        <?php if ( $action == 'edit' AND $_SESSION['isAdmin'] == 1): ?>
                            <?php if ($isActive == 1): ?>
                                <input type="radio" name="isActive" value="1" checked>Active <input type="radio" name="isActive" value="0">Inactive

                            <?php elseif($isActive == 0): ?>
                                <input type="radio" name="isActive" value="1">Active <input type="radio" name="isActive" value="0" checked>Inactive

                            <?php else:?>
                                <input type="radio" name="isActive" value="1">Active <input type="radio" name="isActive" value="0">Inactive

                            <?php endif;?>
                        <?php endif; ?>

                    </div>

                    <div>

                    </div>
                
                </div>

                <div>
        
                    <div class="user_display">

                        <div class="bio">

                            <h3 class="Bio_Title">Bio: </h3>
                            <hr class="user_hr">
                            <h4>
                            <?php if ( $action == 'view'): ?>
                                <?php if ($bio == ""):?>
                                    <p id="bio">This person has not added a bio to their profile yet.</p>
                                <?php else: ?>
                                    <p id="bio"><?= $bio ?></p>
                                <?php endif; ?>
                            <?php else: ?>
                                <type='text' class='form-control' id='bio' name='bio' placeholder='Enter Pronouns Here...' value='<?= $bio ?>'>
                            <?php endif; ?>
                            </h4>


                        </div>

        
                    </div>

                </div>

                <div class='col-sm-offset-2 col-sm-10'>
                    <?php if ( $action == 'view'): ?>
                        <button type="submit" disabled style="display: none;" class='btn btn-primary'>Submit</button>
                    <?php else: ?>
                        <button type="submit" class='btn btn-primary'>Submit</button>
                    <?php endif; ?>

                    <?php

                        if(isPostRequest())
                        {
                            echo "Failed to Edit Profile";
                        }
                    ?>
                </div>
                
            </div>

        </div>
    </form>

    <br><br><br><br><br><br><br>
    <footer>
        <div>
            <ul class="nav" style="background-color: #202531 ;">
                <li class="nav-item">
                  <h3 id="Animedia-Footer">Animedia</h3>
                </li>
                
              </ul>
        </div>
    </footer>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
    let searchBtn = document.querySelector('.searchBtn');
    let closeBtn = document.querySelector('.closeBtn');

    let searchBox = document.querySelector('.searchBox');

    let navigation = document.querySelector('.navigation');
    let menuToggle = document.querySelector('.menuToggle');
    let header = document.querySelector('header');
    
    searchBtn.onclick = function(){
        searchBox.classList.add('active');
        closeBtn.classList.add('active');
        searchBtn.classList.add('active');
        menuToggle.classList.add('hide');
        header.classList.remove('open');
    }
    closeBtn.onclick = function(){
        searchBox.classList.remove('active');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');
        menuToggle.classList.remove('hide');
    }

    menuToggle.onclick = function(){
        header.classList.toggle('open');
        searchBox.classList.remove('active');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');
    }

</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>


    
</body>
</html>