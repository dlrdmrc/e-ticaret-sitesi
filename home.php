<?php 
    include 'components/connect.php';

    if (isset($_COOKIE['kullanici_id'])) {
        $kullanici_id = $_COOKIE['kullanici_id'];
    }else{
        $kullanici_id = '';
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serin Lezzet - Anasayfa</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
        
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <!------slider----->
    <div class="slider-container">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <h1>kendimizle gurur duyuyoruz <br> olağanüstü tatlar</h1>
                    <a href="menu.php" class="btn">şimdi alışveriş yap</a>
                </div>
                <div class="imgBox">
                    <img src="image/slider.jpg">
                </div>
            </div>
            <div class="slideBox">
                <div class="textBox">
                    <h1>kendimizle gurur duyuyoruz <br> olağanüstü tatlar</h1>
                    <a href="menu.php" class="btn">şimdi alışveriş yap</a>
                </div>
                <div class="imgBox">
                    <img src="image/slider4.jpg">
                </div>
            </div>
        </div>
        <ul class="controls">
            <li onclick="nextSlide();" class="next"> <i class="bx bx-right-arrow-alt"></i> </li>
            <li onclick="prevSlide();" class="prev"> <i class="bx bx-left-arrow-alt"></i> </li>
        </ul>
    </div>

    <div class="seller-login" style="text-align:center; margin: 30px 0;">
        <a href="admin panel/login.php" class="btn">Satıcı Girişi Yap</a>
    </div>

    <!------------service------------> 
<div class="service">
    <div class="box-container">
        <!--------- service item---->
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services4.jpg" class="img1">
                    <img src="image/services4.jpg" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>teslimat</h4>
                <span>100% güvenli</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services3.jpg" class="img1">
                    <img src="image/services3.jpg" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>ödeme</h4>
                <span>100% güvenli</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services2.jpg" class="img1">
                    <img src="image/services2.jpg" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>destek</h4>
                <span>7/24</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services1.jpg" class="img1">
                    <img src="image/services1.jpg" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>iade</h4>
                <span>7/24 ücretsiz iade</span>
            </div>
        </div>
        <div class="box">
            <div class="icon">
                <div class="icon-box">
                    <img src="image/services5.jpg" class="img1">
                    <img src="image/services5.jpg" class="img2">
                </div>
            </div>
            <div class="detail">
                <h4>hediye servisi</h4>
                <span>hediye servisine destek olun</span>
            </div>
        </div>
    </div>
</div>
<div class="categories">
    <div class="heading">
        <h1>kategori özellikleri</h1>
        <img src="image/dashboard.png">
    </div>
    <div class="box-container">
        <div class="box">
            <img src="image/vanilya.jpg">
            <a href="menu.php" class="btn">vanilya</a>
        </div>
        <div class="box">
            <img src="image/blueberry.jpg">
            <a href="menu.php" class="btn">yabanmersini</a>
        </div>
        <div class="box">
            <img src="image/bar.jpg">
            <a href="menu.php" class="btn">barlar</a>
        </div>
        <div class="box">
            <img src="image/sandiviç.jpg">
            <a href="menu.php" class="btn">sandviçler</a>
        </div>
    </div>
</div>





    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- custom js link -->
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>