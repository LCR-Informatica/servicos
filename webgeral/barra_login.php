<?php
// barra_login.php

// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

?>

<div class="container-fluid barra-cliente">
    <?php if (funcoes::VerificarLogin()) : ?>
        <div class="dropdown text-warning">
            <i class="fa fa-user mr-1 mt-1"></i>
            <span class="mr-2"><?= $_SESSION['nome_usuario'] ?></span>|
            <a href="" class="ml-1 mr-2 dropdown-toggle" id="d1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> Menu</a>
            <div class="dropdown-menu bg-dark text-light" aria-labelledby="d1">
                <?php if (funcoes::Permissao(0)) : // somente admin tem acesso ?>
                    <a class="dropdown-item" href="?a=cadastro">
                        <i class="fa fa-user-plus"></i> Cadastrar Usuários</a>
                    <a class="dropdown-item" href="?a=usuarios-gerir">
                        <i class="fa fa-users"></i> Gerenciar Usuários</a>
                    <div class="dropdown-divider"></div>
                <?php endif; ?>
                <a class="dropdown-item" href="?a=perfil"><i class="fa fa-user-o">
                    </i> Perfil do usuário atual</a>
                <?php if (!funcoes::Permissao(0)) : // exceto admin ?>
                    <a class="dropdown-item" href="?a=clientes-list">
                        <i class="fa fa-users"></i> Lista de Clientes do usuário</a>
                <?php endif; ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="?a=logout">
                    <i class="fa fa-sign-out"></i> Logout</a>
            </div>
        </div>
    <?php else : ?>
        <!-- formulario de login -->
        <div class="dropdown">
            <a href="" class="mr-2" id="dropdownMenuButton" data-toggle="dropdown" 
            aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-sign-in mr-1 mt-1"></i> Login</a>
            <div class="dropdown-menu bg-dark text-light" aria-labelledby="dropdownMenuButton">
                <form class="p-3" action="?a=login" method="post">
                    <input type="text" class="form-control mb-3" name="usuario" 
                    placeholder="Usuário" pattern=".{4,20}" title="Entre 4 e 20 caracteres" 
                    required>
                    <input type="password" class="form-control mb-3" name="senha" 
                    placeholder="Senha" pattern=".{4,20}" title="Entre 4 e 20 caracteres" 
                    required>
                    <div class="text-center mb-2">
                        <a href="?a=recuperar-senha">Esqueceu a senha?</a>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="mt-2 btn btn-primary">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>