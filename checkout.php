<?php
    include 'components/connect.php';

    if (isset($_COOKIE['kullanici_id'])) {
        $kullanici_id = $_COOKIE['kullanici_id'];
    }else{
        $kullanici_id = '';
        header('location:login.php');
    }

    if (isset($_POST['place_order'])) {

        $isim = $_POST['isim'];
        $isim = strip_tags($isim);

        $numara = $_POST['numara'];
        $numara = strip_tags($numara);

        $email = $_POST['email'];
        $email = strip_tags($email);

        $adres = $_POST['flat']. ', '.$_POST['street'].', '.$_POST['city'].', '.$_POST['country'].', '.$_POST['pin'];
        $adres = strip_tags($adres);

        $adres_türü = $_POST['adres_türü'];
        $adres_türü = strip_tags($adres_türü);

        $yöntem = $_POST['yöntem'];
        $yöntem = strip_tags($yöntem);

        $verify_cart = $conn->prepare("SELECT * FROM cart WHERE kullanici_id = ?");
        $verify_cart->execute([$kullanici_id]);

        if (isset($_GET['get_id'])) {

            $get_product = $conn->prepare("SELECT * FROM ürünler WHERE id = ? LIMIT 1");
            $get_product->execute([$_GET['get_id']]);

            if ($get_product->rowCount() > 0) {
                while($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                    $satici_id = $fetch_p['satici_id'];

                    $insert_order = $conn->prepare("INSERT INTO siparişler(id, kullanici_id, satici_id, isim, numara, email, adres, adres_türü, yöntem, ürün_id, fiyat, adet) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                    $insert_order->execute([uniqid(), $kullanici_id, $satici_id, $isim, $numara, $email, $adres, $adres_türü, $yöntem, $fetch_p['id'], $fetch_p['fiyat'], 1]);

                }
            }else{
                $warning_msg[] = 'bir şeyler ters gitti';
            }
        }elseif($verify_cart->rowCount() > 0) {
            while($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
                $s_products = $conn->prepare("SELECT * FROM ürünler WHERE id = ? LIMIT 1");
                $s_products->execute([$f_cart['ürün_id']]);
                $f_product = $s_products->fetch(PDO::FETCH_ASSOC);

                $satici_id = $f_product['satici_id'];

                $insert_order = $conn->prepare("INSERT INTO siparişler(id, kullanici_id, satici_id, isim, numara, email, adres, adres_türü, yöntem, ürün_id, fiyat, adet) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $insert_order->execute([uniqid(), $kullanici_id, $satici_id, $isim, $numara, $email, $adres, $adres_türü, $yöntem, $f_cart['ürün_id'], $f_cart['fiyat'], $f_cart['adet']]);
            }
            if ($insert_order) {
                $delete_cart = $conn->prepare("DELETE FROM cart WHERE kullanici_id = ?");
                $delete_cart->execute([$kullanici_id]);
                header('location:order.php');
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serin Lezzet - ödeme Sayfası</title>

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

    <div class="checkout">
        <div class="heading">
            <h1>ödeme özeti</h1>
            <img src="image/dashboard.png">
        </div>
        <div class="row">
            <form action="" method="post" class="register">
                <input type="hidden" name="p_id" value="<?= $get_id; ?>">
                <h3>fatura ayrıntıları</h3>
                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>adınız<span>*</span></p>
                            <input type="text" name="isim" required maxlength="50" placeholder="adınızı girin" class="input">
                        </div>
                        <div class="input-field">
                            <p>numaranız<span>*</span></p>
                            <input type="number" name="numara" required maxlength="10" placeholder="numaranızı girin" class="input">
                        </div>
                        <div class="input-field">
                            <p>mailiniz<span>*</span></p>
                            <input type="email" name="email" required maxlength="50" placeholder="mailinizi girin" class="input">
                        </div>
                        <div class="input-field">
                            <p>Kart Üzerindeki İsim<span>*</span></p>
                            <input type="text" name="kart_isim" required maxlength="50" placeholder="Kart üzerindeki adı girin" class="input">
                        </div>
                        <div class="input-field">
                            <p>Kart Numarası<span>*</span></p>
                            <input type="text" name="kart_numara" required maxlength="19" placeholder="xxxx xxxx xxxx xxxx" class="input" pattern="\d{4} \d{4} \d{4} \d{4}">
                        </div>
                        <div class="input-field">
                            <p>Son Kullanma Tarihi<span>*</span></p>
                            <input type="month" name="son_kullanma" required class="input">
                        </div>
                        <div class="input-field">
                            <p>Güvenlik Kodu (CVV)<span>*</span></p>
                            <input type="text" name="cvv" required maxlength="4" placeholder="CVV" class="input" pattern="\d{3,4}">
                        </div>
                        <div class="input-field">
                            <p>adres türü<span>*</span></p>
                            <select name="adres_türü" class="input">
                                <option value="home">ev</option>
                                <option value="office">ofis</option>
                            </select>
                        </div>
                    </div>
                    <div class="box">
                        <div class="input-field">
                            <p>adres satırı 01<span>*</span></p>
                            <input type="text" name="flat" required maxlength="50" placeholder="daire veya bina adı" class="input">
                        </div>
                        <div class="input-field">
                            <p>adres satırı 02<span>*</span></p>
                            <input type="text" name="street" required maxlength="50" placeholder="sokak adı" class="input">
                        </div>
                        <div class="input-field">
                            <p>şehir adı<span>*</span></p>
                            <input type="text" name="city" required maxlength="50" placeholder="şehir adı" class="input">
                        </div>
                        <div class="input-field">
                            <p>ilçe adı<span>*</span></p>
                            <input type="text" name="country" required maxlength="50" placeholder="ilçe adı" class="input">
                        </div>
                        <div class="input-field">
                            <p>posta kodu<span>*</span></p>
                            <input type="number" name="pin" required maxlength="6" min="0" placeholder="örneğin 658324" class="input">
                        </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">sipariş ver</button>
            </form>
            <div class="summary">
                <h3>ödenecek ürünler</h3>
                <div class="box-container">
                    <?php
                        $grand_total = 0;
                        if (isset($_GET['get_id'])) {

                            $select_get = $conn->prepare("SELECT * FROM ürünler WHERE id = ?");
                            $select_get->execute([$_GET['get_id']]);

                            while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                                $sub_total = $fetch_get['fiyat'];
                                $grand_total+=$sub_total;
                    ?>
                    <div class="flex">
                        <img src="uploaded_files/<?= $fetch_get['resim']; ?>" class="image">
                        <div>
                            <h3 class="name"><?= $fetch_get['isim']; ?></h3>
                            <p class="price">₺<?= $fetch_get['fiyat']; ?></p>
                        </div>
                    </div>
                    <?php
                            }
                        }else{
                            $select_cart = $conn->prepare("SELECT * FROM cart WHERE kullanici_id = ?");
                            $select_cart->execute([$kullanici_id]);

                            if ($select_cart->rowCount() > 0) {
                                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                    $select_products = $conn->prepare("SELECT * FROM ürünler WHERE id = ?");
                                    $select_products->execute([$fetch_cart['ürün_id']]);
                                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                                    $sub_total = ($fetch_cart['adet'] * $fetch_products['fiyat']);
                                    $grand_total += $sub_total;
                    ?>
                    <div class="flex">
                        <img src="uploaded_files/<?= $fetch_products['resim']; ?>" class="image">
                        <div>
                            <h3 class="name"><?= $fetch_products['isim']; ?></h3>
                            <p class="price">₺<?= $fetch_products['fiyat']; ?> X <?= $fetch_cart['adet']; ?></p>
                        </div>
                    </div>
                    <?php
                                }    
                            }else{
                                echo '<p class="empty">sepetiniz boş</p>';
                            }
                        }
                    ?>
                </div>
                <div class="grand-total"><span>ödenecek toplam tutar</span>= ₺<?= $grand_total; ?></div>
            </div>
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
