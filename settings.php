<?php
    session_start();
    include __DIR__ . '/sqlstuff/animeModel.php';

    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }

    if(isset($_GET['action'])){
        $action = filter_input(INPUT_GET, 'action');
        $userID = filter_input(INPUT_GET, 'userID');
        $username = 

        if($action == "changeEmail"){
            $row = getAUser($username);

            $email = $row['email'];
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
                <h2>General Options</h2>
                <?php
                print_r($_SESSION);
                ?>
                <h3><a href="settings.php?action=changePword">Change Password</a></h3>
                <h3><a href="settings.php?action=changeEmail">Change Email</a></h3>
            </div>

            <div class="container options-info">

                <?php if ($action == 'empty'): ?>
                    <div></div>

                <?php elseif($action == 'changePword'): ?> 
                    <form method='POST' action='changePword'>
                        <h1>Change Password</h1>

                <?php elseif($action == 'changeEmail'): ?> 
                    <form method='POST' action='changeEmail'>
                        <h1>Change Email Address</h1>

                        <p>Current Email: <?= $_SESSION['email'] ?> </p>

                        <input type="email" class="form-control" id="inputEmail" name='inputEmail' placeholder="Enter New Email...">

                <?php endif; ?>
                
            </div>
        </div>
    </div>
</body>
</html>