<?php
// index.php frontend

// controle de sessão

session_start();
if (!isset($_SESSION['a'])) {
    $_SESSION['a'] = 'home';
}

// funcoes do sistema
include_once('inc/funcoes.php');
include_once('inc/emails.php');
include_once('inc/gestorBD.php');

// paginas do sistema
include_once('webgeral/_header.php');
include_once('webgeral/routes.php');
include_once('webgeral/_footer.php');
?>