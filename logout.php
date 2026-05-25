<?php

session_start();

session_destroy();

if (isset($_COOKIE['usuario_email'])) {
    setcookie('usuario_email', '', time() - 3600, '/');
}

header('Location: login.php');
exit;
