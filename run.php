<?php
error_reporting(E_ALL);
echo "[i] BigToken AutoReff & VerifEmail <3\n\n";

echo '[?] Kode Reff mu? ';
$reff = trim(fgets(STDIN));
echo '[?] Reff berapa kali? ';
$jumlah = trim(fgets(STDIN));
echo "\n[i] Result:\n";
for ($i=0; $i < $jumlah; $i++) { 
    $regis = true;
    while ($regis) {
        echo "[".($i+1)."/".$jumlah."] Create account: ";
        $getEmail = file_get_contents('https://api.hax0r.id/bigtoken/regis.php?reff='.$reff);
        if (preg_match('/user_id/', $getEmail)) {
            $email = json_decode($getEmail)->email;
            $regis = false;
            echo $email." [\e[0;0;42mOK\e[0m]";
        } else {
            $regis = true;
            echo "null [\e[0;0;41mFAIL\e[0m], Trying... ";
        }
    }
    sleep(1);
    $pesan = true;
    echo " - Check email: ";
    while ($pesan) {
        $getURL = file_get_contents('https://api.hax0r.id/bigtoken/inbox.php?email='.$email);
        if (preg_match('/Ada pesan/', $getURL)) {
            $verifURL = json_decode($getURL)->verifURL;
            $pesan = false;
            echo $verifURL." [\e[0;0;42mOK\e[0m]";
        } else {
            $pesan = true;
            echo "null [\e[0;0;41mFAIL\e[0m], Trying... ";
            sleep(3);
        }
    }
    sleep(1);
    $getVerif = file_get_contents('https://api.hax0r.id/bigtoken/verif.php?url='.$verifURL);
    if (preg_match('/Reward successfully made/', $getVerif)) {
        $message = json_decode($getVerif)->message;
        echo " - Response: ".$message."[\e[0;0;42mOK\e[0m]\n";
    } else {
        echo " - Response: The email field is required or The verification code field is required [\e[0;0;41mFAIL\e[0m]\n";
    }
}
?>
