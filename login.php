<?php
    include_once __DIR__ . '/sqlstuff/animeModel.php';

    session_start();

    if(isPostRequest())
    {
        $username = filter_input(INPUT_POST, 'inputUname');
        $pword = filter_input(INPUT_POST, 'inputPword'); 
    
        $search = getAUser($username); 

        if ($search != "No user found.")
        {
            $salt = $search['salt'];
            $enc = $search['encPword'];
            $email = $search['email'];
            $isAdmin = $search['isAdmin'];
            $pronouns = $search['pronouns'];
            $userID = $search['userID'];

    
            if(sha1($pword.$salt) == $enc)
            {
                $_SESSION['username'] = $username; 
                $_SESSION['loggedIn'] = TRUE;
                $_SESSION['email'] = $email;
                $_SESSION['isAdmin'] = $isAdmin;
                $_SESSION['pronouns'] = $pronouns;
                $_SESSION['encPword'] = $encPword;
                $_SESSION['userID'] = $userID;

                if($isAdmin == 1)
                {
                    header('Location: homePage.php?action=admin'); 
                }else
                {
                    header('Location: homePage.php'); 
                }
    
            } else 
            {
                $_SESSION['loggedIn'] = FALSE; 
            }
            
        } else 
        { 
            $_SESSION['loggedIn'] = FALSE;//if pword and uname are incorrect, stay on login page
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animedia - Log in</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="my-container-fluid">>
        <?php if(isPostRequest()):?>

            <?php if(!$_SESSION['loggedIn'])://Username: rburns Password: rburns?>

                <div role="alert">Username not found/Password may be incorrect.</div>

            <?php endif;?>

        <?php endif;?>

        <h1 id="Title">ANIMEDIA</h1>

        <h2 id="LogInTitle">Login</h2>

        <form class="Submissions" method='post' action='login.php'>
            <label for="inputUname" style="color:#FFFFFF;" > Username </label> <br>
            <input type="text" id="inputUname" name="inputUname" class="textbox" value="">

            <br><br>

            <label for="inputPword" style="color:#FFFFFF;"> Password </label><br>
            <input type="password" id="inputPword" name="inputPword" class="textbox">

            <br>
            <br>
            <button type="submit" class="btn btn-dark" name="loginBTN">Log-In</button>
        </form>
        <br><br>
        <div class="Signup">

            <p id="signupTXT">Don't have an account? Sign up now it's free</p>
            
            <button type="button" class="btn btn-dark" name="signupBTN" onclick="window.location.href='signup.php?action=create'">Sign up</button>

        </div>
        <br><br>

    </div>
</body>
</html>