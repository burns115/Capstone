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
            $result = editAUser($userID, $username, sha1($oldPword), $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email, $bio); 

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
    <title>Animedia</title>

    <link rel="stylesheet" href="stylesheet.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chathura:wght@400;700&display=swap" rel="stylesheet">

    

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    

    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

</head>
<body>

    <style>

        .display{ width : 100%;}

        .settings{
            text-align: center;
            background-color: #1F1F1F;
            width: 75%;
            display: flex;
            padding: 0px;
            border-right: #333333 2px solid;
            border-left: #333333 2px solid;
            border-bottom: #333333 2px solid;
            margin-right: auto;
            margin-left: auto;
            border-top: #333333 2px solid;
        }

        #desc {
            width: 544px;
            height: 115px;
        }

    </style>

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
    <br><br><br><br>

    <form action = 'editUser.php' method='post'>

        <input type='hidden' name='action' value='<?= $action ?>'>
        <input type='hidden' name='userID' value='<?= $userID ?>'>
        <br/>

        <div class="settings">

            <right class="display" style="color:#fff">

                <p id="AddAnime">Edit User</p>

                <!--Title Language Genre-->
                <div class="display_first">
                    <input type='text' id='animeTitle' name='username' placeholder='Enter Username Here...' value='<?= $username ?>'>

                    <input type='text' id='lang' name='pronouns' placeholder='Enter Pronouns Here...' value='<?= $pronouns ?>'>

                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                        <input type='text' class='form-control' id='phoneNumber' name='phoneNumber' placeholder='Enter a Phone Number...' value='<?= $phoneNumber ?>'>
                    <?php endif; ?>
                    
                </div>
                <br>
                <!--Rating, Anime Photo (url)-->
                <div class="display_second">

                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                        <?php if ($isAdmin == 1): ?>
                            <input type="radio" name="isAdmin" value="1" checked>Admin <input type="radio" name="isAdmin" value="0">Basic Member

                        <?php elseif($isAdmin == 0): ?>
                            <input type="radio" name="isAdmin" value="1">Admin <input type="radio" name="isAdmin" value="0" checked>Basic Member

                        <?php else:?>
                            <input type="radio" name="isAdmin" value="1">Admin <input type="radio" name="isAdmin" value="0">Basic Member

                        <?php endif;?>
                    <?php endif; ?>
                    <br><br>
                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                        <?php if ($isActive == 1): ?>
                            <input type="radio" name="isActive" value="1" checked>Active <input type="radio" name="isActive" value="0">Inactive

                        <?php elseif($isActive == 0): ?>
                            <input type="radio" name="isActive" value="1">Active <input type="radio" name="isActive" value="0" checked>Inactive

                        <?php else:?>
                            <input type="radio" name="isActive" value="1">Active <input type="radio" name="isActive" value="0">Inactive

                        <?php endif;?>
                    <?php endif;?>
                </div>
                <br>
                <!--Description box middle-->
                <div class="display_last">
                    
                    <textarea type='text' class='form-control' id='desc' name='bio' placeholder='Enter Bio Here...' value='<?= $bio ?>'><?= $bio ?></textarea>
                
                </div>

                
                <div class="container_btn">
            
                    <button class="btn btn3">Submit</button>

                    <?php

                        if(isPostRequest()){
                            echo "Failed to Add Record";
                        }
                    ?>
                        
                </div>
                
            </right>

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