<?php
    include_once __DIR__ . '/sqlstuff/animeModel.php';
    include_once __DIR__ . '/navbar.php';
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
            $result = editAUser($userID, $username, $encPword, $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email); 

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
            $result = editAUser($userID, $username, sha1($newPword), $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email); 

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
    <title>Document</title>

</head>
<body>
    <div>
        <?php var_dump($_POST); ?>
        <div class="container settings-page">

            <div class="profile-info">
                <h1><?= $_SESSION['username'] ?></h1>
                <h3><?= $_SESSION['pronouns'] ?></h3>
                <?php if ($_SESSION['isAdmin'] == 1): ?>
                    <h3>Admin Member</h3>
                <?php elseif ($_SESSION['isAdmin'] == 0): ?>
                    <h3>Basic Member</h3>
                <?php endif; ?>
            </div>

            <div class="container options-list">
                <?php if ( $_SESSION['isAdmin'] == 1): ?>
                    <h2>Admin Options</h2>
                    <h3><a href="social.php">Edit User</a></h3>
                    <h3><a href="settings.php?action=add">Add Anime</a></h3>
                <?php endif; ?>


                <h2>General Options</h2>
                <h3><a href="settings.php?action=updatePword&userID=<?= $_SESSION['userID'] ?>">Change Password</a></h3>
                <h3><a href="settings.php?action=updateEmail&userID=<?= $_SESSION['userID'] ?>">Change Email</a></h3>
            </div>

            <div class="container options-info">

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

                        <h1>Change Password</h1>

                        <label for="currentPword" class="form-label">Enter Current Password:</label>
                        <input type='password' class='form-control' id='oldPword' name='oldPword'><br><br>
                        
                        <label for="newPword" class="form-label">Enter New Password:</label>
                        <input type='password' class='form-control' id='newPword' name='newPword'><br><br>

                        <label for="pwordValid" class="form-label">Retype New Password:</label>
                        <input type='password' class='form-control' id='pwordValid' name='pwordValid'><br><br>

                        <button type="submit" class='btn btn-primary'>Change Password</button>
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

                        <h1>Change Email Address</h1>

                        <p>Current Email: <?= $_SESSION['email'] ?> </p>

                        <input type='email' placeholder='Enter New Email' class='form-control' id='email' name='email'>

                        <button type="submit" class='btn btn-primary'>Submit</button>

                        <?php
                            if(isPostRequest()){
                                echo "Failed to Update Email";
                            }
                        ?>
                    </form>

                <?php elseif($action == 'add'): ?> 
                    <form method='POST' action='settings.php?action=add'>
                        <h1>Add Anime Information</h1>

                        <?php 
                            if ($action == 'add'){
                                include_once __DIR__ . '/animeInfo.php';
                            }
                        ?>
                    </form>

                <?php endif; ?>
                
            </div>
        </div>
    </div>
</body>
</html>