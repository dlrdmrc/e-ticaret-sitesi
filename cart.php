<?php
    include 'components/connect.php';

    if (isset($_COOKIE['kullanici_id'])) {
        $kullanici_id = $_COOKIE['kullanici_id'];
    }else{
        $kullanici_id = 'location:login.php';
    }


//sepet adetini güncelleme
    if (isset($_POST['update_cart'])) {

        $cart_id = $_POST['cart_id'];
        $cart_id = strip_tags($cart_id);

        $adet = $_POST['adet'];
        $adet = strip_tags($adet);

        $update_qty = $conn->prepare("UPDATE cart SET adet = ? WHERE id = ?");
        $update_qty->execute([$adet, $cart_id]);

        $success_msg[] = 'sepet miktarı başarıyla güncellendi';
    }


//sepetten ürün silme
    if (isset($_POST['delete_item'])) {
        $cart_id = $_POST['cart_id'];
        $cart_id = strip_tags($cart_id);

        $verify_delete_item = $conn->prepare("SELECT * FROM cart WHERE id = ?");
        $verify_delete_item->execute([$cart_id]);

        if ($verify_delete_item->rowCount() > 0) {
            $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE id = ?");
            $delete_cart_id->execute([$cart_id]);

            $success_msg[] = 'sepet öğesi başarıyla silindi';
        }else{
            $warning_msg[] = 'sepet öğesi zaten silindi';
        }
    }

//sepeti boşlatma
    if (isset($_POST['empty_cart'])) {

        $verify_empty_item = $conn->prepare("SELECT * FROM cart WHERE kullanici_id = ?");
        $verify_empty_item->execute([$kullanici_id]);

        if ($verify_empty_item->rowCount() > 0) {
            
            $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE kullanici_id = ?");
            $delete_cart_id->execute([$kullanici_id]);

            $success_msg[] = 'sepet başarıyla boşaltıldı';
        }else{
            $warning_msg[] = 'sepetiniz zaten boş';
        }
    }
   
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serin Lezzet - Sepetiniz</title>

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
            <h1>Sepetim</h1>
            <img src="image/dashboard.png">
        </div>
        <div class="box-container">
            <?php
            $grand_total = 0;
            $select_cart = $conn->prepare("SELECT * FROM cart WHERE kullanici_id = ?");
            $select_cart->execute([$kullanici_id]);

           


            if ($select_cart->rowCount() > 0) {
                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                    $select_products = $conn->prepare("SELECT * FROM ürünler WHERE id = ?");
                    $select_products->execute([$fetch_cart['ürün_id']]);

                    if ($select_products->rowCount() > 0) {
                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);

                        $adet = (int) $fetch_cart['adet'];
                        $fiyat = (int) $fetch_products['fiyat'];
                        $sub_total = $adet * $fiyat;
                 

            ?>
            <form action="" method="post" class="box <?php if($fetch_products['stok'] == 0){echo 'disabled';}; ?>">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <img src="uploaded_files/<?= $fetch_products['resim']; ?>" class="image">
                <?php if($fetch_products['stok'] > 9) { ?>
                    <span class="stock" style="color: green;">stokta var</span>
                <?php }elseif($fetch_products['stok'] == 0) { ?>
                    <span class="stock" style="color: red;">stokta yok</span>
                <?php }else{ ?>
                    <span class="stock" style="color: red;">acele et, sadece <?= $fetch_products['stok']; ?> left</span>
                <?php } ?>
                <div class="content">
                    <h3 class="name"><?= $fetch_products['isim']; ?></h3>
                    <div class="flex-btn">
                        <p class="price">fiyat ₺<?= $fetch_products['fiyat']; ?></p>
                        <input type="number" name="adet" required min="1" value="<?= $fetch_cart['adet'] ?>" max="99" maxlength="2" class="box qty">
                        <button type="submit" name="update_cart" class="bx bxs-edit fa-edit box">
                    </div>
                    <div class="flex-btn">
                        <p class="sub-total">ara toplam : <span>₺<?= $sub_total; ?></span></p>
                        <button type="submit" name="delete_item" class="btn" onclick="return confirm('sepetten kaldır');">sil</button>
                    </div>
                </div>
            </form>  
            <?php  
                        $grand_total += $sub_total;        
                        }else{
                            echo '
                                <div class="empty">
                                    <p>ürün bulunamadı!</p>
                                </div>
                            ';
                        }
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
        <?php if($grand_total != 0) { ?>
            <div class="cart-total">
                <p>ödenecek toplam tutar : <span> ₺ <?= $grand_total; ?></span></p>
                <div class="button">
                    <form action="" method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('sepetinizi boşaltmak istediğinizden emin misiniz?');">sepeti boşalt</button>
                    </form>
                    <a href="checkout.php" class="btn">kasaya doğru devam et</a>
                </div>
            </div>
        <?php } ?>
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
