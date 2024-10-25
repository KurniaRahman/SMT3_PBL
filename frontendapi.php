<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ruang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-4">Data Ruang</h1>

        <!-- Table to display data -->
        <table class="table-auto w-full bg-white shadow-lg rounded-lg">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID Ruang</th>
                    <th class="px-4 py-2">Nama Ruang</th>
                    <th class="px-4 py-2">Keterangan</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="ruangTable">
                <!-- Data dari API akan dimasukkan di sini -->
            </tbody>
        </table>

        <!-- Form to add new data -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Tambah Ruang</h2>
            <form id="formTambahRuang" class="bg-white p-4 shadow-md rounded-lg">
                <label for="nama_ruang" class="block text-sm font-medium text-gray-700">Nama Ruang:</label>
                <input type="text" id="nama_ruang" name="nama_ruang" class="block w-full p-2 border rounded-md mb-4" required>

                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan:</label>
                <select id="keterangan" name="keterangan" class="block w-full p-2 border rounded-md mb-4" required>
                    <option value="1">Tersedia</option>
                    <option value="0">Tidak Tersedia</option>
                </select>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Tambah</button>
            </form>
        </div>

        <!-- Form to edit data -->
        <div class="mt-8 hidden" id="formEditContainer">
            <h2 class="text-2xl font-bold mb-4">Edit Ruang</h2>
            <form id="formEditRuang" class="bg-white p-4 shadow-md rounded-lg">
                <input type="hidden" id="edit_id_ruang">

                <label for="edit_nama_ruang" class="block text-sm font-medium text-gray-700">Nama Ruang:</label>
                <input type="text" id="edit_nama_ruang" name="edit_nama_ruang" class="block w-full p-2 border rounded-md mb-4" required>

                <label for="edit_keterangan" class="block text-sm font-medium text-gray-700">Keterangan:</label>
                <select id="edit_keterangan" name="edit_keterangan" class="block w-full p-2 border rounded-md mb-4" required>
                    <option value="1">Tersedia</option>
                    <option value="0">Tidak Tersedia</option>
                </select>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        // Fetch data ruang
        function fetchData() {
            fetch('http://localhost/potensi/api_ruang.php')
                .then(response => response.json())
                .then(data => {
                    let 
                     = document.getElementById('ruangTable');
                    ruangTable.innerHTML = '';  // Kosongkan tabel

                    data.forEach(ruang => {
                        ruangTable.innerHTML += `
                            <tr class="text-center">
                                <td class="border px-4 py-2">${ruang.id_ruang}</td>
                                <td class="border px-4 py-2">${ruang.nama_ruang}</td>
                                <td class="border px-4 py-2">${ruang.keterangan == '1' ? 'Tersedia' : 'Tidak Tersedia'}</td>
                                <td class="border px-4 py-2">
                                    <button onclick="editRuang(${ruang.id_ruang}, '${ruang.nama_ruang}', '${ruang.keterangan}')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                                    <button onclick="deleteRuang(${ruang.id_ruang})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Tambah ruang baru
        document.getElementById('formTambahRuang').addEventListener('submit', function(e) {
            e.preventDefault();

            let nama_ruang = document.getElementById('nama_ruang').value;
            let keterangan = document.getElementById('keterangan').value;

            fetch('http://localhost/potensi/api_ruang.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `nama_ruang=${nama_ruang}&keterangan=${keterangan}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchData();  // Update data setelah menambah
            })
            .catch(error => console.error('Error:', error));
        });

        // Edit ruang (mengisi form edit)
        function editRuang(id_ruang, nama_ruang, keterangan) {
            document.getElementById('edit_id_ruang').value = id_ruang;
            document.getElementById('edit_nama_ruang').value = nama_ruang;
            document.getElementById('edit_keterangan').value = keterangan;
            document.getElementById('formEditContainer').classList.remove('hidden');
            document.getElementById('formEditContainer').scrollIntoView();
        }

        // Submit edit ruang
        document.getElementById('formEditRuang').addEventListener('submit', function(e) {
            e.preventDefault();

            let id_ruang = document.getElementById('edit_id_ruang').value;
            let nama_ruang = document.getElementById('edit_nama_ruang').value;
            let keterangan = document.getElementById('edit_keterangan').value;

            fetch('http://localhost/potensi/api_ruang.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id_ruang=${id_ruang}&nama_ruang=${nama_ruang}&keterangan=${keterangan}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchData();  // Update data setelah mengedit
                document.getElementById('formEditContainer').classList.add('hidden');  // Sembunyikan form edit
            })
            .catch(error => console.error('Error:', error));
        });

        // Hapus ruang berdasarkan ID
        function deleteRuang(id_ruang) {
            fetch('http://localhost/potensi/api_ruang.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id_ruang=${id_ruang}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchData();  // Update data setelah menghapus
            })
            .catch(error => console.error('Error:', error));
        }

        // Fetch data saat halaman dimuat
        window.onload = fetchData;
    </script>
</body>
</html>
