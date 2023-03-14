<?php 
    include_once __DIR__ . '/sqlstuff/animeModel.php';
    include_once __DIR__ . '/navbar.php';
    session_start();

    $searchUser = "";

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
    <title>Animedia</title>

    <link rel="stylesheet" href="stylesheet.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chathura:wght@400;700&display=swap" rel="stylesheet">

    

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    

    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <link rel="stylesheet" href="stylesheet.css">

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
    <header>
        <a href="homePage.php" class="logo">Animedia</a>
        <div class="group">
            <ul class="navigation">
                <li><a href="homePage.php">Home</a></li>
                <li><a href="social.php">Social</a></li>
                <li><a href="settings.php?action=empty">Settings</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>

            <div class="search">
                <span class="icon"><form method='post' action='social.php'>
                    <ion-icon name="search-outline" class="searchBtn"></ion-icon>
                    <ion-icon name="close-outline" class="closeBtn"></ion-icon>
                </form></span>
            </div>

            <ion-icon name="menu-outline" class="menuToggle"></ion-icon>

        </div>
        <form class="searchBox" method='post' action='social.php'>
            <input type="text" placeholder="Search for a User..." name="userInput">
        </form>
    </header>
    <h2 id="Users">Users</h2>
    <div class="user_container">
        <?php foreach ($records as $row): ?>
            <div class="column">
                <div class="specific_user">
                    <p><?php echo $row['username']; ?></p>
                    <p> <?php if ($row['pronouns'] != ''):  ?>
                            <?php echo $row['pronouns'];  ?>
                        <?php else : ?>
                            </br>
                        <?php endif; ?>
                    </p>
                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                        <p><a href='profile.php?action=edit&userID=<?=$row['userID']?>' class="btn text-dark"><button>Edit</button></a></p>
                    <?php else: ?>
                        <a style="display: none;" href='profile.php?action=edit&userID=<?=$row['userID']?>' disabled class="btn text-dark"><button>Edit</button></a>
                    <?php endif; ?>

                    <a href='profile.php?action=view&userID=<?=$row['userID']?>' class="btn text-dark"><button>View Profile</button></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
    let searchBtn = document.querySelector('.searchBtn');
    let closeBtn = document.querySelector('.closeBtn');

    let searchBox = document.querySelector('.searchBox');

    let navigation = document.querySelector('.navigation');
    let menuToggle = document.querySelector('.menuToggle');
    let header = document.querySelector('header');
    
    searchBtn.onclick = function(){
        searchBox.classList.add('active');
        closeBtn.classList.add('active');
        searchBtn.classList.add('active');
        menuToggle.classList.add('hide');
        header.classList.remove('open');
    }
    closeBtn.onclick = function(){
        searchBox.classList.remove('active');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');
        menuToggle.classList.remove('hide');
    }

    menuToggle.onclick = function(){
        header.classList.toggle('open');
        searchBox.classList.remove('active');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');
    }

</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</html>