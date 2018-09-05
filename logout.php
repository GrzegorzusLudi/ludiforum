<?php
if(isset($_COOKIE["user_login"])){
    setcookie('user_login', null, -1, '/');
    setcookie('user_haslo', null, -1, '/');
	header('Location: index.php');
}

?>