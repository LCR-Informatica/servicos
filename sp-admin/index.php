<?php
// index.php backend

// controle de sessão

session_start();
if (!isset($_SESSION['a'])) {
    $_SESSION['a'] = 'inicio';
}

// incluir funcoes do sistema
include_once('../inc/funcoes.php');
include_once('../inc/emails.php');
include_once('../inc/gestorBD.php');

// includes diversos
include_once('_header.php');
include_once('routes.php');
include_once('_footer.php');
?>