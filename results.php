<?php
session_start();

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn']))
    {
        header('Location: login.php');
    }

    include_once __DIR__ . '/sqlstuff/animeModel.php';
    include_once __DIR__ . '/navbar.php';

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
    
    if ($ratingFilter == "" AND $genreSelect == "")
    {
        $records = getRecord($searchTitle);

    }elseif ($ratingFilter == 1)
    {
        $records = filterRatingH2L($searchTitle);

    }elseif ($ratingFilter == 0)
    {
        $records = filterRatingL2H($searchTitle);

    }elseif ($genreSelect != "")
    {
        $records = getGenre($genre);
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>

    <style>
        .navbar 
        {
            padding-left : 5%;
            padding-right : 5%;
        }

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

        body 
        {
        font-family: Arial, Helvetica, sans-serif;
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

    <div class="row">
        <div class="filters">
            <form action="results.php" method="POST">

                <p>Genres:</p>
                <input type="checkbox" id="genre" name="genreSelect" value="Action">
                <label for="Action">Action</label><br>
                <input type="checkbox" id="genre" name="genreSelect" value="Comedy">
                <label for="Comedy">Comedy</label><br>
                <input type="checkbox" id="genre" name="genreSelect" value="Supernatural">
                <label for="Supernatural">Supernatural</label>

                <br><br>

                <p>Ratings:</p>
                <label for="ratingFilter">High -> Low</label>
                <input type="radio" name="ratingFilter" value="1"><br>
                
                <label for="ratingFilter">Low -> High</label>
                <input type="radio" name="ratingFilter" value="0"><br>

                <input type="submit" value="Apply">
            </form> 

        </div>
        <?=var_dump($_POST);?>
        <?php foreach ($records as $row): ?>

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
                                <p style="font-size: 15px;"><?php echo $row['lang']; ?></p>
                                <p style="font-size: 15px;"><?php echo $row['rating']; ?></p>
                                <p style="font-size: 15px;"><?php echo $row['genre']; ?></p>
                            </div>
                            <div container>
                                <?php if ( $_SESSION['isAdmin'] == 1): ?>
                                    <a href='animeInfo.php?action=edit&animeID=<?=$row['animeID']?>' class="btn text-dark">Edit</a>
                                <?php else: ?>
                                    <a href='animeInfo.php?action=edit&animeID=<?=$row['animeID']?>' disabled style="display: none;" class="btn text-dark">Edit</a>
                                <?php endif; ?>
                                
                                <a href='animeInfo.php?action=view&animeID=<?=$row['animeID']?>' class="btn text-dark">More Info</a>

                                <?php if ( $_SESSION['isAdmin'] == 1): ?>
                                    <form action="results.php" method="post">
                                        <input type="hidden" name="animeID" value="<?= $row['animeID'] ?>" />
                                        
                                        <button type="submit" class="btn text-dark">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <form action="results.php" method="post">
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

</body>
</html>