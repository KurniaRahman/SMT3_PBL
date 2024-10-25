<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';  
$password = '';      
$database = 'db_potensi'; 

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menambah data 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id_dosen = isset($_POST['id_dosen']) ? $_POST['id_dosen'] : null;
  $nip = $_POST['nip'];
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $no_hp = $_POST['no_hp'];

  
  if ($id_dosen) {
      // Update 
      $stmt = $conn->prepare("UPDATE dosen SET nip=?, nama=?, email=?, password=?, no_hp=? WHERE id_dosen=?");
      $stmt->bind_param("sssssi", $nip, $nama, $email, $password, $no_hp, $id_dosen);
      $action = "Data berhasil diperbarui!";
  } else {
      // Insert
      $stmt = $conn->prepare("INSERT INTO dosen (nip, nama, email, password, no_hp) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss", $nip, $nama, $email, $password, $no_hp);
      $action = "Data berhasil ditambahkan!";
  }

  if ($stmt->execute()) {
      echo $action;
  } else {
      echo "Error: " . $stmt->error;
  }
  $stmt->close();
}

if (isset($_POST['id'])) {
  $id_dosen = $_POST['id'];

  $sql = "DELETE FROM dosen WHERE id_dosen = ?";
  $stmt = $conn->prepare($sql);

  $stmt->bind_param("i", $id_dosen);
  
  if ($stmt->execute()) {
      echo "Record deleted successfully.";
  } else {
      echo "Error deleting record: " . $conn->error;
  }
  
  $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
  </head>
  <body class="bg-gray-100">
    <!-- navbar atas -->
    <nav class="fixed top-0 z-50 w-full border-b bg-gray-800 border-gray-700">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center justify-start rtl:justify-end">
            <button
              data-drawer-target="logo-sidebar"
              data-drawer-toggle="logo-sidebar"
              aria-controls="logo-sidebar"
              type="button"
              class="inline-flex items-center p-2 text-sm rounded-lg sm:hidden focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-700 focus:ring-gray-600"
            >
              <span class="sr-only">Open sidebar</span>
              <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path
                  clip-rule="evenodd"
                  fill-rule="evenodd"
                  d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                ></path>
              </svg>
            </button>
            <a href="#" class="flex ms-2 md:me-24">
              <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" />
              <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-white">Potensi</span>
            </a>
          </div>
          <!-- profile bar -->
          <div class="flex items-center ms-3">
            <div>
              <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" data-dropdown-placement="left-end">
                <span class="sr-only">Open user menu</span>
                <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
                  <span class="font-medium text-black">MU</span>
                </div>
              </button>
            </div>
            <div class="z-50 hidden my-4 text-base list-none divide-y rounded shadow bg-gray-700 divide-gray-600 md:min-w-32" id="dropdown-user">
              <div class="px-4 py-3" role="none">
                <p class="text-sm text-white" role="none">Mulyono</p>
                <p class="text-sm font-medium truncate text-gray-300" role="none">Admin</p>
              </div>
              <ul class="py-1" role="none">
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-white" role="menuitem">Profile</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-600 hover:text-red-400" role="menuitem">Logout</a>
                </li>
              </ul>
            </div>
          </div>
          <!-- profile bar -->
        </div>
      </div>
    </nav>
    <!-- navbar atas -->

    <!-- sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full border-r sm:translate-x-0 bg-gray-800 border-gray-700" aria-label="Sidebar">
      <div class="h-full px-3 pb-4 overflow-y-auto bg-gray-800 sidebar">
        <!-- menu 1 -->
        <ul class="space-y-2 font-medium">
          <p class="text-gray-400 font-bold">Menu</p>
          <!-- sub menu 1 -->
          <li>
            <a href="index.html" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 group">
              <svg class="w-5 h-5 text-white transition duration-75 group-hover:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
              </svg>
              <span class="ms-3 group-hover:text-gray-800">Dashboard</span>
            </a>
          </li>
          <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-white transition duration-75 rounded-lg group hover:bg-gray-100" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-gray-900">
                <path
                  fill-rule="evenodd"
                  d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Z"
                  clip-rule="evenodd"
                />
              </svg>
              <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap group-hover:text-gray-800">Data</span>
              <svg class="w-3 h-3 text-white transition duration-75 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <ul id="dropdown-example" class="hidden py-2 space-y-2">
              <li>
                <a href="data-dosen.html" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group bg-gray-100">Data Dosen</a>
              </li>
              <li>
                <a href="data-jadwal.html" class="flex items-center w-full p-2 text-white hover:text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data Jadwal</a>
              </li>
              <li>
                <a href="data-mahasiswa.html" class="flex items-center w-full p-2 text-white hover:text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data Mahasiswa</a>
              </li>
              <li>
                <a href="data-matkul.html" class="flex items-center w-full p-2 text-white hover:text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data Mata Kuliah</a>
              </li>
              <li>
                <a href="data-ruang.html" class="flex items-center w-full p-2 text-white hover:text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data Ruang</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="rekap.html" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 group">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white transition duration-75 group-hover:text-gray-800">
                <path
                  fill-rule="evenodd"
                  d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM9.75 17.25a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-.75Zm2.25-3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-5.25Z"
                  clip-rule="evenodd"
                />
                <path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
              </svg>
              <span class="ms-3 group-hover:text-gray-800">Rekap</span>
            </a>
          </li>
          <!-- sub menu 1 -->
        </ul>
        <!-- menu 2 -->
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-500">
          <p class="text-gray-400 font-bold">Akun</p>
          <!-- sub menu 2 -->
          <li>
            <a href="profile.html" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 group">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white transition duration-75 group-hover:text-gray-800">
                <path
                  fill-rule="evenodd"
                  d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                  clip-rule="evenodd"
                />
              </svg>
              <span class="ms-3 group-hover:text-gray-800">Profile</span>
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 group">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white transition duration-75 group-hover:text-gray-800">
                <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
              </svg>
              <span class="ms-3 group-hover:text-gray-800">Pesan</span>
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center p-2 text-red-500 rounded-lg hover:bg-gray-100 group">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-500 transition duration-75 group-hover:text-gray-800">
                <path
                  fill-rule="evenodd"
                  d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z"
                  clip-rule="evenodd"
                />
              </svg>
              <span class="ms-3 group-hover:text-gray-800">Keluar</span>
            </a>
          </li>
          <!-- sub menu 2 -->
        </ul>
        <!-- menu 2 -->
      </div>
    </aside>
    <!-- sidebar -->

    <!-- main content -->
    <div class="p-4 sm:ml-64 mt-14">
      <!-- judul halaman -->
      <h2 class="font-bold text-2xl md:text-3xl my-3">Data Dosen</h2>
      <!-- breadcrumbs -->
      <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
          <li class="inline-flex items-center">
            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
              <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                  d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"
                />
              </svg>
              Dashboard
            </a>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
              </svg>
              <a href="#" class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600 md:ms-2">Data</a>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
              </svg>
              <a href="#" class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600 md:ms-2">Data Dosen</a>
            </div>
          </li>
        </ol>
      </nav>
      <!-- breadcrumbs -->
      <!-- table -->
      <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden mt-6">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
          <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <!-- button tambah -->
            <button
              class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
              type="button"
              data-modal-target="create-modal"
              data-modal-toggle="create-modal"
            >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
              Tambah
            </button>
            <!-- button tambah -->
          </div>
          <div class="w-full md:w-1/2">
            <!-- search bar -->
            <form class="flex items-center">
              <label for="simple-search" class="sr-only">Search</label>
              <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full pl-10 p-2" placeholder="Search" required="" />
              </div>
            </form>
            <!-- search bar -->
          </div>
        </div>
        <div class="overflow-x-auto">
          <!-- tabel asli -->
          <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                <th scope="col" class="px-4 py-3">No</th>
                <th scope="col" class="px-4 py-3">NIP</th>
                <th scope="col" class="px-4 py-3">Nama Dosen</th>
                <th scope="col" class="px-4 py-3">Nama Email</th>
                <th scope="col" class="px-4 py-3">Password</th>
                <th scope="col" class="px-4 py-3">No HP</th>
                <th scope="col" class="px-4 py-3 w-1/6" colspan="2">Action</th>
              </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT id_dosen, nip, nama, email, password, no_hp FROM dosen";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        // Output data from each row
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b'>";
                            echo "<th scope='row' class='px-4 py-3 font-medium text-gray-900 whitespace-nowrap'>" . $no . "</th>";
                            echo "<td class='px-4 py-3'>" . $row['nip'] . "</td>";
                            echo "<td class='px-4 py-3'>" . $row['nama'] . "</td>";
                            echo "<td class='px-4 py-3'>" . $row['email'] . "</td>";
                            echo "<td class='px-4 py-3'>" . $row['password'] . "</td>";
                            echo "<td class='px-4 py-3'>" . $row['no_hp'] . "</td>";
                            
                            // Add Edit button
                            echo "<td class='px-4 py-3'>
                                      <button type='button' 
                                          class='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center inline-flex items-center me-2' 
                                          data-modal-target='edit-modal' 
                                          data-modal-toggle='edit-modal'
                                          data-id_dosen='{$row['id_dosen']}' 
                                          data-nip='{$row['nip']}' 
                                          data-nama='{$row['nama']}' 
                                          data-email='{$row['email']}' 
                                          data-password='{$row['password']}' 
                                          data-no_hp='{$row['no_hp']}'>
                                          <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='size-4 me-2'>
                                              <path d='M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z'/>
                                              <path d='M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z'/>
                                          </svg>
                                          Edit
                                      </button>
                                  </td>";
                            
                            // Add Delete button
                            echo "<td class='px-4 py-3'>
                                    <button type='button' class='text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2 text-center inline-flex items-center me-2' data-modal-target='delete-modal' data-modal-toggle='delete-modal' data-id='" . $row['id_dosen'] . "'>
                                        Hapus
                                    </button>
                                  </td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7' class='px-4 py-3 text-center'>Tidak ada data dosen</td></tr>";
                    }
                ?>
            </tbody>
          </table>
          <!-- tabel asli -->
        </div>
        <!-- pagination -->
        <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
          <span class="text-sm font-normal text-gray-500">
            Showing
            <span class="font-semibold text-gray-900">1-10</span>
            of
            <span class="font-semibold text-gray-900">1000</span>
          </span>
          <ul class="inline-flex items-stretch -space-x-px">
            <li>
              <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                <span class="sr-only">Previous</span>
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </a>
            </li>
            <li>
              <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</a>
            </li>
            <li>
              <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
            </li>
            <li>
              <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-gray-600 bg-gray-50 border border-gray-300 hover:bg-gray-100 hover:text-gray-700">3</a>
            </li>
            <li>
              <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">...</a>
            </li>
            <li>
              <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">100</a>
            </li>
            <li>
              <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                <span class="sr-only">Next</span>
                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
              </a>
            </li>
          </ul>
        </nav>
        <!-- pagination -->
      </div>
      <!-- table -->

      <!-- modal create -->
       <div id="create-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
          <!-- modal content -->
          <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
            <!-- modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
              <h3 class="text-lg font-semibold text-gray-900">Tambah Dosen</h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="create-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- modal body -->
            <div class="mt-6">
            <h3 class="font-semibold text-xl mb-4">Tambah Dosen</h3>
            <form method="POST" action="">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="nip" class="block mb-2 text-sm font-medium text-gray-900">NIP</label>
                        <input type="text" name="nip" id="nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                    </div>
                    <div>
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">password</label>
                        <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                    </div>
                    <div>
                        <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900">No HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                    </div>
                </div>
                <button type="submit" name="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
            </form>
            </div>
          </div>
        </div>
      </div>
      <!-- modal create -->

      <!-- modal edit -->
      <div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full">
              <!-- modal content -->
              <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
                  <!-- modal header -->
                  <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                      <h3 class="text-lg font-semibold text-gray-900">Edit Dosen</h3>
                      <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="edit-modal">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>
                  <!-- modal body -->
                  <form action="coba.php" method="POST"> <!-- Correct form action -->
                      <!-- Hidden field for id_dosen -->
                      <input type="hidden" name="id_dosen" id="id_dosen">

                      <div class="grid gap-4 mb-4 sm:grid-cols-2">
                          <div>
                              <label for="nip" class="block mb-2 text-sm font-medium text-gray-900">NIP</label>
                              <input type="text" name="nip" id="nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                          </div>
                          <div>
                              <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                              <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                          </div>
                          <div>
                              <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                              <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                          </div>
                          <div>
                              <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                              <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                          </div>
                          <div>
                              <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900">No HP</label>
                              <input type="number" name="no_hp" id="no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5" required />
                          </div>
                      </div>
                      <button type="submit" name="submit" class="text-white inline-flex items-center bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                          <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                          </svg>
                          Update
                      </button>
                  </form>
              </div>
          </div>
      </div>
      <!-- modal edit -->

      <!-- modal delete -->
      <div id="delete-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-md max-h-full">
              <div class="relative bg-white rounded-lg shadow">
                  <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="delete-modal">
                      <span class="sr-only">Close modal</span>
                  </button>
                  <div class="p-4 md:p-5 text-center">
                      <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda yakin ?</h3>
                      <button
                          data-modal-hide="popup-modal"
                          type="button"
                          class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
                      >
                          Ya, hapus data ini
                      </button>
                      <button
                          data-modal-hide="delete-modal"
                          type="button"
                          class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
                      >
                          Tidak, tetap simpan
                      </button>
                  </div>
              </div>
          </div>
      </div>
      <!-- modal delete -->      

    </div>
    <!-- main content -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    
    <script>
      document.querySelectorAll('[data-modal-toggle="edit-modal"]').forEach(button => {
          button.addEventListener('click', function () {
              // Get data from data attributes
              const id_dosen = this.getAttribute('data-id_dosen');
              const nip = this.getAttribute('data-nip');
              const nama = this.getAttribute('data-nama');
              const email = this.getAttribute('data-email');
              const password = this.getAttribute('data-password');
              const no_hp = this.getAttribute('data-no_hp');

              // Set the values in the modal's form
              document.querySelector('#edit-modal input[name="id_dosen"]').value = id_dosen;
              document.querySelector('#edit-modal input[name="nip"]').value = nip;
              document.querySelector('#edit-modal input[name="nama"]').value = nama;
              document.querySelector('#edit-modal input[name="email"]').value = email;
              document.querySelector('#edit-modal input[name="password"]').value = password;
              document.querySelector('#edit-modal input[name="no_hp"]').value = no_hp;
          });
      });
  </script>


      <script>
          const deleteButtons = document.querySelectorAll('button[data-modal-toggle="delete-modal"]');
          let deleteId;

          deleteButtons.forEach(button => {
              button.addEventListener('click', function() {
                  deleteId = this.getAttribute('data-id');
                  // Show the delete modal
                  document.getElementById('delete-modal').classList.remove('hidden');
              });
          });

          document.querySelector('button[data-modal-hide="popup-modal"]').addEventListener('click', function() {
              if (deleteId) {
                  fetch('', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/x-www-form-urlencoded',
                      },
                      body: 'id=' + deleteId
                  })
                  .then(response => response.text())
                  .then(data => {
                      console.log(data); // Log response for debugging
                      // Optionally refresh the page or remove the row from the table
                      location.reload(); // Reload the page to reflect changes
                  })
                  .catch(error => console.error('Error:', error));
              }
          });
      </script>



  </body>
</html>


<?php
// Tutup koneksi
$conn->close();
?>
