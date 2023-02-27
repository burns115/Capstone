<?php
    session_start();
    include __DIR__ . '/sqlstuff/animeModel.php';

    $error = '';
    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }

    $email = "";

    $username = "";

    $password = "";

    $phoneNumber = "";

    if (isset($_POST['action'])){
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
        
        $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
        if ($phoneNumber == "") {
            $error .= "<li>Enter a Phone Number</li>";
        }

        if ($error != "") {
            echo "<p class='error'>Please fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }
    }

    if (isPostRequest() AND $action == 'add'){

        var_dump($_POST);
        $result = addAUser($email, $username, $password, $phoneNumber); 

        header('Location: homePage.php'); 

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <div class="container">

        <h2>Sign-Up</h2>

        <form class="col-lg-6 offset-lg-3" action = 'editMusic.php' method='post'>

            <input type='hidden' name='action' value='<?= $action ?>'>
            <input type='hidden' name='animeID' value='<?= $animeID ?>'>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='email'>Email Address:</label>

                <div class='col-sm-10'>
                    <input type='email' placeholder='Enter Field Here' class='form-control' id='email' name='email' value='<?= $email ?>'required>
                </div>

                <label class='control-label col-sm-2' for='username'>Username:</label>

                <div class='col-sm-10'>
                    <input type='text' placeholder='Enter Field Here' class='form-control' id='username' name='username' value='<?= $username ?>'required>
                </div>

            </div>

            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='password'>Password:</label>

                <div class='col-sm-10'>
                    <input type='password' placeholder='Enter Field Here' class='form-control' id='password' name='password' value='<?= $password ?>'required>
                </div>
                
                <label class='control-label col-sm-2' for=''>Retype Password:</label>

                <div class='col-sm-10'>
                    <input type='password' placeholder='Enter Field Here' class='form-control' id='genre' name='genre' value='<?= $genre ?>'required>
                </div>

            </div>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='phoneNumber'>Phone Number:</label>

                <div class='col-sm-10'>
                    <input type='phone' placeholder='Enter Field Here' class='form-control' id='phoneNumber' name='phoneNumber' value='<?= $phoneNumber ?>'required>
                </div>

            </div>
            <br/>
            <div class='form-group'>

                <div class='col-sm-offset-2 col-sm-10'>

                    <button type="submit" class='btn btn-primary'>Sign Up</button>

                    <?php
                        if(isPostRequest()){
                            echo "Failed to Create Account";
                        }
                    ?>
                </div>
            </div>
        </form>

        <br/><br/>

        <a href='./login.php' class="btn btn-default">Back to Log-In Page</a>
    </div>
</body>
</html>