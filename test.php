<?php
require'Class.php';

$params = [
    'user_id' => 'test_user02',
    'user_name' => 'name',
    'email' => 'mail',
    'pass' => 'password',
    'birthday' => 'birthday',
    'registday' => date('Y-m-d'),
    'self_intro' => null,
    'header_pic' => null,
    'icon_pic' => null
];

foreach($params as $key => $value){
    echo "$key : $value<br>";
}

$password = 'Asdf12345';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo $password . '<br>';
echo $hashed_password . '<br>';


?>