<?php

require_once("functions.php");

function login($uid, $pw){
    if($uid == '' || $pw == '') return;
    $data['userid'] = $uid;
    $data['passcode'] = $pw;
    $login = new DBConnection();
    if(!$result = $login->verify($data)) return;
    setcookie('datas', $data['userid'], time() + (86400 * 30));
    setcookie('datar', $data['passcode'], time() + (86400 * 30));
    header("location: ".(isset($_GET['redirect']) ? $_GET['redirect'] : $GLOBALS['base']));
}

if(isset($_POST['login']))
    if($_POST['login'] == 'Login')
        if(!login($_POST['userid'], $_POST['passcode']))
            error('SIGNERROR', 'Invalid user ID or passcode.')

?>
