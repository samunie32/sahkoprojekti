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

// Luodaan salausavain varmistuslinkkiä varten
$avain = md5($sahkoposti . time());

$sql = "INSERT INTO kayttaja (Etunimi, Sukunimi, Sahkoposti, Puhelinnumero, Salasana, avain)
VALUES ('$etunimi', '$sukunimi', '$sahkoposti','$puhelin', '$salasana', '$avain')";

if ($conn->query($sql) === TRUE) {
    // Lähetetään varmistussähköposti käyttäjälle
    $to      = $sahkoposti;
    $subject = 'Vahvista sähköpostiosoitteesi';
    $message = 'Klikkaa tätä linkkiä vahvistaaksesi sähköpostiosoitteesi: http://www.example.com/vahvista.php?avain=' . $avain;
    $headers = 'From: noreply@example.com' . "\r\n" .
        'Reply-To: noreply@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo "<script type='text/javascript'>
        alert('Rekisteröityminen onnistui! Varmistusviesti on lähetetty sähköpostiisi.');
        window.location.href = 'index.html';
        </script>";
        exit;
    } else {
        echo 'Sähköpostin lähettäminen epäonnistui';
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
