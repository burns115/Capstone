<?php
session_start();//starts session
session_unset();//empties session
session_destroy();//ends session
header('Location: login.php');//redirects user
?>