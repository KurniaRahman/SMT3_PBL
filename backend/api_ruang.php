<?php
// Membuat koneksi ke database dalam satu file
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_potensi";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


header('Content-Type: application/json; charset=utf-8');
// Memastikan method request yang diterima
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        if (isset($_GET['id_ruang'])) {
            // Mengambil satu data ruang berdasarkan ID
            $id_ruang = $_GET['id_ruang'];
            $sql = "SELECT * FROM ruang WHERE id_ruang = $id_ruang";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo json_encode($result->fetch_assoc());
            } else {
                echo json_encode(["message" => "Data not found"]);
            }
        } else {
            // Mengambil semua data ruang
            $sql = "SELECT * FROM ruang";
            $result = $conn->query($sql);
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;

    case 'POST':
        // Menambahkan data ruang baru
        $nama_ruang = $_POST['nama_ruang'];
        $keterangan = $_POST['keterangan'];

        $sql = "INSERT INTO ruang (nama_ruang, keterangan) VALUES ('$nama_ruang', '$keterangan')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Data inserted successfully"]);
        } else {
            echo json_encode(["message" => "Error inserting data: " . $conn->error]);
        }
        break;

    case 'PUT':
        // Memperbarui data ruang berdasarkan ID
        parse_str(file_get_contents("php://input"), $_PUT);
        $id_ruang = $_PUT['id_ruang'];
        $nama_ruang = $_PUT['nama_ruang'];
        $keterangan = $_PUT['keterangan'];

        $sql = "UPDATE ruang SET nama_ruang = '$nama_ruang', keterangan = '$keterangan' WHERE id_ruang = $id_ruang";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Data updated successfully"]);
        } else {
            echo json_encode(["message" => "Error updating data: " . $conn->error]);
        }
        break;

    case 'DELETE':
        // Menghapus data ruang berdasarkan ID
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id_ruang = $_DELETE['id_ruang'];

        $sql = "DELETE FROM ruang WHERE id_ruang = $id_ruang";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Data deleted successfully"]);
        } else {
            echo json_encode(["message" => "Error deleting data: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid request method"]);
        break;
}

// Menutup koneksi
$conn->close();
?>
