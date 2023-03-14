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
        $animeID = filter_input(INPUT_GET, 'animeID');
    

        if($action == "edit" OR $action == "view")
        {
            $row = getARecord($animeID);

            $animeTitle = $row['animeTitle'];

            $rating = $row['rating'];

            $lang = $row['lang'];

            $genre = $row['genre'];

            $animeDesc = $row['animeDesc'];

            $picURL = $row['picURL'];

            $dateAdded = $row['dateAdded'];

        }else
        {
            $animeTitle = filter_input(INPUT_POST, 'animeTitle');
            if ($animeTitle == "") 
            {
                $error .= "<li>Enter the Anime Title</li>";
            }   

            $rating = filter_input(INPUT_POST, 'rating');
            if ($rating == "") 
            {
                $error .= "<li>Enter the Rating</li>";
            }
            
            $lang = filter_input(INPUT_POST, 'lang');
            if ($lang == "") 
            {
                $error .= "<li>Select the Langauge(s)</li>";
            }

            $genre = filter_input(INPUT_POST, 'genre');
            if ($genre == "") 
            {
                $error .= "<li>Select the Genre(s)</li>";
            }
            
            $animeDesc = filter_input(INPUT_POST, 'animeDesc');
            if ($animeDesc == "") 
            {
                $error .= "<li>Enter the Description</li>";
            }
            
            $picURL = filter_input(INPUT_POST, 'picURL');
            if ($picURL == "") 
            {
                $error .= "<li>Enter the Picture URL</li>";
            }

            $dateAdded = date('Y-m-d');
        }

    } elseif (isset($_POST['action']))
    {
        $action = filter_input(INPUT_POST, 'action');

        $animeID = filter_input(INPUT_POST, 'animeID');
        
        $animeTitle = filter_input(INPUT_POST, 'animeTitle');
        if ($animeTitle == "") 
        {
            $error .= "<li>Enter the Anime Title</li>";
        }
        
        $rating = filter_input(INPUT_POST, 'rating');
        if ($rating == "") 
        {
            $error .= "<li>Enter the Rating</li>";
        }
        
        $lang = filter_input(INPUT_POST, 'lang');
        if ($lang == "") 
        {
            $error .= "<li>Selects the Langauge(s)</li>";
        }

        $genre = filter_input(INPUT_POST, 'genre');
        if ($genre == "") 
        {
            $error .= "<li>Selects the Genre(s)</li>";
        }
        
        $animeDesc = filter_input(INPUT_POST, 'animeDesc');
        if ($animeDesc == "") 
        {
            $error .= "<li>Enter the Description</li>";
        }
        
        $picURL = filter_input(INPUT_POST, 'picURL');
        if ($picURL == "") 
        {
            $error .= "<li>Enter the Picture URL</li>";
        }

        $dateAdded = filter_input(INPUT_POST, 'dateAdded');
    }

    if (isPostRequest() AND $action == 'add')
    {
        if ($error != "") 
        {
            echo "<p class='error'>Please fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }else 
        {
            var_dump($_POST);
            $result = addRecord($animeTitle, $rating, $lang, $genre, $animeDesc, $picURL, $dateAdded); 

            header('Location: homePage.php'); 
        }

    } elseif (isPostRequest() AND $action == 'edit')
    {
        if ($error != "") 
        {
            echo "<p class='error'>Please fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }else 
        {
            var_dump($_POST);
            $result = editRecord($animeID, $animeTitle, $rating, $lang, $genre, $animeDesc, $picURL, $dateAdded); 

            header('Location: homepage.php');
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
    <link rel="stylesheet" href="stylesheet.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chathura:wght@400;700&display=swap" rel="stylesheet">

    

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


    <script src="https://cdn.tiny.cloud/1/e8ysbaw5rm2qyll3i804mdm2ssjaco823ewrv66f8wnvbwam/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    

    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <link rel="stylesheet" href="stylesheet.css">
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
                <span class="icon"><form method='post' action='results.php'>
                    <ion-icon name="search-outline" class="searchBtn"></ion-icon>
                    <ion-icon name="close-outline" class="closeBtn"></ion-icon>
                </form></span>
            </div>

            <ion-icon name="menu-outline" class="menuToggle"></ion-icon>

        </div>
        <form class="searchBox" method='post' action='results.php'>
            <input type="text" placeholder="Search for an Anime..." name="titleInput">
        </form>
    </header>
    <br><br>

    <form class="col-lg-6 offset-lg-3" action = 'animeInfo.php' method='post'>

        <input type='hidden' name='action' value='<?= $action ?>'>
        <input type='hidden' name='animeID' value='<?= $animeID ?>'>
        <br/>
        <div id="anime">

            <div class='top'>


                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <input type="date" style="display: none;" value ="<?= $dateAdded ?>">
                <?php else: ?> 
                    <p type="date" style="display: none;" value ="<?= $dateAdded ?>"><?= $dateAdded ?></p>
                <?php endif; ?>

                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <h2 class='form-control' id='animeTitle' name='animeTitle' value='<?= $animeTitle ?>'><?= $animeTitle ?></h2>
                <?php else: ?>
                    <input type='text' class='form-control' id='animeTitle' name='animeTitle' placeholder='Enter Title Here...' value='<?= $animeTitle ?>'>
                <?php endif; ?>
                    
                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <h3 class='form-control' id='lang' name='lang' value='<?= $lang ?>'><?= $lang ?></h3>
                <?php else: ?>
                    <input type='text' class='form-control' id='lang' name='lang' placeholder='Language' value='<?= $lang ?>'>
                <?php endif; ?>

                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <h3 class='form-control' id='genre' name='genre' value='<?= $genre ?>'><?= $genre ?></h3>

                <?php else: ?>
                    <input type='text' class='form-control' id='genre' name='genre' placeholder='genre' value='<?= $genre ?>'>
                <?php endif; ?>

            </div>
            
            <div class='middle'>
                <div class="aside">
                    <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                        <h3 class='form-control' id='rating' name='rating' value='<?= $rating ?>'>Average Rating: <?= $rating ?>/5</h3>
                    <?php else: ?>
                        <input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57 event.charCode == 32' class='form-control' name='rating' placeholder='rating' value='<?= $rating ?>'>
                    <?php endif; ?>

                    <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                        <h3>Description:</h3>
                        <h6 id='animeDesc' name='animeDesc' value='<?= $animeDesc ?>'><?= $animeDesc ?></h6>
                    <?php else: ?>
                        <textarea type='text' id='animeDesc' name='animeDesc' placeholder='Enter Description Here...' value='<?= $animeDesc ?>'><?= $animeDesc ?></textarea>
                    <?php endif; ?>
                </div>

                <div class="picture">
                    <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                            <img class="animePic" src="<?php echo $row['picURL']; ?>">
                        <?php else: ?>
                            <input type='text' class='form-control' id='picURL' name='picURL' placeholder='Picture URL Here' value='<?= $picURL ?>'>
                    <?php endif; ?>
                </div>
            </div>

            <br>

            <div class="container_btn">
                
                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <button type="submit" disabled style="display: none;" class='btn btn-primary'>Submit</button>
                <?php else: ?>
                    <button type="submit" class='btn btn-primary'>Submit</button>
                <?php endif; ?>

                <?php

                    if(isPostRequest()){
                        echo "Failed to Add Record";
                    }
                ?>
                
            </div>

        </div>
    </form>
    
</body>
</html>