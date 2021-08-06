<?php
// logout.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}
$nome = $_SESSION['nome_usuario'];
funcoes::DestroiSessao();

// LOG
funcoes::CriaLOG($nome, 'fez LOGOUT do sistema.');

?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4 card m-3 p-3 text-center">
            <p>Usuário <strong><?php echo $nome ?></strong>, deslogou do sistema.</p>
            <a href="?a=inicio" class="btn btn-primary">Confirmar</a>
        </div>
    </div>
</div>