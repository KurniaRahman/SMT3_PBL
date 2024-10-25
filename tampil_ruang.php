<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ruang</title>
</head>
<body>
    <?php
    include 'config.php';
    $db = new database();
    ?>
    <h1>Data Ruang</h1>
    <a href="tambah_ruang.php">Tambah Ruang</a>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Ruang</th>
            <th>Keterangan</th>
            <th>Edit</th>
            <th>Hapus</th>
        </tr>
        <?php
        $no = 1;
        foreach($db->tampil_ruang('ruang') as $x) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>

            <td><?php echo $x['nama_ruang']; ?></td>
            <td><?php echo $x['keterangan'] == '1' ? 'Tersedia' : 'Tidak Tersedia'; ?></td>
            <td><a href="edit_ruang.php?id_ruang=<?php echo $x['id_ruang']; ?>">Edit</a></td>
            <td><a href="hapus_ruang.php?id_ruang=<?php echo $x['id_ruang']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a></td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
