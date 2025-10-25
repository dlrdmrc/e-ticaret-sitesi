<?php
    include '../components/connect.php';

    if (isset($_COOKIE['satici_id'])) {
        $satici_id = $_COOKIE['satici_id'];
    }else{
        $satici_id = '';
        header('location:login.php');
    }

    if (isset($_POST['update'])) {
        $ürün_id = $_POST['ürün_id'];
        $ürün_id = strip_tags($ürün_id);

        $isim = $_POST['isim'];
        $isim = strip_tags($isim);

        $fiyat = $_POST['fiyat'];
        $fiyat = strip_tags($fiyat);

        $description = $_POST['description'];
        $description = strip_tags($description);

        $stok = $_POST['stok'];
        $stok = strip_tags($stok);
        $dürüm = 'active';

        $update_product = $conn->prepare("UPDATE ürünler SET isim = ?, fiyat = ?, ürün_detay = ?, stok = ?, dürüm = ? WHERE id = ?");
        $update_product->execute([$isim, $fiyat, $description, $stok, $dürüm, $ürün_id]);

        $success_msg[] = 'ürün güncellendi';

        $old_image = $_POST['old_image'];
        $resim = $_FILES['resim']['name'];
        $resim = strip_tags($resim);
        $image_size = $_FILES['resim']['size'];
        $image_tmp_name = $_FILES['resim']['tmp_name'];
        $image_folder = '../uploaded_files/'.$resim;

        $select_image = $conn->prepare("SELECT * FROM ürünler WHERE resim = ? AND satici_id = ?");
        $select_image->execute([$resim, $satici_id]);

        if(!empty($resim)) {
            if ($image_size > 20000000) {
                $warning_msg[] = 'resim boyutu çok büyük';
            }elseif($select_image->rowCount() > 0) {
                $warning_msg[] = 'lütfen resminizin adını değiştirin';
            }else{
                $update_image = $conn->prepare("UPDATE ürünler SET resim = ? AND id = ?");
                $update_image->execute([$resim, $ürün_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                if ($old_image != $resim AND $old_image != '') {
                    unlink('../uploaded_files/'.$old_image);
                }
                $success_msg[] = 'resim güncellendi!';
            }
        }
    }

    //resmi sil
    if(isset($_POST['delete_image'])) {
        $empty_image = '';

        $ürün_id = $_POST['ürün_id'];
        $ürün_id = strip_tags($ürün_id);

        $delete_image = $conn->prepare("SELECT * FROM ürünler WHERE id = ?");
        $delete_image->execute([$ürün_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

        if ($fetch_delete_image['resim'] != '') {
            unlink('../uploaded_files/'.$fetch_delete_image['resim']);
        }
        $unset_image = $conn->prepare("UPDATE ürünler SET resim = ? WHERE id = ?");
        $unset_image->execute([$empty_image, $ürün_id]);
        $success_msg[] = 'ressim başarıyla silindi';
    }

    // ürün sil

    if (isset($_POST['delete_product'])) {
        $ürün_id = $_POST['ürün_id'];
        $ürün_id = strip_tags($ürün_id);

        $delete_image = $conn->prepare("SELECT * FROM ürünler WHERE id = ?");
        $delete_image->execute([$ürün_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

        if ($fetch_delete_image['resim'] != '') {
            unlink('../uploaded_files/'.$fetch_delete_image['resim']);
        }
        $delete_product = $conn->prepare("DELETE FROM ürünler WHERE id = ?");
        $delete_product->execute([$ürün_id]);
        $success_msg[] = 'ürün başarıyla silindi!';
        header('location:view_product.php');

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
        <section class="post-editör">
            <div class="heading">
                <h1>ürünü düzenle</h1>
                <img src="../image/dashboard.png">
            </div>
            < class="box-container">
                <?php 
                    $ürün_id = $_GET['id'];
                    $select_products = $conn->prepare("SELECT * FROM ürünler WHERE id = ? AND satici_id = ?");
                    $select_products->execute([$ürün_id, $satici_id]);
                    if ($select_products->rowCount() > 0) {
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {


                ?>
                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data" class="register">
                        <input type="hidden" name="old_image" value="<?= $fetch_products['resim']; ?>">
                        <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                        <div class="input-field">
                            <p>ürün durumu <span>*</span></p>
                            <select name="status" class="box">
                                <option value="<?= $fetch_products['dürüm']; ?>" selected><?= $fetch_products['dürüm']; ?></option>
                                <option value="active" <?= $fetch_products['dürüm'] === 'active' ? 'selected' : ''; ?>>aktif</option>
                                <option value="deactive" <?= $fetch_products['dürüm'] === 'deactive' ? 'selected' : ''; ?>>devre dışı</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>ürün adı <span>*</span></p>
                            <input type="text" name="isim" value="<?= $fetch_products['isim']; ?>" class="box">                      
                        </div>
                        <div class="input-field">
                            <p>ürün fiyatı<span>*</span></p>
                            <input type="number" name="fiyat" value="<?= $fetch_products['fiyat']; ?>" class="box">                      
                        </div>
                        <div class="input-field">
                            <p>ürün açıklaması <span>*</span></p>
                            <textarea name="description" class="box"><?= $fetch_products['ürün_detay']; ?></textarea>                     
                        </div>
                        <div class="input-field">
                            <p>ürün stok<span>*</span></p>
                            <input type="number" name="stok" value="<?= $fetch_products['stok']; ?>" class="box" min="0" max="99999999" maxlength="10">                      
                        </div>
                        <div class="input-field">
                            <p>ürün resmi<span>*</span></p>
                            <input type="file" name="resim" accept="image/*" class="box">   
                            <?php if($fetch_products['resim'] !=''){?>
                                <img src="../uploaded_files/<?= $fetch_products['resim']; ?>" class="image">
                                <div class="flex-btn">
                                    <input type="submit" name="delete_image" class="btn" value="resmi sil">
                                    <a href="view_product.php" class="btn" style="width:49%; text-align: center; height: 3rem; margin-top: .7rem;">geri git</a>
                                </div>
                            <?php } ?>                  
                        </div>
                        <div class="flext-btn">
                            <input type="submit" name="update" value="ürünü güncelle" class="btn">
                            <input type="submit" name="delete_product" value="ürünü sil" class="btn">
                        </div>
                    </form>
                </div> 
                <?php
                        }
                    }else{
                        echo '
                            <div class="empty">
                                <p>henüz ürün eklenmedi! </p>
                            </div>
                        
                        ';

                ?>
                <br><br>
                <div class="flext-btn">
                    <a href="view_product.php" class="btn">ürünü görüntüle</a>
                    <a href="add_products.php" class="btn">ürün ekle</a>
                </div>
                <?php } ?>
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