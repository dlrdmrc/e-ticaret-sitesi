<?php
    include 'components/connect.php';

    if (isset($_COOKIE['kullanici_id'])) {
        $kullanici_id = $_COOKIE['kullanici_id'];
    }else{
        $kullanici_id = '';
    }

    if (isset($_POST['submit'])) {

        $id = unique_id();

        // Temiz veriler
        $isim = trim($_POST['isim']);
        $email = trim($_POST['email']);
        $şifre = $_POST['şifre'];
        $cpass = $_POST['cpass'];

        // Görsel işlemleri
        $image = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

        // Benzersiz dosya adı
        $image_folder = 'uploaded_files/' . $image;

        // Email kontrolü
        $select_seller = $conn->prepare("SELECT * FROM kullanıcılar WHERE email = ?");
        $select_seller->execute([$email]);

        if ($select_seller->rowCount() > 0) {
            $warning_msg[] = 'Bu e-posta zaten kayıtlı!';
        } elseif ($şifre !== $cpass) {
            $warning_msg[] = 'Şifreler eşleşmiyor!';
        } elseif (!in_array($ext, $allowed_extensions)) {
            $warning_msg[] = 'Sadece JPG, PNG, JPEG veya WEBP dosya uzantısı kabul edilir.';
        } elseif ($image_size > 2 * 1024 * 1024) {
            $warning_msg[] = 'Dosya boyutu 2MB\'den büyük olamaz.';
        } else {
            // Şifre güvenli hale getir
            $password_to_save = $şifre;

            // Veritabanına ekle
            $insert_seller = $conn->prepare("INSERT INTO kullanıcılar(id, isim, email, şifre, resim) VALUES(?, ?, ?, ?, ?)");
            $insert_seller->execute([
                $id,
                htmlspecialchars($isim, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
                $password_to_save,
                $image
            ]);

            // Dosyayı taşı
            move_uploaded_file($image_tmp_name, $image_folder);

            $success_msg[] = 'Yeni kullanıcı başarıyla kaydedildi! Giriş yapabilirsiniz.';
        }
    }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serin Lezzet - Satıcı Kayıt Sayfası</title>

    <link rel="stylesheet" href="css/user_style.css">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

</head>
<body>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="register">
        <h3>Şimdi Kaydol</h3>

        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>Adınız <span>*</span></p>
                    <input type="text" name="isim" placeholder="Adınızı giriniz." maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>E-postanız <span>*</span></p>
                    <input type="email" name="email" placeholder="E-postanızı giriniz." maxlength="50" required class="box">
                </div>    
            </div>    
            <div class="col">
                <div class="input-field">
                    <p>Şifreniz <span>*</span></p>
                    <input type="password" name="şifre" placeholder="Şifrenizi giriniz." maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>Şifreyi Onayla <span>*</span></p>
                    <input type="password" name="cpass" placeholder="Şifrenizi tekrar girin." maxlength="50" required class="box">
                </div>    
            </div>  
        </div>  

        <div class="input-field">
            <p>Profil Resminiz <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
        </div>

        <p class="link">Zaten bir hesabınız var mı? <a href="login.php">Giriş yap.</a></p>

        <input type="submit" name="submit" value="Kaydol" class="btn">
    </form>         
</div>

<!-- SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Custom JS -->
<script src="js/user_script.js"></script>

<?php include 'components/alert.php'; ?>

</body>
</html>
