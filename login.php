<?php
    include_once __DIR__ . '/sqlstuff/animeModel.php';

    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST');
    }

    session_start();

    if(isPostRequest()){
        $username = filter_input(INPUT_POST, 'inputUname');
        $pword = filter_input(INPUT_POST, 'inputPword'); 
    
        $search = getAUser($username); 

        if ($search != "No user found."){
            $salt = $search['salt'];
            $enc = $search['encPword'];
            $email = $search['email'];
            $isAdmin = $search['isAdmin'];
            $pronouns = $search['pronouns'];

    
            if(sha1($pword.$salt) == $enc){
                $_SESSION['username'] = $username; 
                $_SESSION['loggedIn'] = TRUE;
                $_SESSION['email'] = $email;
                $_SESSION['isAdmin'] = $isAdmin;
                $_SESSION['pronouns'] = $pronouns;
                $_SESSION['encPword'] = $encPword;

                if($isAdmin == 1){
                    header('Location: homePage.php?action=admin'); 
                }else{
                    header('Location: homePage.php'); 
                }
    
            } else {
                $_SESSION['loggedIn'] = FALSE; 
            }
            
        } else { 
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
    <title>Document</title>
</head>
<body>
    <div>
        <?php if(isPostRequest()):?>

            <?php if(!$_SESSION['loggedIn'])://Username: rburns Password: rburns?>

                <div role="alert">Username not found/Password may be incorrect.</div>

            <?php endif;?>

        <?php endif;?>

        <h1>Animedia</h1>

        <h3>Login</h3>

        <form method='post' action='login.php'>
            <div>
                <label for="inputUname" class="form-label">Username</label>
                <input type="text" class="form-control" id="inputUname" name='inputUname'>
            </div>
            <br/>
            <div">
                <label for="inputPword" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPword" name='inputPword'>
            </div>
            <br/>
            <button type="submit" class="btn btn-primary">Log In</button>
            <br/>
        </form>
        <br/>
        <button class="btn btn-primary" onclick="window.location.href='signup.php?action=create'">Sign Up</button>

    </div>
</body>
</html>