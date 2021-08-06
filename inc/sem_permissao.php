<?php
// sem_permissao.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}
$retorno = explode('a=', $_SERVER['HTTP_REFERER'])[1];

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6 card m-3 p-3">
            <div class="text-center">
                <h1><i class='fa fa-exclamation-triangle text-warning'></i></h1>
                <h4>Usuário não tem permissão de acesso!</h4>
                <a href='?a=<?= $retorno ?>' class='mt-2 btn btn-warning btn-size-150'>Voltar</a>
            </div>
        </div>
    </div>
</div>