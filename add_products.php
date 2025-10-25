<?php
    include '../components/connect.php';

    if (isset($_COOKIE['satici_id'])) {
        $satici_id = $_COOKIE['satici_id'];
    }else{
        $satici_id = '';
        header('location:login.php');
    }

    //veritabanına ürün eklme
    if (isset($_POST['publish'])){

        $id = unique_id();
        $isim = $_POST['isim'];
        $isim = strip_tags($isim);

        $fiyat = $_POST['fiyat'];
        $fiyat = strip_tags($fiyat);

        $description = $_POST['description'];
        $description = strip_tags($description);

        $stok = $_POST['stok'];
        $stok = strip_tags($stok);
        $dürüm = 'active';

        $resim = $_FILES['resim']['name'];
        $resim = strip_tags($resim);
        $image_size = $_FILES['resim']['size'];
        $image_tmp_name = $_FILES['resim']['tmp_name'];
        $image_folder = '../uploaded_files/'.$resim;

        $select_image = $conn->prepare("SELECT * FROM ürünler WHERE resim = ? AND satici_id = ?");
        $select_image->execute([$resim,$satici_id]);

        if (isset($resim)) {
            if ($select_image->rowCount() > 0){
                $warning_msg[] = 'resim adı tekrarlandı';
            }elseif ($image_size > 2000000) {
                $warning_msg[] = 'resim boyutu çok büyük';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        }else{
            $resim = '';
        }
        if ($select_image->rowCount() > 0 AND $resim !='') {
            $warning_msg[] = 'lütfen resminizin adını değştirin';
        }else{
            $insert_product = $conn->prepare("INSERT INTO ürünler (id, satici_id, isim, fiyat, resim, stok, ürün_detay, dürüm) VALUES(?,?,?,?,?,?,?,?)");
            $insert_product->execute([$id, $satici_id, $isim, $fiyat, $resim, $stok, $description, $dürüm]);
            $success_msg[] = 'ürün başarıyla eklendi';
        }

    }

if (isset($_POST['draft'])){

        $id = unique_id();
        $isim = $_POST['isim'];
        $isim = strip_tags($isim);

        $fiyat = $_POST['fiyat'];
        $fiyat = strip_tags($fiyat);

        $description = $_POST['description'];
        $description = strip_tags($description);

        $stok = $_POST['stok'];
        $stok = strip_tags($stok);
        $dürüm = 'deactive';

        $resim = $_FILES['resim']['name'];
        $resim = strip_tags($resim);
        $image_size = $_FILES['resim']['size'];
        $image_tmp_name = $_FILES['resim']['tmp_name'];
        $image_folder = '../uploaded_files/'.$resim;

        $select_image = $conn->prepare("SELECT * FROM ürünler WHERE resim = ? AND satici_id = ?");
        $select_image->execute([$resim,$satici_id]);

        if (isset($resim)) {
            if ($select_image->rowCount() > 0){
                $warning_msg[] = 'resim adı tekrarlandı';
            }elseif ($image_size > 2000000) {
                $warning_msg[] = 'resim boyutu çok büyük';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        }else{
            $resim = '';
        }
        if ($select_image->rowCount() > 0 AND $resim !='') {
            $warning_msg[] = 'lütfen resminizin adını değştirin';
        }else{
            $insert_product = $conn->prepare("INSERT INTO ürünler (id, satici_id, isim, fiyat, resim, stok, ürün_detay, dürüm) VALUES(?,?,?,?,?,?,?,?)");
            $insert_product->execute([$id, $satici_id, $isim, $fiyat, $resim, $stok, $description, $dürüm]);
            $success_msg[] = 'ürün taslak olarak başarıyla kaydedildi';
        }

    }

?>    

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serin Lezzet - Yönetici Ürün Ekleme Sayfası</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
        
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


</head>
<body>

    <div class="main_container">
        <?php include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <div class="heading">
                <h1>ürün ekle</h1>
                <img src="../image/dashboard.png">
            </div>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <p>ürün adı <span>*</span> </p>
                        <input type="text" name="isim" maxlength="100" placeholder="ürün adı ekle" required class="box">
                    </div>
                    <div class="input-field">
                        <p>ürün fiyatı <span>*</span> </p>
                        <input type="number" name="fiyat" maxlength="100" placeholder="ürün fiyatını ekle" required class="box">
                    </div>
                    <div class="input-field">
                        <p>ürün detayı <span>*</span> </p>
                        <textarea name="description" required maxlength="1000" placeholder="ürün detayı ekle" class="box"></textarea>
                    </div>
                    <div class="input-field">
                        <p>ürün stoğu <span>*</span> </p>
                        <input type="number" name="stok" maxlength="10" min="0" max="9999999999" placeholder="ürün stoğu ekle" required class="box">
                    </div>
                    <div class="input-field">
                        <p>ürün resmi <span>*</span> </p>
                        <input type="file" name="resim" accept="image/*" required class="box">
                    </div>
                    <div class="flex-btn">
                        <input type="submit" name="publish" value="ürün ekle" class="btn">
                        <input type="submit" name="draft" value="taslak olarak kaydet" class="btn">
                    </div>
                </form>
            </div>
        </section>
    </div>
    




    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- custom js link -->
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>

</body>
</html>