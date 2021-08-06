<?php
// barra usuario

// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$login = funcoes::VerificarLogin();
$nome_usuario = "Sem usuário ativo.";
$classe = 'barra-usuario-inativo';
?>

<div class="container-fluid barra-usuario">

    <?php if ($login) : ?>
        <?php
            $nome_usuario = $_SESSION['nome_usuario'];
            $classe = 'barra-usuario-ativo';
        ?>

        <div class="dropdown">
            <i class="fa fa-user mr-2"></i><?php echo $nome_usuario ?>
            <button class="ml-2 btn btn-secondary dropdown-toggle" type="button" id="d1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-cog"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="d1">
                <a class="dropdown-item" href="?a=perfil"><i class="fa fa-user-o"></i> Perfil do usuário</a>
                <div class="dropdown-divider"></div>

                <?php if (funcoes::Permissao(0)) : // só admins ?>

                    <a class="dropdown-item" href="?a=usuarios-gerir"><i class="fa fa-users"></i> Gerenciar Usuários</a>
                    <div class="dropdown-divider"></div>
                
                <?php endif; ?>

                <a class="dropdown-item" href="?a=logout"><i class="fa fa-sign-out"></i> Logout</a>
            </div>
        </div>

    <?php else : ?>

        <span class="<?php echo $classe ?>">
            <i class="fa fa-user m-2"></i> <?php echo $nome_usuario ?>
        </span>

    <?php endif; ?>

</div>