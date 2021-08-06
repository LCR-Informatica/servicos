<?php
// SETUP
// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

// verifica se a está no url
if (isset($_GET['a'])) {
    $a = $_GET['a'];
}

// roteador do setup
switch ($a) {
    case 'setup-criar-bd':
        // executa procedimentos de criação do BD
        include_once('setup/criar_bd.php');
        break;

    case 'setup-inserir-usuarios':
        // inserir usuarios na tabela
        include_once('setup/inserir_usuarios.php');
        break;

    case 'setup-inserir-clientes':
        // inserir clientes na tabela
        include_once('setup/inserir_clientes.php');
        break;
}

?>

<div class="container-fluid pd-20">
    <div class="row justify-content-center">
        <div class="col-md-10 card m-2 p-2">
            <h2 class="text-center pt-3">Manutenção</h2>
            <hr>
            <div class="text-center">
                <a class="btn btn-primary btn-size-200" href="?a=setup-criar-bd">Criar Base de Dados</a>
                <a class="btn btn-success btn-size-200 ml-5" href="?a=setup-inserir-usuarios">Inserir Usuários</a>
                <a class="btn btn-warning btn-size-200 ml-5" href="?a=setup-inserir-clientes">Inserir Clientes</a>
                <a class="btn btn-secondary btn-size-200 ml-5" href="?a=inicio">Voltar</a>
            </div>
        </div>
    </div>
</div>