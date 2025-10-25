<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    $şifre = $_POST['şifre'];
    $şifre = htmlspecialchars($şifre, ENT_QUOTES, 'UTF-8');

    // E-postaya göre kullanıcıyı çek
    $select_seller = $conn->prepare("SELECT * FROM satıcılar WHERE email = ?");
    $select_seller->execute([$email]);
    $row = $select_seller->fetch(PDO::FETCH_ASSOC);

    // Kullanıcı bulunduysa ve şifre doğruysa (şifre DÜZ METİN olarak karşılaştırılır)
    if ($row && $şifre === $row['şifre']) {
        setcookie('satici_id', $row['id'], time() + 60*60*24*30, '/');
        header('Location: dashboard.php');
        exit;
    } else {
        $warning_msg[] = 'Yanlış e-posta veya şifre!';
    }
}
?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serin Lezzet - Satıcı Kayıt Sayfası</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
        
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

<div class="form-container">
        <form action= "" method="post" enctype="multipart/form-data" class="login">
            <h3>Şimdi Giriş Yap</h3>
            <div class="input-field">
                <p>E-postanız <span>*</span></p>
                <input type="email" name="email" placeholder="E-postanızı giriniz." maxlength="50" required class="box">
            </div> 
            <div class="input-field">
                <p>Şifreniz <span>*</span></p>
                <input type="password" name="şifre" placeholder="Şifrenizi giriniz." maxlength="50" required class="box">
            </div>   
            
            <p class="link"> Hesabınız yok mu? <a href="register.php">Şimdi kaydol.</a> </p>
            <input type="submit" name="submit" value="Giriş Yap" class="btn">
        </form>         
    </div>




    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- custom js link -->
    <script src="../js/script.js"></script>

    <?php include '../components/alert.php'; ?>

</body>
</html>