<?php
// permissoes_upd.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$permitido  = funcoes::Permissao(0);
$sucesso    = false;
$erro       = false;
$msg        = '';
$todas      = "Todas";

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

    if (substr($user[0]['permissoes'], 0, 1) == 1 && $_SESSION['id_usuario'] != 1) { // outro admin alterando admin
        $permitido = false;
    }

    if (count($user) == 0) {
        $erro = true;
        $msg = "Usuário não encontrado!";
    }
} else {

    include_once('../inc/sem_permissao.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $permissoes = [];
    if (isset($_POST['check-permissoes'])) {
        $permissoes = $_POST['check-permissoes'];
    }

    $permissoes_total = count(include('../inc/permissoes.php'));

    $permissoes_finais = '';
    for ($i = 0; $i < 50; $i++) {
        if ($i < $permissoes_total) {
            if (in_array($i, $permissoes)) {
                $permissoes_finais .= '1';
            } else {
                $permissoes_finais .= '0';
            }
        } else {
            $permissoes_finais .= '1';
        }
    }

    // gravar dados da base
    $param  = [
        ':id'         => $id,
        ':permissoes' => $permissoes_finais
    ];
    $sql  = "UPDATE usuarios SET permissoes = :permissoes WHERE id_usuario = :id";
    $gestor->EXE_NON_QUERY($sql, $param);

    // atualiza informações 
    $param  = [':id'  => $id];
    $sql    = "SELECT * FROM usuarios WHERE id_usuario = :id";
    $user   = $gestor->EXE_QUERY($sql, $param);

    // LOG
    funcoes::CriaLOG($_SESSION['nome_usuario'] ,'alterou as permissoes do usuario '.$user[0]['nome'].'no BD');

    $sucesso = true;
    $msg = "Dados atualizados com sucesso!";
}

?>


<?php if ($permitido) : ?>

    <?php if (!$erro) : ?>

        <?php if ($sucesso) : ?>

            <div class='m-3 pt-3 pb-2 alert alert-success text-center'>
                <h5><?php echo $msg ?></h5>
            </div>

        <?php endif; ?>

        <div class="container card mt-3 mb-3">
            <h4 class="text-center mt-3">Editar Permissões do Usuário</h4>
            <hr>
            <div class="row mb-3">
                <div class="col pl-3 pr-3">
                    <h5 class="text-center"><strong>Usuário: <?php echo $user[0]['nome'] ?></strong></h5>
                    <hr>
                    <form action="?a=permissoes-upd&id=<?php echo $id ?>" method="post">
                        <div class='row m-3'>
                            <?php
                            $id = 0;
                            $perm = include('../inc/permissoes.php');
                            foreach ($perm as $p) {
                            ?>
                                <div class="col-sm-4 checkbox">
                                    <?php
                                    $ptemp = substr($user[0]['permissoes'], $id, 1);
                                    $checked = $ptemp == '1' ? 'checked' : '';
                                    ?>
                                    <input type="checkbox" name="check-permissoes[]" id="checkbox-permissao" value='<?php echo $id; ?>' <?php echo $checked; ?>>
                                    <span class="permissao-titulo"><?php echo $p['permissao'] ?></span>
                                    <p class="permissao-sumario"><?php echo $p['sumario'] ?></p>
                                </div>
                            <?php $id++;
                            } ?>
                        </div>
                        <div class="text-center">                           
                            <a href="#" onclick="checar(true); return false">Marcar Todas</a> |
                            <a href="#" onclick="checar(false); return false">Desmarcar Todas</a>
                        </div>
                        <hr>
                        <div class="text-center">
                        <a class="btn btn-secondary btn-size-150 mr-5" href="?a=usuarios-gerir">Voltar</a>
                            <button type="submit" class="btn btn-primary btn-size-150">Atualizar</button>
                        </div>
                    </form>
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

    <?php include_once('../inc/sem_permissao.php') ?>

<?php endif; ?>
