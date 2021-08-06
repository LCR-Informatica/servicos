<?php
// roteador

// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}
$nome = '';
if(funcoes::VerificarLogin()){
    $nome = $_SESSION['nome_usuario'];
    funcoes::DestroiSessao();
}
?>

<div class='container-fluid index-container'>
    <div class="row">
        <div class="col-4 offset-4 mt-3 mb-3 card p-4">
            <div class="text-center">
                <?php if($nome!=''): ?>
                    <p>Volte sempre, <b><?php echo $nome ?></b>.</p>
                <?php else: ?>
                    <p><b>Não há usuário logado!</b></p>
                <?php endif; ?>
                <a href="?a=home" class="btn btn-primary btn-size-150">Sair</a>
            </div>
        </div>
    </div>
</div>
