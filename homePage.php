<?php
session_start();

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn']))
    {
        header('Location: login.php');
    }

    include_once __DIR__ . '/sqlstuff/animeModel.php';

    $searchTitle = "";
    $ratingFilter = "";
    $genreSelect = "";
    echo print_r($genreSelect);

    if(isPostRequest())
    {
        
        $searchTitle = filter_input(INPUT_POST, 'titleInput');
        $ratingFilter = filter_input(INPUT_POST, 'ratingFilter');
        $genreSelect = filter_input(INPUT_POST, 'genreSelect');

        if(isset($_POST['animeID']))
        {
            $animeID = filter_input(INPUT_POST, 'animeID');
            deleteRecord($animeID);
        }
    }

    $mostPopular = mostPopular($searchTitle);
    $recentAdd = recentAdd($searchTitle);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chathura:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link rel="stylesheet" href="stylesheet.css">

    <title>Document</title>

    <style>
        .flip-card 
        {
        background-color: transparent;
        width: 200px;
        height: 250px;
        }

        .flip-card-inner 
        {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.4s;
        transform-style: preserve-3d;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }

        .flip-card:hover .flip-card-inner 
        {
        transform: rotateY(180deg);
        }

        .flip-card-front, .flip-card-back 
        {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        }

        .flip-card-front 
        {
        background-color: #bbb;
        color: black;
        }

        .flip-card-back 
        {
        background-color: black;
        color: white;
        transform: rotateY(180deg);
        }

        * 
        {
        box-sizing: border-box;
        }

        /* Float four columns side by side */
        .column 
        {
        float: left;
        width: 25%;
        padding: 0 10px;
        }

        /* Remove extra left and right margins, due to padding in columns */
        .row {margin: 0 -5px;}

        /* Clear floats after the columns */
        .row:after 
        {
        content: "";
        display: table;
        clear: both;
        }

        /* Style the counter cards */
        .card 
        {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* this adds the "card" effect */
        padding: 16px;
        text-align: center;
        background-color: #f1f1f1;
        }

        /* Responsive columns - one column layout (vertical) on small screens */
        @media screen and (max-width: 600px) 
        {
            .column 
            {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
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
    <?=var_dump($_POST);?>
    <br><br><br><br><br>
    
        <div class="wrapper side-panel-open">

            <div class="side-panel">


                <form action="results.php" method="POST">

                    <h2 style="text-decoration: underline;" id="filters">Filters</h2>
                    <div class="genres">
                        <h5 class="sidepanel-titles" style="font-size: 1em;">Genres</h5>
                        <div id="g-box">
                            <input type="radio" id="action" name="genreSelect" value="Action">
                            <label for="action">Action</label>
                            <hr class="gbox-hr">
                            <input type="radio" id="romance" name="genreSelect" value="Romance">
                            <label for="romance">Romance</label>
                            <hr class="gbox-hr">
                            <input type="radio" id="shonen" name="genreSelect" value="Shonen">
                            <label for="shonen">Shonen</label>
                            <hr class="gbox-hr">
                            <input type="radio" id="isekai" name="genreSelect" value="Isekai">
                            <label for="isekai">Isekai</label>
                            <hr class="gbox-hr">
                            <input type="radio" id="horror" name="genreSelect" value="Horror">
                            <label for="horror">Horror</label>
                            <hr class="gbox-hr">
                            <input type="radio" id="comedy" name="genreSelect" value="Comedy">
                            <label for="comedy">Comedy</label>
                            <hr class="gbox-hr">
                            <input type="radio" id="mystery" name="genreSelect" value="Mystery">
                            <label for="mystery">Mystery</label><br>

                        </div>
                    </div>
                    <br>
                    
                    <hr class="side-panel-hr">
                    <div class="Ratings">
                        <h5 class="sidepanel-titles" style="font-size: 1em;">Ratings</h5>

                        <div class="containeee">

                            <label >High -&gt Low  &nbsp
                                <input type="radio" name="ratingFilter" value="1">
                            </label>

                            <label>&nbsp| </label>

                            <label class="containeee">Low -&gt High &nbsp
                                <input type="radio" name="ratingFilter" value="0">
                            </label>


                            
                        </div>
                    </div>

                    <div id=filter_submit>

                        <input style="
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1em;
                        width: 20%;
                        margin-left: auto;
                        margin-right: auto;
                        margin-top: 6%;


                        "  type="submit" value="Apply" id="filter_submit">

                    </div>
                    
                </form> 
            </div>


            <button class="side-panel-toggle" type="button">
                <span class="material-symbols-outlined sp-icons-open"> arrow_right </span>
                <span class="material-symbols-outlined sp-icons-close"> arrow_left </span>
            </button>
            

            <div class="main">
                <div class="HomePage_Elements">
                    <div>
                        <h3>Most Popular: </h3>
                        <div class="bg"> 
                            <?php foreach ($mostPopular as $row): ?>
                                <div class="column">
                                    <div class="flip-card anime-tiles container mt-3">
                                        <div class="flip-card-inner">
                                            <div class="flip-card-front">
                                                <img src="<?php echo $row['picURL']; ?>" alt="Card image" style="height:100%; width:100%;">
                                            </div>
                                            <div class="flip-card-back">
                                                <br/>
                                                <div>
                                                    <h4><?php echo $row['animeTitle']; ?></h4>
                                                </div>
                                                <br/>
                                                <div>
                                                    <p style="font-size: 15px;"><?php echo $row['rating']; ?></p>
                                                    <p style="font-size: 15px;"><?php echo $row['genre']; ?></p>
                                                </div>
                                                <div container>
                                                    <a href='animeInfo.php?action=view&animeID=<?=$row['animeID']?>' class="btn text-dark">View</a>

                                                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                                                        <a href='animeInfo.php?action=edit&animeID=<?=$row['animeID']?>' class="btn text-dark">Edit</a>
                                                    <?php else: ?>
                                                        <a href='animeInfo.php?action=edit&animeID=<?=$row['animeID']?>' disabled style="display: none;" class="btn text-dark">Edit</a>
                                                    <?php endif; ?>

                                                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                                                        <form action="homePage.php" method="post">
                                                            <input type="hidden" name="animeID" value="<?= $row['animeID'] ?>" />
                                                            
                                                            <button type="submit" class="btn text-dark">Delete</button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form action="homePage.php" method="post">
                                                            <input type="hidden" name="animeID" value="<?= $row['animeID'] ?>" />
                                                            
                                                            <button type="submit" disabled style="display: none;" class="btn text-dark">Delete</button>
                                                        </form>

                                                        
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <br>
                    <div>
                        <h3 id="RAdded">Recently Added</h3>
                        <div class="bg">
                            <?php foreach ($recentAdd as $row): ?>
                                <div class="column">
                                    <div class="flip-card anime-tiles container mt-3">
                                        <div class="flip-card-inner">
                                            <div class="flip-card-front">
                                                <img src="<?php echo $row['picURL']; ?>" alt="Card image" style="height:100%; width:100%;">
                                            </div>
                                            <div class="flip-card-back">
                                                <br/>
                                                <div>
                                                    <h4><?php echo $row['animeTitle']; ?></h4>
                                                </div>
                                                <br/>
                                                <div>
                                                    <p style="font-size: 15px;"><?php echo $row['rating']; ?></p>
                                                    <p style="font-size: 15px;"><?php echo $row['genre']; ?></p>
                                                </div>
                                                <div container>

                                                    <a href='animeInfo.php?action=view&animeID=<?=$row['animeID']?>' class="btn text-dark">View</a>
                                                    
                                                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                                                        <a href='animeInfo.php?action=edit&animeID=<?=$row['animeID']?>' class="btn text-dark">Edit</a>
                                                    <?php else: ?>
                                                        <a href='animeInfo.php?action=edit&animeID=<?=$row['animeID']?>' disabled style="display: none;" class="btn text-dark">Edit</a>
                                                    <?php endif; ?>

                                                    <?php if ( $_SESSION['isAdmin'] == 1): ?>
                                                        <form action="homePage.php" method="post">
                                                            <input type="hidden" name="animeID" value="<?= $row['animeID'] ?>" />
                                                            
                                                            <button type="submit" class="btn text-dark">Delete</button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form action="homePage.php" method="post">
                                                            <input type="hidden" name="animeID" value="<?= $row['animeID'] ?>" />
                                                            
                                                            <button type="submit" disabled style="display: none;" class="btn text-dark">Delete</button>
                                                        </form>

                                                        
                                                    <?php endif; ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
            
                    </div>
                    <br><br><br><br><br><br><br><br><br>
            </div>
        </div>

    </div>
    


    <br><br><br><br><br><br><br>
    <footer>
        <div>
            <ul class="nav" style="background-color: #202531 ;">
                <li class="nav-item">
                  <h3 id="Animedia-Footer">ANIMEDIA</h3>
                </li>
                
              </ul>
        </div>
    </footer>


    <script>
        document.querySelector(".side-panel-toggle").addEventListener("click", () => {document.querySelector(".wrapper").classList.toggle("side-panel-open");})
    </script>

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