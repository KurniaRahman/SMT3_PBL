<?php
include 'config.php';
$db = new database();
$id_ruang = $_GET['id_ruang'];
$db->hapus_ruang($id_ruang);
header("Location: data-ruang.php");
?>
