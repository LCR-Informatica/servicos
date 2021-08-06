<?php
// login.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$erro    = false;
$sucesso = false;
$msg     = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = $_POST['usuario'];
    $senha   = md5($_POST['senha']);

    $gestor = new cl_gestorBD();
    $param  = [':user' => $usuario, ':sen' => $senha];
    $sql    = 'SELECT * FROM usuarios WHERE usuario = :user AND senha = :sen';
    $dados  = $gestor->EXE_QUERY($sql, $param);

    //var_dump($dados);

    if (count($dados) == 0) {
        $erro = true;
        $msg  = "Usuário não encontrado!";
    }

    if (!$erro) {
        if ($dados[0]['validado'] == 0) {
            $erro = true;
            $msg  = "Usuário ainda não validou o cadastro. Verifique o email!";
        } else {
            $sucesso = true;
            funcoes::IniciaSessao($dados);
        }
    }
}

?>
<?php if ($erro) : ?>
    <div class='alert alert-danger text-center'><?php echo $msg ?></div>
<?php else : ?>
    <?php if ($sucesso) : ?>
        <div class='container-fluid index-container'>
            <div class="row">
                <div class="col-4 offset-4 mt-3 mb-3 card p-4">
                    <div class="text-center">
                        <p>Bem vindo(a), <b><?php echo $dados[0]['nome'] ?></b>.</p>
                        <a href="?a=home" class="btn btn-primary btn-size-150">Continuar</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>