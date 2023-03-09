<?php 
    include_once __DIR__ . '/sqlstuff/animeModel.php';
    include_once __DIR__ . '/navbar.php';
    session_start();

    if(isPostRequest())
    {
        $searchUser = filter_input(INPUT_POST, 'userInput');

        if(isset($_POST['userID']))
        {
            $userID = filter_input(INPUT_POST, 'userID');
            disableUser($userID);
        }
    }

    $records = getUser($searchUser);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .card {
        position: relative;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 175px;
        margin: auto;
        text-align: center;
        }

        .card .title {
        color: grey;
        font-size: 15px;
        }

        .card button {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 15px;
        
        }

        .card a {
        text-decoration: none;
        font-size: 18px;
        color: white;
        }

        .card button:hover, a:hover {
        opacity: 0.7;
        }

        .column {
        float: left;
        width: 20%;
        padding: 0 10px;
        }
    </style>
</head>
<body>
    <form method='post' action='social.php'>
        <input type="text" placeholder="Search for a User..." name="userInput">
        <button type="submit" class="btn text-dark">Search</button>
    </form>
    <div class="row">
        <?php foreach ($records as $row): ?>
            <div class="column">
                <div class="card">
                    <h1><?php echo $row['username']; ?></h1>
                    <p> <?php if ($row['pronouns'] != ''):  ?>
                            <?php echo $row['pronouns'];  ?>
                        <?php else : ?>
                            </br>
                        <?php endif; ?>
                    </p>
                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                        <p><button><a href='profile.php?action=edit&userID=<?=$row['userID']?>' class="btn text-dark">Edit</a></button></p>
                    <?php else: ?>
                        <p style="display: none;"><button><a href='profile.php?action=edit&userID=<?=$row['userID']?>' disabled class="btn text-dark">Edit</a></button></p>
                    <?php endif; ?>

                    <p><button><a href='profile.php?action=view&userID=<?=$row['userID']?>' class="btn text-dark">View Profile</a></button></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


</body>
</html>