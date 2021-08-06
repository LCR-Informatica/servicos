<?php
// usuarios_del.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$permitido  = funcoes::Permissao(0);
$sucesso    = false;
$nome       = '';
$email      = '';
$msg        = '';

// controle de permissao indice (ok)
// administradores podem gerenciar usuarios (ok), não admins (falta)
// id deve ser != 1 e != da sessao ativa (ok)

$id = -1;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $permitido = false;
}

if ($id == 1 || $id == $_SESSION['id_usuario']) {
    // alguem tentando mexer no admin master
    // alguem tentando mexer em si próprio
    $permitido = false;
}

if ($_SESSION['id_usuario'] == 1) { // admin master acessando
    $permitido = true;
}

if ($permitido) {
    // verificar ocerrencia de dados na base
    $gestor = new cl_gestorBD();
    $param  = [':id'  => $id];
    $sql    = "SELECT * FROM usuarios WHERE id_usuario = :id";
    $user   = $gestor->EXE_QUERY($sql, $param);
    $nome   = $user[0]['nome'];
    $email  = $user[0]['email'];

    if (substr($user[0]['permissoes'], 0, 1) == 1 && $_SESSION['id_usuario'] != 1) { // outro admin deletando admin
        $permitido = false;
    }
}

if ($permitido) {
    if (isset($_GET['r'])) {
        if ($_GET['r'] == 1) {
            $sql     = "DELETE FROM usuarios WHERE id_usuario = :id";
            $user    = $gestor->EXE_NON_QUERY($sql, $param);
            $sucesso = true;
            $msg = 'Usuário excluido com sucesso!';

            // LOG
            funcoes::CriaLOG($_SESSION['nome'], 'excluiu usuario '.$nome.'no BD');
        }
    }
}

?>

<?php if ($permitido) : ?>

    <?php if ($sucesso) : ?>

        <div class='m-3 pt-3 pb-2 alert alert-success text-center'>
            <h5><?php echo $msg ?></h5>
        </div>

    <?php endif; ?>

    <div class="container card col-md-6 offset-md-3 mt-3 mb-3">
        <h4 class="text-center mt-3">Exclusão de Usuário</h4>
        <hr>
        <div class="row pt-2">
            <div class="col-md-6">
            <h5><strong>Usuário: </strong><?php echo $nome ?></h5>
            </div>
            <div class="col-md-6">
            <h5><strong>Email: </strong><?php echo $email ?></h5>
            </div>
        </div>
        <hr>
        <div class="text-center mt-1 mb-3">
            <a class="btn btn-secondary btn-size-150 mr-5" href="?a=usuarios-gerir">Voltar</a>
            <a class="btn btn-primary btn-size-150" href="?a=usuarios-del&id=<?php echo $user[0]['id_usuario'] ?>&r=1">Excluir</a>
        </div>
    </div>

<?php else : ?>

    <?php include_once('../inc/sem_permissao.php') ?>

<?php endif; ?>