<!------ Made By Take ---->


<?php
include "public.php";
function topsekurtech($key, $data) {
    $result = "";
    for ($a = 0, $b = 0; $a < strlen($data); $a++, $b++) {
        if ($b >= strlen($key)) { $b = 0; }
        $result .= $data[$a] ^ $key[$b];
    }
    return $result;
}
if (isset($_POST["login"]))
{
$count = 0;
$counta = 0;
$countb = 0;
$lmaodb = json_decode(file_get_contents("passwords.json"), true);
foreach ($lmaodb["password"] as $dba) {
    $password = topsekurtech($_POST["login"], base64_decode($dba));
    $encryption = openssl_encrypt($password, $encryption_method,$_POST["newlogin"], 0,$encryption_iv);
    $lmaodb["password"][$count] = $encryption;
    $count++;
}
foreach ($lmaodb["website"] as $dba) {
    $password = topsekurtech($_POST["login"], base64_decode($dba));
    $encryption = openssl_encrypt($password, $encryption_method,$_POST["newlogin"], 0,$encryption_iv);
    $lmaodb["website"][$counta] = $encryption;
    $counta++;
}
foreach ($lmaodb["username"] as $dba) {
    $password = topsekurtech($_POST["login"], base64_decode($dba));
    $encryption = openssl_encrypt($password, $encryption_method,$_POST["newlogin"], 0,$encryption_iv);
    $lmaodb["username"][$countb] = $encryption;
    $countb++;
}
$lmaodb["apikey"] = hash('sha384', $_POST["newlogin"]); //Why the fuck did I decide to go with sha384??
$lmaodb["version"] = 4;
$dbomg = fopen("passwords.json", "w");
fwrite($dbomg, json_encode($lmaodb));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .alert {
         padding: 20px;
          background-color: #f44336; /* Red */
         color: white;
          margin-bottom: 15px;
         }
         .ok {
    padding: 20px;
    background-color: #009200; /* Red */
    color: white;
    margin-bottom: 15px;
  }
        center {
            text-align: center;
        }

        h1 {
            color: #fff;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #2c2c2c;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            background-color: #383838;
            border: 1px solid #555;
            color: #fff;
        }
        a {
  color: hotpink;
}
        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }
        input[type="forgotpass"] {
            background-color: #fc0206 ;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <center>
        <h1>Password Recovery v2 --> v4</h1>
        <?php
            $lmaodb = json_decode(file_get_contents("passwords.json"), true);
            if ($lmaodb["version"] == 4) {
                $url = "'http://localhost:8080/convert2.php'";
                echo ("<div class='ok'>✅Your password is already converted to V4✅");
                echo ("</div>");
            }
            else{
                 echo('<form name="submitform" method="post">');
                 echo('<input type="text" name="login" placeholder="Your decryption key"/>');
                 echo('<input type="text" name="newlogin" placeholder="New decryption key (can be the same)"/>');
                 echo('<input type="submit" value="Convert">');
                 echo('</form>');
            }
        ?>
    </center>
    <div style="text-align: center; color: #fff; margin-top: 20px; position: fixed; bottom: 0; width: 100%; background-color: #2c2c2c; padding: 10px;">
        <p>Security Notice: This password manager is decently secure but I still recommend using <a href="https://bitwarden.com/">Bitwarden</a></p>

    </div>
</body>
</html>
