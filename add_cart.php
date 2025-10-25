<?php

//sepete ürün ekleme
    if (isset($_POST['add_to_cart'])) {
        if ($kullanici_id != '') {
            
            $id = unique_id();
            $ürün_id = $_POST['ürün_id'];

            $adet = $_POST['adet'];
            $adet = strip_tags($adet);

            $verify_cart = $conn->prepare("SELECT * FROM cart WHERE kullanici_id = ? AND ürün_id = ?");
            $verify_cart->execute([$kullanici_id, $ürün_id]);

            $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE kullanici_id = ?");
            $max_cart_items->execute([$kullanici_id]);

            if ($verify_cart->rowCount() > 0) {
                $warning_msg[] = 'ürün sepetinizde zaten mevcut';
            }else if($max_cart_items->rowCount() > 20){
                $warning_msg[] = 'sepetiniz dolu';
            }else{
                $select_price = $conn->prepare("SELECT * FROM ürünler WHERE id = ? LIMIT 1");
                $select_price->execute([$ürün_id]);
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

                $insert_cart = $conn->prepare("INSERT INTO cart(id, kullanici_id, ürün_id, fiyat, adet) VALUES(?, ?, ?, ?, ?)");
                $insert_cart->execute([$id, $kullanici_id, $ürün_id, $fetch_price['fiyat'], $adet]);
                $success_msg[] = 'ürün sepetinize başarıyla eklendi';
            }
        }else{
            $warning_msg[] = 'lütfen önce giriş yapın';
        }
    }

?>