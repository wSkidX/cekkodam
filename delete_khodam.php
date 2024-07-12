<?php
include 'connect.php'; // Menggunakan file connect.php untuk koneksi database

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = json_decode(file_get_contents('php://input'), true);
  $id = $data['id'];

  // Query untuk menghapus khodam berdasarkan ID
  $sql = "DELETE FROM khodam_table WHERE id = $id";

  if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
  } else {
    $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}

echo json_encode($response);
?>