<?php
include '../components/connect.php';
$satici_id = $_COOKIE['satici_id'] ?? '';

?>

<header>
    <div class="logo">
        <img src="../image/logo.png" style="width: 90px; height: auto; object-fit: contain;">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>
    <div class="profile-detail">
        <?php 
            $select_profile = $conn->prepare("SELECT * FROM satıcılar WHERE id = ?");
            $select_profile->execute([$satici_id]);

            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            
        ?>
        <div class="profile">
            <img src="../uploaded_files/<?= $fetch_profile['resim']; ?>" class="logo-img" width="100">
            <p><?= $fetch_profile['isim']; ?></p>
            <div class="flex-btn">
                <a href="profile.php" class="btn">profil</a>
                <a href="../components/admin_logout.php" onclick="return confirm('bu web sitesinden çıkış yapmak istiyor musunuz?');" class="btn">oturumu kapat</a>
            </div>
        </div>
        <?php } ?>
    </div>
</header>
<div class="sidebar-container">
    <div class="sidebar">
        <?php 
            $select_profile = $conn->prepare("SELECT * FROM satıcılar WHERE id = ?");
            $select_profile->execute([$satici_id]);

            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            
        ?>
        <div class="profile">
            <img src="../uploaded_files/<?= $fetch_profile['resim']; ?>" class="logo-img" width="100">
            <p><?= $fetch_profile['isim']; ?></p>
        </div>
        <?php } ?>
        <h5>menü</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>kontrol paneli</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i>ürün ekle</a></li>
                <li><a href="view_product.php"><i class="bx bxs-food-menu"></i>ürünü görüntüle</a></li>
                <li><a href="../components/admin_logout.php" onclick="return confirm('bu web siteden çıkış yap');"><i class="bx bx-log-out"></i>çıkış yap</a></li>
            </ul>
        </div>
    </div>
</div>