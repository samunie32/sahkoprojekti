<?php
session_start();
$mail = $_POST["mail"];
$password = $_POST["psw"];




// Tietokannan yhteyden muodostaminen
$servername = "localhost";
$dbusername = "root";
$dbpassword = "1234";
$dbname = "sahko";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Tietokantayhteys epäonnistui: " . mysqli_connect_error());
}

if ($mail == "admin") {
    $_SESSION["username"] = $mail;
    header("Location: admin.php");
    exit;
}

$sql = "SELECT sahkoposti, salasana FROM kayttaja WHERE sahkoposti='$mail'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if($row["salasana"] == $password){
        $_SESSION["sahkoposti"] = $mail;
        header("Location: index.html");
        exit;
    } else{
        echo "<script type='text/javascript'>
    alert('Väärä salasana. Yritä uudelleen.');
    window.location.href = 'index.html';
    </script>";
    }
} else {
    echo "<script type='text/javascript'>
    alert('Käyttäjää ei löytynyt. Yritä uudelleen.');
    window.location.href = 'index.html';
    </script>";
}

mysqli_close($conn);
?>
