<?php
include 'components/connect.php';

// Örneğin ID'ye göre silme
$satici_id = '??J?aOl9J?R?5??4lPM?'; // Bu ID'yi manuel yaz veya formdan al

$delete = $conn->prepare("DELETE FROM satıcılar WHERE id = ?");
$delete->execute([$satici_id]);

if ($delete) {
    echo "Kullanıcı başarıyla silindi.";
} else {
    echo "Silme işlemi başarısız.";
}
?>
