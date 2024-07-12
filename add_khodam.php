<?php
include 'connect.php'; // Menggunakan file connect.php untuk koneksi database

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];

  // Query untuk mengambil khodam secara acak dari database
  $sql = "SELECT khodam FROM khodam_list ORDER BY RAND() LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $khodam = $row['khodam'];

    // Simpan hasil check khodam ke database
    $sql = "INSERT INTO khodam_table (name, khodam) VALUES ('$name', '$khodam')";

    if ($conn->query($sql) === TRUE) {
      $response['success'] = true;
      $response['id'] = $conn->insert_id;
      $response['name'] = htmlspecialchars($name);
      $response['khodam'] = htmlspecialchars($khodam);
    } else {
      $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    $response['message'] = "Tidak ada khodam yang tersedia.";
  }

  $conn->close();
}

echo json_encode($response);
?>
