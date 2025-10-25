<header class="header">
    <section class="flex">
        <a href="home.php" class="logo"><img src="image/logo.png" width="130px"></a>
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="menu.php">mağaza</a>
            <a href="order.php">sipariş</a>
        </nav>
        <form action="" method="post" class="search-form">
            <input type="text" name="search_product" placeholder="ürün ara..." required maxlength="100">
            <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"></button>
        </form>
        <div class="icons">
            <div class="bx bx-list-plus" id="menu-btn"></div>
            <div class="bx bx-search-alt-2" id="search-btn"></div>

            <?php
                $count_wishlist_item = $conn->prepare("SELECT * FROM istek_listesi WHERE kullanici_id = ?");
                $count_wishlist_item->execute([$kullanici_id]);
                $total_wishlist_items = $count_wishlist_item->rowCount();
            ?>
            <a href="wishlist.php"><i class="bx bx-heart"></i><sup><?= $total_wishlist_items; ?></sup></a>
            <?php
                $count__item = $conn->prepare("SELECT * FROM cart WHERE kullanici_id = ?");
                $count__item->execute([$kullanici_id]);
                $total__items = $count__item->rowCount();
            ?>
            <a href="cart.php"><i class="bx bx-cart"></i><sup><?= $total__items; ?></sup></a>
            <div class="bx bxs-user" id="user-btn"></div>
        </div>
        <div class="profile-detail">
            <?php
            session_start();

                if (isset($_SESSION['user_id'])) {
                  $id = $_SESSION['user_id'];
                } else {
                // kullanıcı giriş yapmamış, hata veya yönlendirme yapılabilir
                $id = 0; // veya uygun bir varsayılan
                }


                $select_profile = $conn->prepare("SELECT * FROM kullanıcılar WHERE id = ?");
                $select_profile->execute([$kullanici_id]);

                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                
            ?>
            <img src="uploaded_files/<?= $fetch_profile['resim']; ?>">
            <h3 style="margin-bottom: 1rem;"><?= $fetch_profile['isim']; ?></h3>
            <div class="flex-btn">
                <a href="components/user_logout.php" onclick="return confirm('bu web siteden çıkış yap');" class="btn">çıkış yap</a>
            </div>
            <?php }else{ ?>
                <h3 style="margin-bottom: 1rem;">lütfen giriş yapın veya kayıt olun</h3>
                <div class="flex-btn">
                    <a href="login.php" class="btn">giriş yap</a>
                    <a href="register.php" class="btn">kayıt ol</a>
                </div>
            <?php } ?>
        </div>
    </section>
</header>