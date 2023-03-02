<?php 
    session_start();

    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn'])){
        header('Location: login.php');
    }

    include __DIR__ . '/sqlstuff/animeModel.php';
    include __DIR__ . '/navbar.php';

    if(isset($_GET['action'])){
        $error = "";
        $action = filter_input(INPUT_GET, 'action');
        $animeID = filter_input(INPUT_GET, 'animeID');
    

        if($action == "edit" OR $action == "view"){
            $row = getARecord($animeID);

            $animeTitle = $row['animeTitle'];

            $rating = $row['rating'];

            $lang = $row['lang'];

            $genre = $row['genre'];

            $animeDesc = $row['animeDesc'];

            $picURL = $row['picURL'];

        }else{
            $animeTitle = "";

            $rating = "";

            $lang = "";

            $genre = "";

            $animeDesc = "";

            $picURL = "";
        }

    } elseif (isset($_POST['action'])){
        $action = filter_input(INPUT_POST, 'action');

        $animeID = filter_input(INPUT_POST, 'animeID');
        
        $animeTitle = filter_input(INPUT_POST, 'animeTitle');
        if ($animeTitle == "") {
            $error .= "<li>Enter the Anime Title</li>";
        }
        
        $rating = filter_input(INPUT_POST, 'rating');
        if ($rating == "") {
            $error .= "<li>Enter the Rating</li>";
        }
        
        $lang = filter_input(INPUT_POST, 'lang');

        $genre = filter_input(INPUT_POST, 'genre');
        
        $animeDesc = filter_input(INPUT_POST, 'animeDesc');
        
        $picURL = filter_input(INPUT_POST, 'picURL');

        if ($error != "") {
            echo "<p class='error'>Please fix the following and resubmit</p>";
            echo "<ul class='error'>$error</ul>";
        }
    }

    if (isPostRequest() AND $action == 'add'){

        var_dump($_POST);
        $result = addRecord($animeTitle, $rating, $lang, $genre, $animeDesc, $picURL); 

        header('Location: homepage.php'); 

    } elseif (isPostRequest() AND $action == 'edit'){

        $result = editRecord($animeID, $animeTitle, $rating, $lang, $genre, $animeDesc, $picURL); 

        header('Location: homepage.php');
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
                <?php if ( $action == 'view'): ?>
                    <input type='text' readonly class='form-control' id='animeTitle' name='animeTitle' placeholder='Enter Title Here...' value='<?= $animeTitle ?>'>
                <?php else: ?>
                    <input type='text' class='form-control' id='animeTitle' name='animeTitle' placeholder='Enter Title Here...' value='<?= $animeTitle ?>'>
                <?php endif; ?>
                    
                <?php if ( $action == 'view'): ?>
                    <input type='text' readonly class='form-control' id='lang' name='lang' placeholder='Language' value='<?= $lang ?>'>
                <?php else: ?>
                    <input type='text' class='form-control' id='lang' name='lang' placeholder='Language' value='<?= $lang ?>'>
                <?php endif; ?>

                <?php if ( $action == 'view'): ?>
                    <input type='text' readonly class='form-control' id='genre' name='genre' placeholder='genre' value='<?= $genre ?>'>
                <?php else: ?>
                    <input type='text' class='form-control' id='genre' name='genre' placeholder='genre' value='<?= $genre ?>'>
                <?php endif; ?>

            </div>

        </div>

        </div>
        <br/>
        <div class="form-group">

            <div class='col-sm-10'>
                <input type='text' class='form-control' id='rating' name='rating' value='<?= $rating ?>'>
            </div>

        </div>
        <br/>
        <div class="form-group">

            <div class='col-sm-10'>
                <textarea type='text' class='form-control' id='animeDesc' name='animeDesc' placeholder='Enter Description Here...' value='<?= $animeDesc ?>'> <?= $animeDesc ?> </textarea>
            </div>

        </div>
        <br/>
        
        <div class='form-group'>

            <div class='col-sm-offset-2 col-sm-10'>

                <button type="submit" class='btn btn-primary'>Submit</button>

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