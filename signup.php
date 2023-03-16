<?php
    session_start();
    include_once __DIR__ . '/sqlstuff/animeModel.php';

    $error = "";

    if(isset($_GET['action'])){

        $action = filter_input(INPUT_GET, 'action');
        $userID = filter_input(INPUT_GET, 'userID');

        $email = filter_input(INPUT_POST, 'email');
        if ($email == "") {
            $error .= "<li>Enter Email Address</li>";
        }

        $username = filter_input(INPUT_POST, 'username');
        if ($username == "") {
            $error .= "<li>Enter a Username</li>";
        }

        $encPword = filter_input(INPUT_POST, 'encPword');
        $pwordValid = filter_input(INPUT_POST, 'pwordValid');
        if ($encPword == "") {
            $error .= "<li>Enter a valid Password</li>";
        }elseif ($pwordValid != $encPword){
            $error .= "<li>Passwords do not Match</li>";
        }

        $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
        if ($phoneNumber == "") {
            $error .= "<li>Enter a Phone Number</li>";
        }

        $pronouns = "";

        $profilePic = "";

        $salt = "";

        $bio = "";

        $pwordValid = "";

        $isActive = 1;

        $isAdmin = 0;
    
    }elseif (isset($_POST['action'])){
        $action = filter_input(INPUT_POST, 'action');

        $userID = filter_input(INPUT_POST, 'userID');
        
        $email = filter_input(INPUT_POST, 'email');
        if ($email == "") {
            $error .= "<li>Enter Email Address</li>";
        }
        
        $username = filter_input(INPUT_POST, 'username');
        if ($username == "") {
            $error .= "<li>Enter a Username</li>";
        }

        $encPword = filter_input(INPUT_POST, 'encPword');
        $pwordValid = filter_input(INPUT_POST, 'pwordValid');
        if ($encPword == "") {
            $error .= "<li>Enter a valid Password</li>";
        }elseif ($pwordValid != $encPword){
            $error .= "<li>Passwords do not Match</li>";
        }
        
        $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
        if ($phoneNumber == "") {
            $error .= "<li>Enter a Phone Number</li>";
        }

        
    }

    if (isPostRequest() AND $action == 'create'){

        if ($error != "") {

            echo "<p style='color:red'; class='error'>Please fix the following and resubmit</p>";
            echo "<ul style='color:red'; class='error'>$error</ul>";
        }else{
            var_dump($_POST);
        $result = addAUser($username, sha1($encPword), $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email, $bio); 

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
    <title>Animedia - Signup</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="my-container-fluid">

        <h1 id="Title"> ANIMEDIA </h1>
        
        <h2 id="LogInTitle">Sign Up</h2>

        <form class="Submissions" action = 'signup.php?action=create' method='post'>

            <input type='hidden' name='action' value='<?= $action ?>'>
            <input type='hidden' name='userID' value='<?= $userID ?>'>

            <div class="d-flex justify-content-center">
                <div class="mr-5 pr-5">
                    <label style="color:#FFFFFF;" for='email'>Email Address:</label>

                    <br>

                    <input type='email' placeholder='Enter Field Here' class='textbox' id='email' name='email' value='<?= $email ?>'>
                </div>

                <div>
                    <label style="color:#FFFFFF;" for='username'>Username:</label>

                    <br>

                    <input type='text' placeholder='Enter Field Here' class='textbox' id='username' name='username' value='<?= $username ?>' >

                </div>
            </div>

            <br>

            <div class="d-flex justify-content-center">
                <div class="mr-5 pr-5">
                    <label for="encPword" style="color:#FFFFFF;">Password:</label>
                    
                    <br>

                    <input type='password' placeholder='Enter Field Here' class='textbox' id='encPword' name='encPword' value="<?=$encPword?>">
                </div>

                <div class="ml-5 pl-5">
                    <label for="pwordValid" style="color:#FFFFFF;" > Retype Password: </label>
                    
                    <br>

                    <input type="password" placeholder='Enter Field Here' id="pwordValid" name="pwordValid" class="textbox" value="">
                </div>

            </div>

            
            <br/>
            <div class="row justify-content-center">
                <div class='col'>
                    <label style="color:#FFFFFF;" for='phoneNumber'>Phone Number:</label>
                    <br>
                    <input type='number' placeholder='Enter Field Here' class='textbox' id='phoneNumber' name='phoneNumber' value='<?= $phoneNumber ?>'>
                </div>

            </div>
            <br/>

            <button type="submit" class='btn btn-dark'>Sign Up</button>
            <br>

            <?php
                if(isPostRequest()){
                    echo "Failed to Create Account";
                }
            ?>
        </form>

        <br/><br/>

        <a href='./login.php' style="color:#FFFFFF;" class="btn btn-default">Back to Log-In Page</a>
    </div>
    <br><br>
</body>
</html>