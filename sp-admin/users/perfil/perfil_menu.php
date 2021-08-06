<?php
// perfil_menu.php
// permissao indice (ex.: 2) => posição no campo permissoes da tabela de usuarios 001...
// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$permissao = funcoes::Permissao(2);
$erro = false;
$msg = '';

// verifica permissao de acesso
if ($permissao) {

    // busca usuario
    $gestor = new cl_gestorBD();
    $param = [":id_usuario"  => $_SESSION['id_usuario']];
    $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
    $dados = $gestor->EXE_QUERY($sql, $param);
    
}

?>

<?php if (!$permissao) : // nao tem permissao?>

    <?php include_once('../inc/sem_permissao.php') ?>

 <?php else : // tem permissao?> 

    <?php if ($erro) : ?>

        <div class='alert alert-danger text-center'><?php echo $msg ?></div>
        <div class="m-3 p-2 text-center">
            <a href="?a=inicio" class='mr-2 btn btn-secondary btn-size-150'>Voltar</a>
        </div>

    <?php else : ?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 card m-3 p-2">
                    <h4 class='text-center mt-3'>Perfil de Usuário</h4>
                    <hr>
                    <h5 class="text-center">
                        <i class='fa fa-user'></i> Usuário: <?php echo $dados[0]['nome'] ?>
                        <i class='ml-5 fa fa-envelope'></i> Email: <?php echo $dados[0]['email'] ?>
                    </h5>
                    <div class="row mt-3 mb-3 justify-content-center">
                        <a class="col-md-3 mr-3 btn btn-secondary btn-size-100" href="?a=inicio">Voltar</a>
                        <a class='col-md-3 mr-3 btn btn-primary btn-size-100' href="?a=perfil-alterar-senha"><i class='fa fa-lock'></i> Alterar Senha</a>
                        <a class='col-md-3 btn btn-primary btn-size-100' href="?a=perfil-alterar-email"><i class='fa fa-lock'></i> Alterar Email</a>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>