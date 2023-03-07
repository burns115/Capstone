

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Document</title>

    <style>
        .navbar 
        {
            padding-left : 5%;
            padding-right : 5%;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="homePage.php">Animedia</a>
        <form method='post' action='homepage.php'>
            <input type="text" placeholder="Search for an Anime..." name="titleInput">
            <button type="submit" class="btn text-dark">Search</button>
        </form>
            
        <a href="social.php">Social</a>
        <a href="settings.php?action=empty">Settings</a>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</body>
</html>