<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "sahko";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$etunimi = $_POST["etunimi"];
$sukunimi = $_POST["sukunimi"];
$puhelin=$_POST["puhelin"];
$sahkoposti = $_POST["email"];
$salasana = $_POST["psw"];

$sql = "INSERT INTO kayttaja (Etunimi, Sukunimi, Sahkoposti, Puhelinnumero, Salasana)
VALUES ('$etunimi', '$sukunimi', '$sahkoposti','$puhelin', '$salasana')";

if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>
    alert('Rekisteröityminen onnistui! Voit nyt kirjautua sisään.');
    window.location.href = 'index.html';
    </script>";
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
