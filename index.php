<?php
function topsekurtech($key, $data) { //Can be bypassed tbh but this aint supposed to be the most secure thing
    $result = "";
    for($a = 0, $b = 0; $a < strlen($data); $a++, $b++) {
        if($b >= strlen($key)) { $b = 0; }
        $result .= $data[$a] ^ $key[$b];
    }
    return $result;
}
$count = 0;
if(isset($_POST["website"])){
    $negrlol = json_decode(file_get_contents("passwords.json"), true);
    array_push($negrlol["username"],base64_encode(topsekurtech($_POST["enckey"],$_POST["username"])));
    array_push($negrlol["website"],base64_encode(topsekurtech($_POST["enckey"],$_POST["website"])));
    array_push($negrlol["password"],base64_encode(topsekurtech($_POST["enckey"],$_POST["password"])));
    $dbomg = fopen("passwords.json", "w");
    fwrite($dbomg, json_encode($negrlol));

}
if(isset($_POST["login"]))
{
    echo "<center>";
    $lmaodb = json_decode(file_get_contents("passwords.json"), true);
        foreach($lmaodb["password"] as $dba) {
             echo " USER: <b>".topsekurtech($_POST["login"], base64_decode($lmaodb["username"][$count]))."</b> PASS: <b>".topsekurtech($_POST["login"], base64_decode($dba))." </b>"." Website: <b>".topsekurtech($_POST["login"], base64_decode($lmaodb["website"][$count]))."</b><br>";
             $count++;
        }


    echo '<form name="submitform" method="post">';
    echo '<input type="text" name="website" value="website"/><br>';
    echo '<input type="text" name="username" value="username"/><br>';
    echo '<input type="text" name="password" value="password"/><br>';
    echo '<input type="" name="enckey" value="encription key"/><br>';
    echo '<input type="submit" value="ADD">';
    die;
}
?>
<center>
<h1><font color="black">Password Manager</font></h1>
<form name="submitform" method="post">
<input type="" name="login" value="your decription key"/>
<input type="submit" value="Submit">
 </form>
