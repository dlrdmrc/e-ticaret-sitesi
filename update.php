<?php
    include '../components/connect.php';

    if (isset($_COOKIE['satici_id'])) {
        $satici_id = $_COOKIE['satici_id'];
    }else{
        $satici_id = '';
        header('location:login.php');
    }

    if (isset($_POST['submit'])) {

        $select_seller = $conn->prepare("SELECT * FROM satıcılar WHERE id = ? LIMIT 1");
        $select_seller->execute([$satici_id]);
        $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC);

        $prev_pass = $fetch_seller['şifre'];
        $prev_image = $fetch_seller['resim'];

        $isim = $_POST['isim'];
        $isim = strip_tags($isim);

        $email = $_POST['email'];
        $email = strip_tags('email');

        //isim güncelleme
        if (!empty($isim)) {
            $update_name = $conn->prepare("UPDATE satıcılar SET isim = ? WHERE id = ?");
            $update_name->execute([$isim, $satici_id]);
            $success_msg[] = 'kullanıcı adı başarıyla güncellendi';
        }

        //email güncelleme
        if (!empty($email)) {
            $select_email = $conn->prepare("SELECT * FROM satıcılar WHERE id = ? AND email = ?");
            $select_email->execute([$satici_id, $email]);

            if ($select_email->rowCount() > 0) {
                $warning_msg[] = 'bu mail zaten mevcut';
            }else{
                $update_email = $conn->prepare("UPDATE satıcılar SET email = ? WHERE id = ?");
                $update_email->execute([$email, $satici_id]);
                $success_msg[] = 'mail başarıyla güncellendi';
            }
        }

        // resim güncelleme
        $resim = $_FILES['resim']['isim'];
        $resim = strip_tags($resim);
        $ext = pathinfo($resim, PATHINFO_EXTENSION);
        $rename = unique_id().'.'.$ext;
        $image_size = $_FILES['resim']['tmp_name'];
        $image_tmp_name = $_FILES['resim']['tmp_name'];
        $image_folder = '../uploaded_files/'.$rename;

        if (!empty($resim)) {
            if ($image_size > 200000) {
                $warning_msg[] = 'resim boyutu çok büyük';
            }else{
                $update_image = $conn->prepare("UPDATE satıcılar SET resim = ? WHERE İD = ?");
                $update_image->execute([$rename, $satici_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                if ($prev_image != '' AND $prev_image != $rename) {
                    unlink('../uploaded_files/'.$prev_image);
                }
                $success_msg[] = 'resim başarıyla güncellendi';
            }
        }

        //şifre güncelleme

        $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

        $old_pass = sha1($__POST['old_pass']);
        $old_pass = strip_tags($old_pass);

        $new_pass = sha1($_POST['new_pass']);
        $new_pass = strip_tags($new_pass);

        $cpass = sha1($_POST['cpass']);
        $cpass = strip_tags($cpass);

        if ($old_pass != $empty_pass) {
            if ($old_pass != $prev_pass) {
                $warning_msg[] = 'eski şifre uyuşmuyor!';
            }elseif($new_pass != $cpass) {
                $warning_msg[] = 'şifre eşleşmedi doğrula!';
            }else{
                if($new_pass != $empty_pass) {
                    $update_pass = $conn->prepare("UPDATE satıcılar SET şifre = ? WHERE id = ?");
                    $update_pass->execute([$cpass, $satici_id]);
                    $success_msg[] = 'şifre başarıyla güncellendi!';
                }else{
                    $warning_msg[] = 'lütfen yeni bir şifre girin!';
                }
            }
        }

    }

   
?>    

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serin Lezzet - Profil Güncelleme Sayfası</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
        
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


</head>
<body>

    <div class="main_container">
        <?php include '../components/admin_header.php'; ?>
        <section class="form-container">
            <div class="heading">
                <h1>Profil Ayrıntılarını Güncelle</h1>
                <img src="../image/dashboard.png">
            </div>
            <form action="" method="post" enctype="multipart/form-data" class="register">
                <div class="img-box">
                    <img src="../uploaded_files/<?= $fetch_profile['resim']; ?>">
                </div>
                <div class="flex">
                    <div class="col">
                        <div class="input-field">
                            <p>Adınız <span>*</span></p>
                            <input type="text" name="isim" placeholder="<?= $fetch_profile['isim']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>mailiniz <span>*</span></p>
                            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p>resim seç <span>*</span></p>
                            <input type="file" name="resim" accept="image/*" class="box">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-field">
                            <p>eski şifreniz <span>*</span></p>
                            <input type="password" name="old_pass" placeholder="eski şifenizi girin" class="box">
                        </div>
                        <div class="input-field">
                            <p>yeni şifreniz <span>*</span></p>
                            <input type="password" name="new_pass" placeholder="yeni şifrenizi girin" class="box">
                        </div>
                        <div class="input-field">
                            <p>şifreyi onayla <span>*</span></p>
                            <input type="password" name="cpass" placeholder="şifrenizi onaylayın" class="box">
                        </div>
                    </div>    
                </div>
                <input type="submit" name="submit" value="profili güncelle" class="btn">
            </form>
        </section>
    </div>
    




    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- custom js link -->
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>

</body>
</html>