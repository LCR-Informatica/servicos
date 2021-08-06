<?php
// usuarios_upd.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$permitido  = funcoes::Permissao(0);
$sucesso    = false;
$erro       = false;
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

    if (substr($user[0]['permissoes'], 0, 1) == 1 && $_SESSION['id_usuario'] != 1) {
        // outro admin alterando admin
        $permitido = false;
    }

    if (count($user) == 0) {
        $erro = true;
        $msg = "Usuário não encontrado!";
    }
} else {
    include_once('../../inc/sem_permissao.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome       = $_POST['txt-nome'];
    $email      = $_POST['txt-email'];

    $gestor = new cl_gestorBD();
    $param  = [':id'  => $id, ':email' => $email];
    $sql    = "SELECT * FROM usuarios WHERE email = :email AND id_usuario <> :id";
    $user   = $gestor->EXE_QUERY($sql, $param);

    if (count($user) != 0) {
        $erro = true;
        $msg = "Email já cadastrado para outro usuário!";
    } else {
        $param  = [':id'  => $id, ':email' => $email, ':nome' => $nome];
        $sql    = "UPDATE usuarios SET nome = :nome, email = :email WHERE id_usuario = :id";
        $user   = $gestor->EXE_NON_QUERY($sql, $param);

        // atualiza informações
        $param  = [':id'  => $id];
        $sql    = "SELECT * FROM usuarios WHERE id_usuario = :id";
        $user   = $gestor->EXE_QUERY($sql, $param);

        // LOG
        funcoes::CriaLOG($_SESSION['nome'], 'alterou dados do usuário ' . $user[0]['nome'] . ' no BD');

        $sucesso = true;
        $msg = "Dados atualizados com sucesso!";
    }
}
?>

<?php if ($permitido) : ?>
    <?php if (!$erro) : ?>
        <?php if ($sucesso) : ?>
            <div class='m-3 pt-3 pb-2 alert alert-success text-center'>
                <h5><?= $msg ?></h5>
            </div>
        <?php endif; ?>
        <div class="container-fluid perfil">
            <div class="container col-md-6 offset-md-3 pt-2 pb-2">
                <div class="card mt-1 mb-1">
                    <h4 class="text-center mt-3">Editar Informações do Usuário</h4>
                    <hr>
                    <div class="row mb-2">
                        <div class="col">
                            <form action="?a=usuarios-upd&id=<?= $id ?>" method="post">
                                <div class="col-md-12 pt-2 pb-1">
                                    <div class='row ml-2 form-group'>
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Usuário:</strong></label>
                                        <input class='col-sm-9 form-control' type="text" 
                                        name="txt-usuario" value="<?= $user[0]['usuario'] ?>"
                                         readonly>
                                    </div>
                                    <div class='row ml-2 form-group'>
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Nome:</strong></label>
                                        <input class='col-sm-9 form-control' type="text" 
                                        name="txt-nome" required 
                                        placeholder="Digite o nome do usuário" 
                                        pattern=".{4,50}" title="Entre 4 e 50 carcateres." 
                                        value="<?= $user[0]['nome'] ?>">
                                    </div>
                                    <div class='row ml-2 mb-1 form-group'>
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Email:</strong></label>
                                        <input class='col-sm-9 form-control' type="email" 
                                        name="txt-email" required 
                                        placeholder="Digite o email do usuário" 
                                        pattern=".{4,50}" title="Entre 4 e 50 carcateres." 
                                        value="<?= $user[0]['email'] ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center mb-1">
                                    <a class="btn btn-secondary btn-size-150 mr-5" 
                                    href="?a=usuarios-gerir">
                                        Voltar</a>
                                    <button type="submit" class="btn btn-primary btn-size-150">
                                        Atualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class='m-3 pt-3 pb-2 alert alert-danger text-center'>
            <h5><?php echo $msg ?></h5>
        </div>
        <div class="m-3 p-2 text-center">
            <a href="?a=usuarios-gerir" class='mr-2 btn btn-secondary btn-size-150'>Voltar</a>
        </div>
    <?php endif; ?>
<?php else : ?>
    <?php include_once('../../inc/sem_permissao.php') ?>
<?php endif; ?>