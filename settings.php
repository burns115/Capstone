<?php
    include_once __DIR__ . '/sqlstuff/animeModel.php';
    include_once __DIR__ . '/navbar.php';
    session_start();
    print_r($_SESSION);

    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }
    
    if(isset($_GET['action'])){
        $action = filter_input(INPUT_GET, 'action');
        $userID = filter_input(INPUT_GET, 'userID');
        $username = filter_input(INPUT_GET, 'username');

        if($action == "changeEmail"){
            $row = getAUser($username);
        }elseif($action == "changePword"){
            $row = getAUser($username);
        }
    }

    $error = '';

    if(isset($_GET['action']) AND $action == 'updateEmail'){

        $action = filter_input(INPUT_GET, 'action');
        $userID = filter_input(INPUT_GET, 'userID');

        $email = filter_input(INPUT_POST, 'email');
        if ($email == "") {
            $error .= "<li>Enter New Email Address</li>";
        }
        
    }elseif(isset($_GET['action']) AND $action == 'updatePword'){

        $action = filter_input(INPUT_GET, 'action');
        $userID = filter_input(INPUT_GET, 'userID');

        $encPword = filter_input(INPUT_POST, 'encPword');
        $pwordValid = filter_input(INPUT_POST, 'pwordValid');
        if ($encPword == "") {
            $error .= "<li>Enter a valid Password</li>";
        }elseif ($pwordValid != $encPword){
            $error .= "<li>Passwords do not Match</li>";
        }
        
    }elseif (isset($_POST['action']) AND $action == 'updateEmail'){
        $action = filter_input(INPUT_POST, 'action');

        $userID = filter_input(INPUT_POST, 'userID');
        
        $email = filter_input(INPUT_POST, 'email');
        if ($email == "") {
            $error .= "<li>Enter New Email Address</li>";
        }

    }elseif (isset($_POST['action']) AND $action == 'updatePword'){
        $action = filter_input(INPUT_POST, 'action');

        $userID = filter_input(INPUT_POST, 'userID');

        $encPword = filter_input(INPUT_POST, 'encPword');
        $pwordValid = filter_input(INPUT_POST, 'pwordValid');
        if ($encPword == "") {
            $error .= "<li>Enter a valid Password</li>";
        }elseif ($pwordValid != $encPword){
            $error .= "<li>Passwords do not Match</li>";
        }
    }

    if (isPostRequest() AND $action == 'updateEmail'){

        if ($error != "") {

            echo "<p class='error'>Please fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }else{

        $result = editAUser($email); 

        header('Location: login.php'); 
        }
    }elseif (isPostRequest() AND $action == 'updatePword'){
        if ($error != "") {

            echo "<p class='error'>Please fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }else{

        $result = editAUser($userID, $encPword); 

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
        <div class="container settings-page">

            <div class="profile-info">

            </div>

            <div class="container options-list">
                <?php if ( $_SESSION['isAdmin'] == 1): ?>
                    <h2>Admin Options</h2>
                    <h3><a href="settings.php?action=disableUser">Disable User</a></h3>
                    <h3><a href="settings.php?action=add">Add Anime</a></h3>
                <?php endif; ?>


                <h2>General Options</h2>
                <h3><a href="settings.php?action=changePword">Change Password</a></h3>
                <h3><a href="settings.php?action=changeEmail">Change Email</a></h3>
            </div>

            <div class="container options-info">

                <?php if ($action == 'empty'): ?>
                    <div></div>

                <?php elseif($action == 'changePword'): ?> 
                    <form method='POST' action='changePword'>
                        <h1>Change Password</h1>
                    </form>

                <?php elseif($action == 'changeEmail'): ?> 
                    <form method='POST' action='settings.php?action=updateEmail'>
                        <input type='hidden' name='action' value='<?= $action ?>'>
                        <input type='hidden' name='userID' value='<?= $userID ?>'>
                
                        <h1>Change Email Address</h1>

                        <p>Current Email: <?= $_SESSION['email'] ?> </p>

                        <input type='email' placeholder='Enter New Email Here' class='form-control' id='email' name='email' value='<?= $email ?>'>

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