<?php 
    session_start();

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn']))
    {
        header('Location: login.php');
    }

    include_once __DIR__ . '/sqlstuff/animeModel.php';
    include_once __DIR__ . '/navbar.php';
    $error = "";

    if(isset($_GET['action']))
    {
        $action = filter_input(INPUT_GET, 'action');
        $userID = filter_input(INPUT_GET, 'userID');
        

        if($action == "view" OR $action == "edit")
        {
            $row = getProfile($userID);

            print_r($row);

            echo gettype($row['username']);

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
    }

    if (isPostRequest() AND $action == 'edit')
    {
        if ($error != "") 
        {
            echo "<p class='error'>Please fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }else 
        {
            $result = editAUser($userID, $username, $encPword, $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email); 

            header('Location: profile.php?action=view');
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

    <form class="col-lg-6 offset-lg-3" action = 'profile.php' method='post'>

        <input type='hidden' name='action' value='<?= $action ?>'>
        <input type='hidden' name='animeID' value='<?= $userID ?>'>
        <br/>
        <div class="form-group">

            <div class='col-sm-10'>
                
                <?php if ( $action == 'view'): ?>
                    <h1  readonly class='form-control' id='username' name='username'><?= $username ?></h1>
                <?php else: ?>
                    <input type='text' class='form-control' id='username' name='username' placeholder='Enter Username Here...' value='<?= $username ?>'>
                <?php endif; ?>
                
                <?php if ( $action == 'view'): ?>
                    <h3><?= $pronouns ?></h3>
                <?php else: ?>
                    <input type='text' class='form-control' id='pronouns' name='pronouns' placeholder='Enter Pronouns Here...' value='<?= $pronouns ?>'>
                <?php endif; ?>

                <?php if ($isAdmin == 1): ?>
                    <h3>Admin</h3>
                <?php elseif ($isAdmin == 0): ?>
                    <h3>Basic Member</h3>
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
                    <input type='text' class='form-control' id='encPword' name='encPword' placeholder='Enter a Password...' value='<?= $encPword ?>'>
                <?php endif; ?>

                <?php if ( $action == 'edit' AND $_SESSION['isAdmin'] == 1): ?>
                    <input type='text' class='form-control' id='phoneNumber' name='phoneNumber' placeholder='Enter a Phone Number...' value='<?= $phoneNumber ?>'>
                <?php endif; ?>

                <?php if ( $action == 'edit' AND $_SESSION['isAdmin'] == 1): ?>
                    <input type='email'  class='form-control' id='email' name='email' placeholder='Enter a Email Address...' value='<?= $email ?>'>
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

        </div>

        </div>
        <br/>
        <div class="form-group">
            <div class='col-sm-10'>
            </div>
        </div>
        <br/>
        <div class="form-group">
            


        </div>
        <br/>
        
        <div class='form-group'>

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
    </form>
    
</body>
</html>