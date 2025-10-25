<?php
    include '../components/connect.php';

    if (isset($_COOKIE['satici_id'])) {
        $satici_id = $_COOKIE['satici_id'];
    }else{
        $satici_id = '';
        header('location:login.php');
    }

    $select_products = $conn->prepare("SELECT * FROM ürünler WHERE satici_id = ?");
    $select_products->execute([$satici_id]);
    $total_products = $select_products->rowCount();

    $select_orders = $conn->prepare("SELECT * FROM siparişler WHERE satici_id = ?");
    $select_orders->execute([$satici_id]);
    $total_orders = $select_orders->rowCount();




?>    

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serin Lezzet - Satıcı Profil Sayfası</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
        
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


</head>
<body>

    <div class="main_container">
        <?php include '../components/admin_header.php'; ?>
        <section class="seller-profile">
            <div class="heading">
                <h1>Profil Ayrıntıları</h1>
                <img src="../image/dashboard.png">
            </div>
            <div class="details">
                <div class="seller">
                    <img src="../uploaded_files/<?= $fetch_profile['resim']; ?>">
                    <h3 class="name"><?= $fetch_profile['isim']; ?></h3>
                    <span>satıcı</span>
                    <a href="update.php" class="btn">profili güncelle</a>
                </div>
                <div class="flex">
                    <div class="box">
                        <span><?= $total_products; ?></span>
                        <p>toplam ürün</p>
                        <a href="view_product.php" class="btn">ürünleri görüntüle</a>
                    </div>
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