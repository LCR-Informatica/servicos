<?php
// servicos_del.php

if (!isset($_SESSION['a'])) {
    exit();
}

$sucesso = false;
$erro = false;
$msg = '';
$id  = -1;
$del = false;


if (isset($_GET["s"])) {
    $id = $_GET["s"];
}
if (isset($_GET['d'])) {
    $del = $_GET["d"];
}
if(isset($_GET['i'])){
    $cliente_atual = $_GET['i'];
}

// busca usuario
$gestor = new cl_gestorBD();
$param = [];
$sql = "";
$servico = '';
$dados = '';

if ($id > 0) {
    $param = [":id" => $id];
    $sql = "SELECT * FROM servicos WHERE id_servico = :id";
    $dados = $gestor->EXE_QUERY($sql, $param);
    $servico = $dados[0];
    if (count($dados) == 0) {
        $msg  = "Servico não encontrado!";
        $erro = true;
    }
    /* deleta o cliente selecionado */ 
    // atentar para os serviços
    if (!$erro && $del) {
        $sql = "DELETE FROM servicos WHERE id_servico = :id";
        $gestor->EXE_NON_QUERY($sql, $param);
        $msg  = "Serviço excluído com sucesso!";
        $sucesso = true;
    }
} else {
    $msg  = "Cliente não encontrado!";
    $erro = true;
}

?>

<?php if ($erro) : ?>
    <div class='m-3 pt-3 pb-2 alert alert-danger text-center'>
        <h5><?php echo $msg ?></h5>
    </div>
    <div class="m-3 p-2 text-center">
        <a href="?a=servicos-list&i=<?php echo $cliente_atual?>" 
         class='btn btn-secondary btn-size-150'>Voltar</a>
    </div>
<?php else : ?>
    <?php if ($sucesso) : ?>
        <div class='m-3 pt-3 pb-2 alert alert-success text-center'>
            <h5><?php echo $msg ?></h5>
        </div>
    <?php endif; ?>
    <div class="container-fluid perfil">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 card text-center m-3">
                <h4 class='pt-4'>Excluir Serviço</h4>
                <h5 class="mt-3">Descriçao: <?php echo $servico['descricao']?></h5>
                <h5>Tipo: <?php echo ($servico['orcamento']) ? 'Serviço' : 'Orçamento' ?></h5>
                <h5>Valor: <?php echo $servico['valor']?></h5>
                <h5>Quantidade: <?php echo $servico['quantidade']?></h5>
                <div class="pt-3 pb-3">
                    <a class="mr-5 btn btn-primary btn-size-150" 
                    href="?a=servicos-del&s=<?php echo $servico['id_servico']?>&d=true">Excluir</a>
                    <a class="btn btn-secondary btn-size-150" 
                    href="?a=servicos-list&i=<?php echo $cliente_atual?>">
                    Voltar</a>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php endif; ?>