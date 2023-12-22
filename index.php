<!------ Made By Take ---->



<?php
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
    $negrlol = json_decode(file_get_contents("passwords.json"), true);
    array_push($negrlol["username"], base64_encode(topsekurtech($_POST["enckey"], $_POST["username"])));
    array_push($negrlol["website"], base64_encode(topsekurtech($_POST["enckey"], $_POST["website"])));
    array_push($negrlol["password"], base64_encode(topsekurtech($_POST["enckey"], $_POST["password"])));
    $dbomg = fopen("passwords.json", "w");
    fwrite($dbomg, json_encode($negrlol));
}

if (isset($_POST["login"])) {
    echo "<center>";
    echo'<h1>Password Manager V2</h1>';
    $lmaodb = json_decode(file_get_contents("passwords.json"), true);
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '  <meta charset="UTF-8">';
    echo '  <meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '  <title>Form Redesign</title>';
    echo '  <link rel="stylesheet" href="styles.css">';
    echo '</head>';
    echo '<body>';
    echo '<div class="additional-box">';
    echo '<h6>Your website info:<br></h6>';
    foreach ($lmaodb["password"] as $dba) {
        echo " USER: <b>" . topsekurtech($_POST["login"], base64_decode($lmaodb["username"][$count])) . "</b> PASS: <b>" . topsekurtech($_POST["login"], base64_decode($dba)) . " </b>" . " Website: <b>" . topsekurtech($_POST["login"], base64_decode($lmaodb["website"][$count])) . "</b><br>";
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
        <h1>Password Manager V2</h1>
        <form name="submitform" method="post">
            <input type="text" name="login" placeholder="Your decryption key"/>
            <input type="submit" value="Submit">
            <a href="forgotpass.html">Forgot Password</a>
        </form>
    </center>
    <div style="text-align: center; color: #fff; margin-top: 20px; position: fixed; bottom: 0; width: 100%; background-color: #2c2c2c; padding: 10px;">
        <p>Security Notice: This password manager is decently secure but I still recommend using <a href="https://bitwarden.com/">Bitwarden</a></p>

    </div>
</body>
</html>
