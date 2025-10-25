<?php
  $db_name = 'mysql:host=localhost;dbname=icecreamshop_db';
  $user_name = 'root';
  $user_password = '';

  try {
      $conn = new PDO($db_name, $user_name, $user_password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      die("Veritabanına bağlanılamadı: " . $e->getMessage());
  }

  if (!function_exists('unique_id')) {
      function unique_id(){
          $chars = "0123456789abcçdefgğhiıjklmnoöprsştuüvyzABCÇDEFGĞHİIJKLMNOÖPRSŞTUÜVYZ";
          $charLength = strlen($chars);
          $randomString = '';
          for ($i=0; $i < 20; $i++) {
              $randomString .= $chars[mt_rand(0, $charLength - 1)];
          }
          return $randomString;
      }
  }
?>
