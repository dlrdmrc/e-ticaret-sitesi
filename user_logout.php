<?php
    include 'connect.php';

    setcookie('kullanici_id', '', time() -1, '/');
    header('location: ../home.php');
?>