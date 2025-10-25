<?php
    include 'connect.php';

    setcookie('kullanici_id', '', time() -1, '/');
    header('location: ../admin panel/login.php');
?>