<?php
class database {
    private $host = "localhost";
    private $user = "root"; // sesuaikan dengan user MySQL
    private $pass = ""; // sesuaikan dengan password MySQL
    private $db = "db_potensi"; // sesuaikan dengan nama database
    public $koneksi;

    public function __construct() {
        $this->koneksi = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }

    public function tampil_ruang($ruang) {
        $data = [];
        $query = "SELECT * FROM $ruang";
        $result = $this->koneksi->query($query);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function tambah_ruang($nama_ruang, $keterangan) {
        $query = "INSERT INTO ruang (nama_ruang, keterangan) VALUES ('$nama_ruang', '$keterangan')";
        return $this->koneksi->query($query);
    }

    public function edit_ruang($id_ruang) {
        $query = "SELECT * FROM ruang WHERE id_ruang = '$id_ruang'";
        return $this->koneksi->query($query)->fetch_assoc();
    }

    public function update_ruang($id_ruang, $nama_ruang, $keterangan) {
        $query = "UPDATE ruang SET nama_ruang = '$nama_ruang', keterangan = '$keterangan' WHERE id_ruang = '$id_ruang'";
        return $this->koneksi->query($query);
    }

    public function hapus_ruang($id_ruang) {
        $query = "DELETE FROM ruang WHERE id_ruang = '$id_ruang'";
        return $this->koneksi->query($query);
    }
}
?>
