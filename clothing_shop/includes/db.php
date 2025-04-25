<?php
$servername = "localhost";
$username = "root"; // таны AMPP-д root хэрэглэдэг
$password = "mysql"; // таны өгсөн нууц үг
$dbname = "clothing_shop"; // таны датабэйсийн нэр

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Холболт амжилтгүй боллоо: " . mysqli_connect_error());
}
?>
