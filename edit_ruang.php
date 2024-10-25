<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ruang</title>
</head>
<body>
    <?php
    include 'config.php';
    $db = new database();
    $id_ruang = $_GET['id_ruang'];
    $ruang = $db->edit_ruang($id_ruang);

    if (isset($_POST['submit'])) {
        $nama_ruang = $_POST['nama_ruang'];
        $keterangan = $_POST['keterangan'];
        $db->update_ruang($id_ruang, $nama_ruang, $keterangan);
        header("Location: tampil_ruang.php");
    }
    ?>
    <h1>Edit Ruang</h1>
    <form action="" method="POST">
        <label for="nama_ruang">Nama Ruang:</label><br>
        <input type="text" name="nama_ruang" value="<?php echo $ruang['nama_ruang']; ?>" required><br><br>
        <label for="keterangan">Keterangan:</label><br>
        <select name="keterangan" required>
            <option value="1" <?php if ($ruang['keterangan'] == '1') echo 'selected'; ?>>Tersedia</option>
            <option value="0" <?php if ($ruang['keterangan'] == '0') echo 'selected'; ?>>Tidak Tersedia</option>
        </select><br><br>
        <button type="submit" name="submit">Update</button>
    </form>
</body>
</html>
