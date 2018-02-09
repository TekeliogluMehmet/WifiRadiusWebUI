<?php
$servername = "127.0.0.1";
$username = "radius";
$password = "radius2018**";

$dbname = "radius";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "\n";
$sql = "select username as Kullanici, portalloginpassword as Sifre from userinfo where enableportallogin=1";
$result = $conn->query($sql);

$myfile=fopen("/etc/ppp/chap-secrets","w") or exit("Can’t open file!");
if ($result->num_rows > 0) {
$satir=$result->num_rows;
    while($row = $result->fetch_assoc()) {
	$txt = $row['Kullanici']."	*	".$row['Sifre']. "	*	\n";
	fwrite($myfile, $txt);
    }
    echo $satir." records wrote to Chap-Secretes file.\n";
} else {
    echo "0 results";
}
fclose($myfile);
$conn->close();
?>
