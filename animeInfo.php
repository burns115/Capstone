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
            $result = addRecord($animeTitle, $rating, $lang, $genre, $animeDesc, $picURL); 

            header('Location: homepage.php'); 
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
            $result = editRecord($animeID, $animeTitle, $rating, $lang, $genre, $animeDesc, $picURL); 

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
</head>
<body>

    <form class="col-lg-6 offset-lg-3" action = 'animeInfo.php' method='post'>

        <input type='hidden' name='action' value='<?= $action ?>'>
        <input type='hidden' name='animeID' value='<?= $animeID ?>'>
        <br/>
        <div class="form-group">

            <div class='col-sm-10'>

                <?=var_dump($_POST);?>
                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <input type='text' readonly class='form-control' id='animeTitle' name='animeTitle' placeholder='Enter Title Here...' value='<?= $animeTitle ?>'>
                <?php else: ?>
                    <input type='text' class='form-control' id='animeTitle' name='animeTitle' placeholder='Enter Title Here...' value='<?= $animeTitle ?>'>
                <?php endif; ?>
                    
                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <input type='text' readonly class='form-control' id='lang' name='lang' placeholder='Language' value='<?= $lang ?>'>
                <?php else: ?>
                    <input type='text' class='form-control' id='lang' name='lang' placeholder='Language' value='<?= $lang ?>'>
                <?php endif; ?>

                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <input type='text' readonly class='form-control' id='genre' name='genre' placeholder='genre' value='<?= $genre ?>'>
                <?php else: ?>
                    <input type="checkbox" id="genre" name="genre" value="Action">
                    <label for="Action">Action</label>
                    <input type="checkbox" id="genre" name="genre" value="Comedy">
                    <label for="Comedy">Comedy</label>
                    <input type="checkbox" id="genre" name="genre" value="Supernatural">
                    <label for="Supernatural">Supernatural</label>
                <?php endif; ?>

                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <input type='text' readonly class='form-control' id='picURL' name='picURL' placeholder='Picture URL Here' value='<?= $picURL ?>'>
                <?php else: ?>
                    <input type='text' class='form-control' id='picURL' name='picURL' placeholder='Picture URL Here' value='<?= $picURL ?>'>
                <?php endif; ?>

            </div>

        </div>

        </div>
        <br/>
        <div class="form-group">
            <div class='col-sm-10'>
                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <input type='number' readonly class='form-control' id='rating' name='rating' placeholder='rating' value='<?= $rating ?>'>
                <?php else: ?>
                    <input type='number' class='form-control' id='rating' name='rating' placeholder='rating' value='<?= $rating ?>'>
                <?php endif; ?>
            </div>
        </div>
        <br/>
        <div class="form-group">

            <div class='col-sm-10'>

                <?php if ( $action == 'view' OR $_SESSION['isAdmin'] == 0): ?>
                    <textarea type='text' readonly class='form-control' id='animeDesc' name='animeDesc' placeholder='Enter Description Here...' value='<?= $animeDesc ?>'> <?= $animeDesc ?> </textarea>
                <?php else: ?>
                    <textarea type='text' class='form-control' id='animeDesc' name='animeDesc' placeholder='Enter Description Here...' value='<?= $animeDesc ?>'><?= $animeDesc ?></textarea>
                <?php endif; ?>
            </div>


        </div>
        <br/>
        
        <div class='form-group'>

            <div class='col-sm-offset-2 col-sm-10'>
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