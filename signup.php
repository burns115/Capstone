<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <div class="container">

        <?php if (($action == 'add') OR (empty($_GET) AND empty($_POST))): ?>
            <h2>Sign-Up</h2>

        <?php elseif($action == 'edit'): ?> 
            <h2>Edit Song Information</h2>

        <?php endif; ?>

        <form class="col-lg-6 offset-lg-3" action = 'editMusic.php' method='post'>

            <input type='hidden' name='action' value='<?= $action ?>'>
            <input type='hidden' name='musicID' value='<?= $musicID ?>'>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='songTitle'>Song Title:</label>

                <div class='col-sm-10'>
                    <input type='text' class='form-control' id='songTitle' name='songTitle' value='<?= $songTitle ?>'>
                </div>

            </div>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='artistName'>Artist Name:</label>

                <div class='col-sm-10'>
                    <input type='text' class='form-control' id='artistName' name='artistName' value='<?= $artistName ?>'>
                </div>

            </div>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='recordCom'>Record Company:</label>

                <div class='col-sm-10'>
                    <input type='text' class='form-control' id='recordCom' name='recordCom' value='<?= $recordCom ?>'>
                </div>

            </div>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='genre'>Genre:</label>

                <div class='col-sm-10'>
                    <input type='text' class='form-control' id='genre' name='genre' value='<?= $genre ?>'>
                </div>

            </div>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='songDuration'>Duration (sec.):</label>

                <div class='col-sm-10'>
                    <input type='text' class='form-control' id='songDuration' name='songDuration' value='<?= $songDuration ?>'>
                </div>

            </div>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='released'>Released:</label>

                <div class='col-sm-10'>
                <?php if ($released == 1): ?>
                    <input type="radio" name="released" value="1" checked>Yes <input type="radio" name="released" value="0">No

                <?php elseif($released == 0): ?>
                    <input type="radio" name="released" value="1">Yes <input type="radio" name="released" value="0" checked>No

                <?php else:?>
                    <input type="radio" name="released" value="1">Yes <input type="radio" name="released" value="0">No

                <?php endif;?>
                </div>
            </div>
            <br/>
            <div class="form-group">
                <label class='control-label col-sm-2' for='releaseDate'>Date Released:</label>

                <div class='col-sm-10'>
                    <input type="date" name="releaseDate" value='<?= $releaseDate ?>'>
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

        <br/><br/>

        <a href='./login.php' class="btn btn-default">Back to Log-In Page</a>
    </div>
</body>
</html>