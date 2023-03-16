<?php 
    session_start();

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn']))
    {
        header('Location: login.php');
    }

    include_once __DIR__ . '/sqlstuff/animeModel.php';
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
    <title>Animedia</title>

    <link rel="stylesheet" href="stylesheet.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chathura:wght@400;700&display=swap" rel="stylesheet">

    

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    

    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <link rel="stylesheet" href="stylesheet.css">

    
</head>

<body>

    <style>

        b{display : none;}

        .desc {
            width: 544px;
            height: 115px;
        }

    </style>

    <form action = 'addAnime.php' method='post'>

        <div class="settings-right">

            <right class="display" style="color:#fff">

                <!--Title Language Genre-->
                <div class="display_first">
                    <input type="text" id='animeTitle' name='animeTitle' placeholder="Enter Title Here..." value='<?= $animeTitle ?>'>

                    <input type="text" name='lang' placeholder="Enter Language" id="lang" value='<?= $lang ?>'>

                    <input type="text" name='genre' placeholder="Enter Genre" value='<?= $genre ?>'>
                </div>
                <br>
                <!--Rating, Anime Photo (url)-->
                <div class="display_second">
                    <input id="num" type="number" step="0.1" name="rating" placeholder="Rating" min="0" max="5" value='<?= $rating ?>'>

                    <input type="url" id="photoURL" name="picURL" placeholder="Photo URL" value='<?= $picURL ?>'>
                </div>
                <br>
                <!--Description box middle-->
                <div class="display_last">
                    
                    <textarea id="desc" style="color:white; background-color: #333333" class="desc" name="animeDesc"></textarea>
                
                </div>

                
                <div class="container_btn">
            
                    <button class="btn btn3">Submit</button>

                    <?php

                        if(isPostRequest()){
                            echo "Failed to Add Record";
                        }
                    ?>
                        
                </div>
                
            </right>

        </div>

    </form>

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
</body>
</html>