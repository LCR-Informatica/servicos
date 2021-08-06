<?php
// login.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$erro = true;
$msg_erro = '';

// foi feito um post?

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // VERIFICAR se os dodos de login estão corretos
    $gestor = new cl_gestorBD();

    $param = [
        ':usuario' => $_POST['usuario'],
        ':senha'   => md5($_POST['senha'])
    ];

    $sql = 'SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha';

    // buscar o usuario na tabela
    $dados = $gestor->EXE_QUERY($sql, $param);

    if (count($dados) == 0) {
        $erro = true;
        $msg_erro = 'Dados de Login Inválido!';
    } else {
        $erro = false;
        $msg_erro = 'Login Válido!';
        funcoes::IniciaSessao($dados);

        // LOG
        funcoes::CriaLOG($_SESSION['nome_usuario'], 'fez LOGIN no sistema.');
    }
}

?>

<?php if ($erro) : ?>

    <?php if ($msg_erro != '') : ?>

        <div class='alert alert-danger text-center'><?php echo $msg_erro ?></div>
    
    <?php endif ; ?>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-5 offset-sm-2 card m-3 p-2">
                <h4 class="text-center mt-3">Login de usuário</h4>
                <hr>
                <form action="?a=login" method="post">
                    <div class="form-group p-1">
                        <input type='text' name='usuario' class="form-control" placeholder="Identificação do Usuário">
                    </div>
                    <div class="form-group p-1">
                        <input type='password' name='senha' class="form-control" placeholder="Senha">
                    </div>
                    <div class="form-group text-center">
                        <button type='submit' class="btn btn-primary btn-size-100">Login</button>
                        <a class="btn btn-secondary btn-size-100 ml-5" href="?a=sair">Sair</a>
                        <a class="btn btn-warning btn-size-100 ml-5" href="?a=setup">Setup</a>
                    </div>
                    <div class='text-center'>
                        <a href="?a=recuperar-senha">Esqueceu a senha?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php else : ?>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4 card m-3 p-2 text-center">
            <p>Usuário <strong><?php echo $dados[0]['nome'] ?></strong>, acessou o sistema.</p>
            <a href='?a=inicio' class='btn btn-primary'>Continuar</a>
            </div>
        </div>
    </div>

<?php endif; ?>