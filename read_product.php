<?php
    include '../components/connect.php';

    if (isset($_COOKIE['satici_id'])) {
        $satici_id = $_COOKIE['satici_id'];
    }else{
        $satici_id = '';
        header('location:login.php');
    }

    
    $get_id = $_GET['id'] ?? null;
    if (!$get_id) {
       echo "Ürün ID belirlenmedi!";
       exit;
    }

    //ürünü sil

    if(isset($_POST["delete"])) {
        $p_id = $_POST['ürün_id'];
        $p_id = strip_tags($p_id);

        $delete_image = $conn->prepare("SELECT * FROM ürünler WHERE id = ? AND satici_id = ?");
        $delete_image->execute([$p_id, $satici_id]);

        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
        if ($fetch_delete_image[''] !='') {
            unlink('../uploaded_files/'.$fetch_delete_image['resim']);
        }
        $delete_product = $conn->prepare("DELETE FROM ürünler WHERE id = ? AND satici_id = ?");
        $delete_product->execute([$p_id, $satici_id]);
        header("location:view_product.php");
    }





?>    

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Serin Lezzet - Gösterilen Ürünler Sayfası</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
        
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


</head>
<body>

    <div class="main_container">
        <?php include '../components/admin_header.php'; ?>
        <section class="read-post">
            <div class="heading">
                <h1>ürün detay</h1>
                <img src="../image/dashboard.png">
            </div>
            <div class="box-container">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM ürünler WHERE id = ? AND satici_id = ?");
                    $select_products->execute([$get_id, $satici_id]);
                    if($select_products->rowCount() > 0) {
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){

            
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="ürün_id" value="<?= $fetch_products['id']; ?>">
                    <div class="status" style="color: <?php if($fetch_products['dürüm'] == 'active'){echo "limegreen";}else{echo "coral";} ?>"><?= $fetch_products['dürüm']; ?></div>
                    <?php if($fetch_products['resim'] != '') { ?>
                        <img src="../uploaded_files/<?= $fetch_products['resim']; ?>" class="image">
                    <?php } ?>
                    <div class="price"><?= $fetch_products['fiyat']; ?>₺</div>
                    <div class="title"><?= $fetch_products['isim']; ?></div>
                    <div class="content"><?= $fetch_products['ürün_detay']; ?></div>
                    <div class="flex-btn">
                        <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">düzenle</a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('bu ürünü sil');">sil</button>
                        <a href="view_product.php?id=<?= $fetch_products['id']; ?>" class="btn">geri git</a>
                    </div>
                </form>
                <?php
                        }
                    }else{
                        echo '
                            <div class="empty">
                                <p>henüz ürün eklenmedi! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">ürün ekle</a></p>
                            </div>
                        ';

                    }    
                ?>
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