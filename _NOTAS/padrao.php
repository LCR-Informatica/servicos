<?php
// arquivo.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$permissao = funcoes::Permissao(0);
$erro = false;
$msg = '';

// controle de permissao indice 
if ($permissao) {

    // busca usuario
    $gestor = new cl_gestorBD();
    $param = [];
    $sql = "";
    $dados = $gestor->EXE_QUERY($sql, $param);
    
}

?>

<?php if (!$permissao) : ?>

<?php include_once('inc/sem_permissao.php') ?>

<?php else : ?>

    <?php if ($erro) : ?>

        <div class='m-3 pt-3 pb-2 alert alert-danger text-center'>
                <h5><?php echo $msg ?></h5>
        </div>
        <div class="m-3 p-2 text-center">
            <a href="?a=rota" class='btn btn-secondary btn-size-150'>Voltar</a>
        </div>

    <?php else : ?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 card m-3 pb-3">
                    <h4 class='text-center pt-4'>titulo</h4>
                    <hr>
                    <h6>continuar com implementação de dados</h6>
                    <hr>
                    <div class="text-center">
                        <a class="btn btn-secondary btn-size-100" href="?a=rota">Voltar</a>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>