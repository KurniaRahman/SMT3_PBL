<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ruang</title>
</head>
<body>
    <?php
    include 'config.php';
    $db = new database();

    if (isset($_POST['submit'])) {
        $nama_ruang = $_POST['nama_ruang'];
        $keterangan = $_POST['keterangan'];
        $db->tambah_ruang($nama_ruang, $keterangan);
        header("Location: tampil_ruang.php");
    }
    ?>
    <h1>Tambah Ruang</h1>
    <form action="" method="POST">
        <label for="nama_ruang">Nama Ruang:</label><br>
        <input type="text" name="nama_ruang" required><br><br>
        <label for="keterangan">Keterangan:</label><br>
        <select name="keterangan" required>
            <option value="1">Tersedia</option>
            <option value="0">Tidak Tersedia</option>
        </select><br><br>
        <button type="submit" name="submit">Simpan</button>
    </form>
</body>
</html>
