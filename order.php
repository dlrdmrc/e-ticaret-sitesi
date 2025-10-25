<?php
    include 'components/connect.php';

    if (isset($_COOKIE['kullanici_id'])) {
        $kullanici_id = $_COOKIE['kullanici_id'];
    }else{
        $kullanici_id = '';
        header('location:login.php');
    }


    
    include 'components/connect.php';

    if (isset($_POST['cancel_order'])) {
        $siparis_id = $_POST['id'];
        $siparis_id = strip_tags($siparis_id);

        $verify_order = $conn->prepare("SELECT * FROM siparişler WHERE id = ?");
        $verify_order->execute([$siparis_id]);

    if ($verify_order->rowCount() > 0) {
        $delete_order = $conn->prepare("DELETE FROM siparişler WHERE id = ?");
        $delete_order->execute([$siparis_id]);

        $success_msg[] = 'sipariş başarıyla iptal edildi';
    } else {
        $warning_msg[] = 'sipariş zaten silinmiş veya bulunamadı';
    }
}


    
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serin Lezzet - kullanıcı siparişleri Sayfası</title>

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

    <div class="orders">
        <div class="heading">
            <h1>siparişlerim</h1>
            <img src="image/dashboard.png">
        </div>
        <div class="box-container">
            <?php
                $select_orders = $conn->prepare("SELECT * FROM siparişler WHERE kullanici_id = ? ORDER BY tarih DESC");
                $select_orders->execute([$kullanici_id]);

                if ($select_orders->rowCount() > 0) {
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        $ürün_id = $fetch_orders['ürün_id'];

                        $select_products = $conn->prepare("SELECT * FROM ürünler WHERE id = ?");
                        $select_products->execute([$ürün_id]);

                        if ($select_products->rowCount() > 0) {
                            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {

            ?>
            <div class="box" <?php if($fetch_orders['dürüm'] == 'iptal edildi'){echo 'style = "border:2px solid red;"';} ?>>
                <a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>"></a>
                <img src="uploaded_files/<?= $fetch_products['resim'] ?>" class="image">
                <div class="content">
                    <p class="date"> <i class="bx bxs-calender-alt"></i> <?= $fetch_orders['tarih']; ?></p>
                    <div class="row">
                        <h3 class="name"><?= $fetch_products['isim'] ?></h3>
                        <p class="price">Fiyat : ₺<?= $fetch_products['fiyat'] ?></p>
                        <p class="status" style="color:<?php if($fetch_orders['dürüm'] == 'teslim edilmiş'){echo "green";}elseif($fetch_orders['dürüm'] == 'iptal edildi'){echo "red";}else{echo "orange";} ?>"><?= $fetch_orders['dürüm']; ?></p>
                    </div>
                    <form method="post" onsubmit="return confirm('Siparişi iptal etmek istediğinize emin misiniz?');">
                        <input type="hidden" name="id" value="<?= $fetch_orders['id']; ?>">
                        <button type="submit" name="cancel_order" class="btn" style="margin-top: 10px;">Siparişi İptal Et</button>
                    </form>
                </div>
            </div>
            <?php
                            }
                        }
                    }
                }else{
                    echo '<p class="empty">henüz sipariş verilmedi</p>';
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
