<?php

include_once (__DIR__ . '/db.php');

    function getRecord($animeTitle){ //aquires the records values
        global $db;

        $sql = "SELECT animeID, animeTitle, rating, lang, genre, animeDesc, picURL FROM anime_lookup WHERE 0=0";//selects the values from the patients table and sets it as a variable

        $results = [];

        $binds = [];

        if ($animeTitle != ""){// if song title value is not empty then add the values
            $sql .= " AND animeTitle LIKE :bAnimeTitle";
            $binds['bAnimeTitle'] = '%' . $animeTitle . '%'; 
            
        }

        $stmt = $db->prepare($sql);

        if ($stmt->execute($binds) && $stmt->rowCount() > 0 ){
            $results = $stmt->fetchall(PDO::FETCH_ASSOC);//adds search results in variable $results
        }

        return ($results);//returns search results
    }

    function filterRating($animeTitle){ //aquires the records values
        global $db;

        $sql = "SELECT animeID, animeTitle, rating, lang, genre, animeDesc, picURL FROM anime_lookup WHERE rating ";//selects the values from the patients table and sets it as a variable

        $results = [];

        $binds = [];

        if ($animeTitle != ""){// if song title value is not empty then add the values
            $sql .= " AND animeTitle LIKE :bAnimeTitle";
            $binds['bAnimeTitle'] = '%' . $animeTitle . '%'; 
            
        }

        $stmt = $db->prepare($sql);

        if ($stmt->execute($binds) && $stmt->rowCount() > 0 ){
            $results = $stmt->fetchall(PDO::FETCH_ASSOC);//adds search results in variable $results
        }

        return ($results);//returns search results
    }

    function getUser($username){//gets a specific record from the table
        global $db;

        $sql = "SELECT userID, username, encPword, phoneNumber, pronouns, isActive, isAdmin, profilePic, salt, email FROM user_lookup WHERE 0=0";//selects the values from the patients table and sets it as a variable

        $results = [];

        $binds = [];

        if ($username != ""){// if song title value is not empty then add the values
            $sql .= " AND username LIKE :bUsername";
            $binds['bUsername'] = '%' . $username . '%'; 
            
        }

        $stmt = $db->prepare($sql);

        if ($stmt->execute($binds) && $stmt->rowCount() > 0 ){
            $results = $stmt->fetchall(PDO::FETCH_ASSOC);//adds search results in variable $results
        }

        return ($results);//returns search results
    }

    function addRecord($animeTitle, $rating, $lang, $genre, $animeDesc, $picURL){//this function is used to add music into the table

        global $db;
        $stmt = $db->prepare("INSERT INTO anime_lookup SET animeTitle = :bAnimeTitle, rating = :bRating, lang = :bLang, genre = :bGenre, animeDesc = :bAnimeDesc, picURL = :bPicURL");

        $binds = array(//places values into an array
            ":bAnimeTitle" => $animeTitle,
            ":bRating" => $rating,
            ":bLang" => $lang,
            ":bGenre" => $genre,
            ":bAnimeDesc" => $animeDesc,
            ":bPicURL" => $picURL
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0 ){
            $results = "Data added.";
        }

        return ($results);//returns results
    }

    function editRecord($animeID, $animeTitle, $rating, $lang, $genre, $animeDesc, $picURL){//function used to update/edit music info
        global $db;

        $results = "";//set results to an empty string

        $stmt = $db->prepare("UPDATE anime_lookup SET animeTitle = :bAnimeTitle, rating = :bRating, lang = :bLang, genre = :bGenre, animeDesc = :bAnimeDesc, picURL = :bPicURL WHERE animeID = :bAnimeID");

        $binds = array(//places new values into the array
            ":bAnimeID" => $animeID,
            ":bAnimeTitle" => $animeTitle,
            ":bRating" => $rating,
            ":bLang" => $lang,
            ":bGenre" => $genre,
            ":bAnimeDesc" => $animeDesc,
            ":bPicURL" => $picURL
        );

        if ($stmt->execute($binds) AND $stmt->rowCount() > 0){
            $results = "Data updated";
        }

        return ($results);//returns updated values
    }

    function deleteRecord ($animeID) {//deletes music from the table
        global $db;
        
        $results = "Data was not deleted";
        $stmt = $db->prepare("DELETE FROM anime_lookup WHERE animeID=:bAnimeID");
        
        $binds = array(
            ":bAnimeID" => $animeID
        );
        
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = 'Data Deleted';
        }
        
        return ($results);//returns table results
    }

    

    function getARecord($animeID){//gets a specific record from the table
        global $db;

        $result = [];
        $stmt = $db->prepare("SELECT animeID, animeTitle, rating, lang, genre, animeDesc, picURL FROM anime_lookup WHERE animeID=:bAnimeID");

        $binds = array(//adds the anime id into an array
            ":bAnimeID" => $animeID
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return($results);//returns results of search
    }

    function getAUser($username){//used to verify a user
        global $db;

        $result = [];
        $stmt = $db->prepare("SELECT userID, email, username, encPword, phoneNumber, pronouns, isActive, isAdmin, salt FROM user_lookup WHERE username=:bUsername");

        $binds = array(//places the username into an array
            ":bUsername" => $username
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {//if the username is active then it will allow login
            $results = $stmt->fetch(PDO::FETCH_ASSOC);

        } else{
            $results = "No user found.";//if username is not valid it will prompt an error
        }

        return($results); //returns the result
    }

    function addAUser($username, $encPword, $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt, $email){//this function is used to add music into the table

        global $db;
        $stmt = $db->prepare("INSERT INTO user_lookup SET email = :bEmail, username = :bUsername, encPword = :bEncPword, phoneNumber = :bPhoneNumber, pronouns = :bPronouns, isActive = :bIsActive, isAdmin = :bIsAdmin, profilePic = :bProfilePic, salt = :bSalt");

        $binds = array(//places values into an array
            ":bUsername" => $username,
            ":bEncPword" => $encPword,
            ":bPhoneNumber" => $phoneNumber,
            ":bPronouns" => $pronouns,
            ":bIsActive" => $isActive,
            ":bIsAdmin" => $isAdmin,
            ":bProfilePic" => $profilePic,
            ":bSalt" => $salt,
            ":bEmail" => $email
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0 ){
            $results = "Data added.";
        }

        return ($results);//returns results
    }

    function editAUser($userID, $email, $username, $encPword, $phoneNumber, $pronouns, $isActive, $isAdmin, $profilePic, $salt){//function used to update/edit music info
        global $db;

        $results = "";//set results to an empty string

        $stmt = $db->prepare("UPDATE user_lookup SET email = :bEmail, username = :bUsername, encPword = :bEncPword, phoneNumber = :bPhoneNumber, pronouns = :bPronouns, isActive = :bIsActive, isAdmin = :bIsAdmin, profilePic = :bProfilePic, salt = :bSalt WHERE userID = :bUserID");

        $binds = array(//places new values into the array
            ":bUserID" => $userID,
            ":bEmail" => $email,
            ":bUsername" => $username,
            ":bEncPword" => $encPword,
            ":bPhoneNumber" => $phoneNumber,
            ":bPronouns" => $pronouns,
            ":bIsActive" => $isActive,
            ":bIsAdmin" => $isAdmin,
            ":bProfilePic" => $profilePic,
            ":bSalt" => $salt
        );

        if ($stmt->execute($binds) AND $stmt->rowCount() > 0){
            $results = "Data updated";
        }

        return ($results);//returns updated values
    }
    
?>