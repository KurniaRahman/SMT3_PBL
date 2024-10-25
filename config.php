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
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "Error: " . $this->koneksi->error;
        }
        return $data;
    }

    public function tambah_ruang($nama_ruang, $keterangan) {
        $query = "INSERT INTO ruang (nama_ruang, keterangan) VALUES (?, ?)";
        $stmt = $this->koneksi->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $this->koneksi->error);
        }
        $stmt->bind_param("ss", $nama_ruang, $keterangan); // "ss" berarti kedua parameter adalah string
        $stmt->execute();
        if ($stmt->error) {
            echo "Execute failed: " . $stmt->error;
        }
        $stmt->close();
    }

    public function edit_ruang($id_ruang) {
        $query = "SELECT * FROM ruang WHERE id_ruang = ?";
        $stmt = $this->koneksi->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $this->koneksi->error);
        }
        $stmt->bind_param("i", $id_ruang); // "i" berarti integer
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    public function update_ruang($id_ruang, $nama_ruang, $keterangan) {
        $query = "UPDATE ruang SET nama_ruang = ?, keterangan = ? WHERE id_ruang = ?";
        $stmt = $this->koneksi->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $this->koneksi->error);
        }
        $stmt->bind_param("ssi", $nama_ruang, $keterangan, $id_ruang); // "ssi" berarti dua string dan satu integer
        $stmt->execute();
        if ($stmt->error) {
            echo "Execute failed: " . $stmt->error;
        }
        $stmt->close();
    }

    public function hapus_ruang($id_ruang) {
        $query = "DELETE FROM ruang WHERE id_ruang = ?";
        $stmt = $this->koneksi->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $this->koneksi->error);
        }
        $stmt->bind_param("i", $id_ruang); // "i" berarti integer
        $stmt->execute();
        if ($stmt->error) {
            echo "Execute failed: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
