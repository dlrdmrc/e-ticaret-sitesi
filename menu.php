<?php
    include 'components/connect.php';

    if (isset($_COOKIE['kullanici_id'])) {
        $kullanici_id = $_COOKIE['kullanici_id'];
    }else{
        $kullanici_id = '';
    }


    include 'components/add_wishlist.php';
    include 'components/add_cart.php';


?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serin Lezzet - dükkanımız</title>

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

    <div class="products">
        <div class="heading">
            <h1>yeni lezzetimiz</h1>
            <img src="image/dashboard.png">
        </div>
        <div class="box-container">
            <?php
            $select_products = $conn->prepare("SELECT * FROM ürünler WHERE dürüm = ?");
            $select_products->execute(['active']);

            if ($select_products->rowCount() > 0) {
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){


            ?>
    <form action="" method="post" class="box <?php if($fetch_products['stok'] == 0){echo "disabled";} ?>">

        <img src="uploaded_files/<?= $fetch_products['resim']; ?>" class="image">
        <?php if($fetch_products['stok'] > 9){ ?>
            <span class="stock" style="color: green;">stokta var</span>
        <?php }elseif($fetch_products['stok'] == 0){ ?>
            <span class="stock" style="color: red;">stokta yok</span>
        <?php }else{ ?>
            <span class="stock" style="color: red;">acele et, sadece <?= $fetch_products['stok']; ?></span>   
        <?php }?>
        <div class="content">
            <div class="button">
                <div> <h3 class="name"><?= $fetch_products['isim']; ?></h3> </div>
                <div>
                    <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                    <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                    <a href="view_page.php?pid=<?= $fetch_products['id'] ?>" class="bx bx-show"></a>
                </div>
            </div>
            <p class="price">fiyat ₺<?= $fetch_products['fiyat']; ?></p>
            <input type="hidden" name="ürün_id" value="<?= $fetch_products['id'] ?>">
            <div class="flex-btn">
                <a href="checkout.php?get_id=<?= $fetch_products['id'] ?>" class="btn">şimdi satın al</a>
                <input type="number" name="adet" required min="1" value="1" max="99" maxlength="2" class="qty box">
            </div>
        </div>
    </form>
    <?php            
                }
            }else{
                echo '
                    <div class="empty">
                        <p>henüz ürün eklenmedi!</p>
                    </div>
                ';

            }
    ?>
        </div>
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
