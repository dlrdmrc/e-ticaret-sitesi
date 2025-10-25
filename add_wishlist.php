<?php

    // sepete ürün ekleme
    if (isset($_POST['add_to_wishlist'])) {
        if ($kullanici_id != '') {

            $id = unique_id();
            $ürün_id = $_POST['ürün_id'];

            $verify_Wishlist = $conn->prepare("SELECT * FROM istek_listesi WHERE kullanici_id = ? AND ürün_id = ?");
            $verify_Wishlist->execute([$kullanici_id, $ürün_id]);

            $_num = $conn->prepare("SELECT * FROM istek_listesi WHERE kullanici_id = ? AND ürün_id = ?");
            $_num->execute([$kullanici_id, $ürün_id]);

            if ($verify_Wishlist->rowCount() > 0) {
                $warning_msg[] = 'ürün favorilerinizde zaten mevcut';
            }else if($_num->rowCount() > 0){
                $warning_msg[] = 'ürün sepetinizde zaten mevcut';
            }else if($kullanici_id != ''){
                $select_price = $conn->prepare("SELECT * FROM ürünler WHERE id = ? LIMIT 1");
                $select_price->execute([$ürün_id]);
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

                $insert_wishlist = $conn->prepare("INSERT INTO istek_listesi(id, kullanici_id, ürün_id, fiyat) VALUES(?,?,?,?)");
                $insert_wishlist->execute([$id, $kullanici_id, $ürün_id, $fetch_price['fiyat']]);

                $success_msg[] = 'ürün favorilere başarıyla eklendi';
            }
        }else{
            $warning_msg[] = 'lütfen önce giriş yapın';
        }
    }













?>