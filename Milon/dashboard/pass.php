<?php
$password = 'milon';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash bcrypt para la contraseña '{$password}':<br>";
echo $hash;