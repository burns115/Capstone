<?php
    include_once __DIR__ . '/sqlstuff/user_lookup.php';

    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST');
    }

    session_start();

    if(isPostRequest()){
        
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
                <label for="inputUname" class="form-label">Username/Email</label>
                <input type="text" class="form-control" id="inputUname" name='inputUname'>
            </div>
            <br/>
            <div">
                <label for="inputPword" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPword" name='inputPword'>
            </div>
            <br/>
            <button type="submit" class="btn btn-primary">Log In</button>
        </form>

    </div>
</body>
</html>