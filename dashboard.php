<?php
    include '../components/connect.php';

    if (isset($_COOKIE['satici_id'])) {
        $satici_id = $_COOKIE['satici_id'];
    }else{
        $satici_id = '';
        header('location:login.php');
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

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


</head>
<body>

    <div class="main_container">
        <?php include '../components/admin_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>kontrol paneli</h1>
                <img src="../image/dashboard.png">
            </div>
            <div class="box-container">
                <div class="box">
                    <h3>Hoş Geldin !</h3>
                    <p><?= $fetch_profile['isim']; ?></p>
                    <a href="update.php" class="btn">profili güncelle</a>
                </div>
                
                <div class="box">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM ürünler WHERE satici_id = ?");
                        $select_products->execute([$satici_id]);
                        $number_of_products = $select_products->rowCount();
                    ?>
                    <h3><?= $number_of_products; ?></h3>
                    <p>eklenen ürünler</p>
                    <a href="add_products.php" class="btn">ürün ekle</a>
                </div>
                <div class="box">
                    <?php
                        $select_active_products = $conn->prepare("SELECT * FROM ürünler WHERE satici_id = ? AND dürüm = ?");
                        $select_active_products->execute([$satici_id, 'active']);
                        $number_of_active_products = $select_active_products->rowCount();
                    ?>
                    <h3><?= $number_of_active_products; ?></h3>
                    <p>toplam aktif ürünler</p>
                    <a href="view_product.php" class="btn">aktif ürün</a>
                </div>
                <div class="box">
                    <?php
                        $select_deactive_products = $conn->prepare("SELECT * FROM ürünler WHERE satici_id = ? AND dürüm = ?");
                        $select_deactive_products->execute([$satici_id, 'deactive']);
                        $number_of_deactive_products = $select_deactive_products->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_products; ?></h3>
                    <p>toplam devre dışı ürünler</p>
                    <a href="view_product.php" class="btn">devre dışı ürün</a>
                </div>
                
                
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