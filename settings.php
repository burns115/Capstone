<?php
    include_once __DIR__ . '/sqlstuff/animeModel.php';
    session_start();
    print_r($_SESSION);

    $error = "";
    
    if(isset($_GET['action']))
    {
        $action = filter_input(INPUT_GET, 'action');
        $userID = filter_input(INPUT_GET, 'userID');
    

        if($action == "updateEmail" OR $action == "updatePword")
        {
            $row = getProfile($userID);

            $userID = $row['userID'];

            $username = $row['username'];

            $encPword = $row['encPword'];

            $phoneNumber = $row['phoneNumber'];

            $pronouns = $row['pronouns'];

            $isActive = $row['isActive'];

            $isAdmin = $row['isAdmin'];

            $profilePic = $row['profilePic'];

            $salt = $row['salt'];

            $email = $row['email'];

        }else
        {
            $username = filter_input(INPUT_POST, 'username');

            $encPword = filter_input(INPUT_POST, 'encPword');
            $oldPword = filter_input(INPUT_POST, 'oldPword');
            $newPword = filter_input(INPUT_POST, 'newPword');
            $pwordValid = filter_input(INPUT_POST, 'pwordValid');
            if ($oldPword == "") 
            {
                $error .= "<li>Enter Current Password</li>";
                
            }elseif (sha1($oldPword) != $encPword)
            {
                $error .= "<li>Incorrect Password Entered</li>";

            }elseif ($newPword == "")
            {
                $error .= "<li>Enter New Password</li>";

            }elseif ($pwordValid != $newPword)
            {
                $error .= "<li>Passwords do not Match</li>";

            }elseif ($oldPword == $newPword)
            {
                $error .= "<li>Previous Password Entered. Please enter a New Password</li>";
            }
            
            $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');

            $pronouns = filter_input(INPUT_POST, 'pronouns');
            
            $isActive = filter_input(INPUT_POST, 'isActive');
            
            $isAdmin = filter_input(INPUT_POST, 'isAdmin');

            $profilePic = filter_input(INPUT_POST, 'profilePic');

            $salt = filter_input(INPUT_POST, 'salt');

            $email = filter_input(INPUT_POST, 'email');
            if ($email == "") 
            {
                $error .= "<li>Enter New Email</li>";
            }
        }
  
    }elseif (isset($_POST['action']))
    {
        $action = filter_input(INPUT_POST, 'action');

        $animeID = filter_input(INPUT_POST, 'animeID');

        if ($action == "updatePword")
        {
            $action = filter_input(INPUT_POST, 'action');

            $userID = filter_input(INPUT_POST, 'userID');
            
            $username = filter_input(INPUT_POST, 'username');
            
            $encPword = filter_input(INPUT_POST, 'encPword');
            $oldPword = filter_input(INPUT_POST, 'oldPword');
            $newPword = filter_input(INPUT_POST, 'newPword');
            $pwordValid = filter_input(INPUT_POST, 'pwordValid');
            if ($oldPword == "") 
            {
                $error .= "<li>Enter Current Password</li>";

            }elseif (sha1($oldPword) != $encPword)
            {
                $error .= "<li>Incorrect Password Entered</li>";

            }elseif ($newPword == "")
            {
                $error .= "<li>Enter New Password</li>";

            }elseif ($pwordValid != $newPword)
            {
                $error .= "<li>Passwords do not Match</li>";

            }elseif ($oldPword == $newPword)
            {
                $error .= "<li>Previous Password Entered. Please enter a New Password</li>";
            }
            
            $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');

            $pronouns = filter_input(INPUT_POST, 'pronouns');
            
            $isActive = filter_input(INPUT_POST, 'isActive');
            
            $isAdmin = filter_input(INPUT_POST, 'isAdmin');

            $profilePic = filter_input(INPUT_POST, 'profilePic');

            $salt = filter_input(INPUT_POST, 'salt');

            $email = filter_input(INPUT_POST, 'email');

        }elseif ($action == "updateEmail")
        {
            $action = filter_input(INPUT_POST, 'action');

            $userID = filter_input(INPUT_POST, 'userID');
            
            $username = filter_input(INPUT_POST, 'username');
            
            $encPword = filter_input(INPUT_POST, 'encPword');
            
            $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');

            $pronouns = filter_input(INPUT_POST, 'pronouns');
            
            $isActive = filter_input(INPUT_POST, 'isActive');
            
            $isAdmin = filter_input(INPUT_POST, 'isAdmin');

            $profilePic = filter_input(INPUT_POST, 'profilePic');

            $salt = filter_input(INPUT_POST, 'salt');

            $email = filter_input(INPUT_POST, 'email');
            if ($email == "") 
            {
                $error .= "<li>Enter a New Email</li>";
            }
        }
    }

    if (isPostRequest() AND $action == 'updateEmail')
    {
        if ($error != "") 
        {
            echo "<p class='error'>Fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }else 
        {
            var_dump($_POST);
            $result = editAUser($userID, $username, $encPword, $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email, $bio); 

            header('Location: login.php'); 
        }

    }elseif (isPostRequest() AND $action == 'updatePword')
    {
        if ($error != "") 
        {
            echo "<p class='error'>Fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }else 
        {
            //$encPword == $newPword;
            var_dump($_POST);
            $result = editAUser($userID, $username, sha1($newPword), $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email, $bio); 

            header('Location: login.php'); 
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

    <br><br><br><br><br>

    <div id="profile">
        
        <div class="container">
            <div class="user">
                
                <p id="user"><?= $_SESSION['username'] ?></p>

                <div id="align">

                    <p id="Membership">
                        <?php if ($_SESSION['isAdmin'] == 1): ?>
                            Admin Member
                        <?php elseif ($_SESSION['isAdmin'] == 0): ?>
                            Basic Member
                        <?php endif; ?>
                    </p>

                </div>
               
            </div>

            <div class="settings">

                <aside class="content">
                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                        <h3>Admin Options</h3>
                        <hr id="GO_HR">
                        <h5><a class="settings-option" href="social.php">Edit User</a></h5>
                        <h5><a class="settings-option" href="settings.php?action=add">Add Anime</a></h5>
                    <?php endif; ?>
                    
                    <h3>General Options</h3>
                    <hr id="GO_HR">
                    <div>
                        <h5><a class="settings-option" href="settings.php?action=updatePword&userID=<?= $_SESSION['userID'] ?>">Change Password</a></h5>
                        <h5><a class="settings-option" href="settings.php?action=updateEmail&userID=<?= $_SESSION['userID'] ?>">Change Email</a></h5>
                    </div>

                </aside>
    
                <right class="display">
                    <div class="my-container-fluid">

                        <?php if ($action == 'empty'): ?>
                            <div></div>

                        <?php elseif($action == 'updatePword'): ?> 
                            <form method='POST' action='settings.php'>
                                <input type='hidden' name='action' value='<?= $action ?>'>
                                <input type='hidden' name='userID' value='<?= $userID ?>'>
                                <input type='hidden' name='username' value='<?= $username ?>'>
                                <input type='hidden' name='encPword' value='<?= $encPword ?>'>
                                <input type='hidden' name='email' value='<?= $email ?>'>
                                <input type='hidden' name='phoneNumber' value='<?= $phoneNumber ?>'>
                                <input type='hidden' name='pronouns' value='<?= $pronouns ?>'>
                                <input type='hidden' name='isActive' value='<?= $isActive ?>'>
                                <input type='hidden' name='isAdmin' value='<?= $isAdmin ?>'>
                                <input type='hidden' name='profilePic' value='<?= $profilePic ?>'>
                                <input type='hidden' name='salt' value='<?= $salt ?>'>
                                <input type='hidden' name='bio' value='<?= $bio ?>'>

                                <h2 id="LogInTitle">Change Password</h2>

                                <div class="Submissions">
                                    <label style="color:#FFFFFF;" for="currentPword">Enter Current Password:</label>
                                    <?php if (isPostRequest())
                                    {
                                        echo "<span style='color:red';>*</span>";
                                    }
                                    ?>
                                    <input type='password' class='textbox' id='oldPword' name='oldPword'><br><br>
                                    
                                    
                                    <label style="color:#FFFFFF;" for="newPword">Enter New Password:</label>
                                    <?php if (isPostRequest())
                                    {
                                        echo "<span style='color:red';>*</span>";
                                    }
                                    ?>
                                    <input type='password' class='textbox' id='newPword' name='newPword'><br><br>

                                    <label style="color:#FFFFFF;" for="pwordValid" >Retype New Password:</label>
                                    <?php if (isPostRequest())
                                {
                                    echo "<span style='color:red';>*</span>";
                                }
                                ?>
                                    <input type='password' class='textbox' id='pwordValid' name='pwordValid'></input><br><br>

                                    <button type="submit" class="btn btn-dark" name="loginBTN">Change Password</button>
                                </div>
                            </form>

                        <?php elseif($action == 'updateEmail'): ?> 
                            <form method='POST' action='settings.php'>
                                <input type='hidden' name='action' value='<?= $action ?>'>
                                <input type='hidden' name='userID' value='<?= $userID ?>'>
                                <input type='hidden' name='username' value='<?= $username ?>'>
                                <input type='hidden' name='encPword' value='<?= $encPword ?>'>
                                <input type='hidden' name='phoneNumber' value='<?= $phoneNumber ?>'>
                                <input type='hidden' name='pronouns' value='<?= $pronouns ?>'>
                                <input type='hidden' name='isActive' value='<?= $isActive ?>'>
                                <input type='hidden' name='isAdmin' value='<?= $isAdmin ?>'>
                                <input type='hidden' name='profilePic' value='<?= $profilePic ?>'>
                                <input type='hidden' name='salt' value='<?= $salt ?>'>
                                <input type='hidden' name='bio' value='<?= $bio ?>'> 

                                <h2 id="LogInTitle">Change Email Address</h2>

                                <label style="color:#FFFFFF;">Current Email: <?= $_SESSION['email'] ?> </label><br><br>

                                <label style="color:#FFFFFF;"> Enter New Email </label>
                                <?php if (isPostRequest())
                                {
                                    echo "<span style='color:red';>*</span>";
                                }
                                ?>
                                <br>
                                <input type='email' class='textbox' id='email' name='email'></input><br><br>

                                <button type="submit" class="submitBtn btn btn-dark">Change Email</button><br>

                                <?php
                                    if(isPostRequest()){
                                        echo "Failed to Update Email";
                                    }
                                ?>
                            </form>

                        <?php elseif($action == 'add'): ?> 
                            <form method='POST' action='settings.php?action=add'>
                                <h2 id="LogInTitle">Add Anime Information</h2>

                                <?php 
                                    if ($action == 'add'){
                                        include_once __DIR__ . '/addAnime.php';
                                    }
                                ?>
                            </form>

                        <?php endif; ?>
                        
                    </div>
                </right>

            </div>
            
        </div>

    </div>

    <script>
        document.querySelector(".side-panel-toggle").addEventListener("click", () => {document.querySelector(".wrapper").classList.toggle("side-panel-open");})
    </script>

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