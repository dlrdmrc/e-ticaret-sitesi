<?php
    include 'components/connect.php';

    if (isset($_COOKIE['kullanici_id'])) {
        $kullanici_id = $_COOKIE['kullanici_id'];
    }else{
        $kullanici_id = '';
    }

    $pid = $_GET['pid'];

    include 'components/add_wishlist.php';
    include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serin Lezzet - ürün detay Sayfası</title>

    <link rel="stylesheet" href="css/user_style.css">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <section class="view_page">
        <div class="heading">
            <h1>Ürün Detay</h1>
            <img src="image/dashboard.png">
        </div>
        <?php
            if (isset($_GET['pid'])) {
                $pid = $_GET['pid'];
                $select_products = $conn->prepare("SELECT * FROM ürünler WHERE id = ?");
                $select_products->execute([$pid]);

                if ($select_products->rowCount() > 0) {
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>
        <form action="" method="post" class="box">
            <div class="img-box">
                <img src="uploaded_files/<?= $fetch_products['resim']; ?>">
            </div>
            <div class="detail">
                <?php if($fetch_products['stok'] > 9){ ?>
                    <span class="stock" style="color:green;">stokta var</span>
                <?php }elseif($fetch_products['stok'] == 0){ ?>
                    <span class="stock" style="color:red;">stokta yok</span>
                <?php }else{ ?>
                    <span class="stock" style="color:reed;">acele et, sadece <?= $fetch_products['stok']; ?> left</span>
                <?php } ?>
                <p class="price">₺<?= $fetch_products['fiyat']; ?></p>
                <div class="name"><?= $fetch_products['isim']; ?></div>
                <p class="product-detail"><?= $fetch_products['ürün_detay']; ?></p>
                <input type="hidden" name="ürün_id" value="<?= $fetch_products['id']; ?>">
                <div class="button">
                    <button type="submit" name="add_to_wishlist" class="btn">favorilere ekle <i class="bx bx-heart"></i></button>
                    <input type="submit" name="adet" value="1" min="0" vlass="quantity">
                    <button type="submit" name="add_to_cart" class="btn">sepete ekle <i class="bx bx-cart"></i></button>
                </div>
            </div>
        </form>
        <?php
                    }
                }
            }
        ?>
    </section>
        


<!-- SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Custom JS -->
<script src="js/user_script.js"></script>

<?php include 'components/alert.php'; ?>

</body>
</html>
