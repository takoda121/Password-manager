<!------ Made By Take ---->


<?php
include "public.php";
$lmaodb = json_decode(file_get_contents("passwords.json"), true);
function topsekurtech($key, $data) {
    $result = "";
    for ($a = 0, $b = 0; $a < strlen($data); $a++, $b++) {
        if ($b >= strlen($key)) { $b = 0; }
        $result .= $data[$a] ^ $key[$b];
    }
    return $result;
}

$count = 0;

if (isset($_POST["website"])) {
    if ($lmaodb["hash"] != hash('sha256', $_POST["enckey"])){
        echo '  <link rel="stylesheet" href="styles.css">';
        echo ("<div class='alert'>⚠️Wrong password!⚠️");
        echo ("</div>");
        echo ("<br><br>Hash you inserted:".hash('sha256', $_POST["enckey"]));
        echo ("<br><br>Actual hash:".$lmaodb["hash"]);
        die();
    }
    $negrlol = json_decode(file_get_contents("passwords.json"), true);
    array_push($negrlol["username"], openssl_encrypt($_POST["username"], $encryption_method,$_POST["enckey"], 0, $encryption_iv));
    array_push($negrlol["website"], openssl_encrypt($_POST["website"], $encryption_method,$_POST["enckey"], 0, $encryption_iv));
    array_push($negrlol["password"], openssl_encrypt($_POST["password"], $encryption_method,$_POST["enckey"], 0, $encryption_iv));
    $dbomg = fopen("passwords.json", "w");
    fwrite($dbomg, json_encode($negrlol));
}

if (isset($_POST["login"])) {
    echo ("<script>");
    echo ("setTimeout(function() {");
    echo ("    window.location.href = '/logged.out.html';");
    echo ("}, 300000); // 5 minutes in milliseconds");
    echo ("</script>");

    echo "<center>";
    echo'<h1>Password Manager V3</h1>';
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '  <meta charset="UTF-8">';
    echo '  <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '  <title>Form Redesign</title>';
    echo '  <link rel="stylesheet" href="styles.css">';
    echo '</head>';
    if ($lmaodb["hash"] == "empty" || $lmaodb["hash"] == ""){
        $lmaodb["hash"] = hash('sha256', $_POST["login"]);
        $dbomg = fopen("passwords.json", "w");
        fwrite($dbomg, json_encode($lmaodb));
    }
    elseif ($lmaodb["hash"] != hash('sha256', $_POST["login"])){
        echo ("<div class='alert'>⚠️Wrong password!⚠️");
        echo ("</div>");
        echo ("<br><br>Hash you inserted:".hash('sha256', $_POST["login"]));
        echo ("<br><br>Actual hash:".$lmaodb["hash"]);
        die();
    }
    echo '<body>';
    echo '<div class="additional-box">';
    echo '<h6>Your website info:<br></h6>';
    foreach ($lmaodb["password"] as $dba) {
        echo " USER: <b>" . openssl_decrypt($lmaodb["username"][$count], $encryption_method,$_POST["login"], 0, $encryption_iv) . "</b> PASS: <b>" . openssl_decrypt($dba, $encryption_method,$_POST["login"], 0, $encryption_iv) . " </b>" . " Website: <b>" . openssl_decrypt($lmaodb["website"][$count], $encryption_method,$_POST["login"], 0, $encryption_iv) . "</b><br>";
        $count++;
    }
    echo '</div><br><br>';
    echo '  <form name="submitForm" method="post">';
    echo '<h6>Add website info:</h6>';
    echo '    <label for="website">Website:</label>';
    echo '    <input type="text" id="website" name="website" placeholder="Enter website"/>';
    echo '    <label for="username">Username:</label>';
    echo '    <input type="text" id="username" name="username" placeholder="Enter username"/>';
    echo '    <label for="password">Password:</label>';
    echo '    <input type="password" id="password" name="password" placeholder="Enter password"/>';
    echo '    <label for="enckey">Encryption Key:</label>';
    echo '    <input type="text" id="enckey" name="enckey" placeholder="Enter encryption key"/>';
    echo '    <input type="submit" value="ADD">';
    echo '  </form>';
    echo '</center>';
    echo '<div style="text-align: center; color: #fff; margin-top: 20px; position: fixed; bottom: 0; width: 100%; background-color: #2c2c2c; padding: 10px;">';
    echo '<p>Security Notice: This password manager is decently secure but I still recommend using <a href="https://bitwarden.com/">Bitwarden</a></p>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    
    die;
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
        <h1>Password Manager V3</h1>
        <?php
            $lmaodb = json_decode(file_get_contents("passwords.json"), true);
            if ($lmaodb["version"] != 3) {
                $url = "'http://localhost:8080/convert.php'";
                echo ("<div class='alert'>⚠️Convert your password to the new Encryption method.⚠️");
                echo ('<input type="submit" onclick="window.location.href = '.$url.'" value="Convert Your Passwords.">');
                echo ("</div>");
            }
        ?>
        <form name="submitform" method="post">
            <input type="text" name="login" placeholder="Your decryption key"/>
            <input type="submit" value="Submit">
        </form>
    </center>
    <div style="text-align: center; color: #fff; margin-top: 20px; position: fixed; bottom: 0; width: 100%; background-color: #2c2c2c; padding: 10px;">
    <a href="https://gitlab.com/takoda121/Password-manager" target="_blank"><img src="https://docs.gitlab.com/assets/images/gitlab-logo.svg" alt="GitLab Repository" aria-hidden="true" role="img" data-ot-ignore=""></a>
        <p>Security Notice: This password manager is decently secure but I still recommend using <a href="https://bitwarden.com/">Bitwarden</a><br>3.0 Update: Added AES-256 encryption.</p>

    </div>
</body>
</html>
