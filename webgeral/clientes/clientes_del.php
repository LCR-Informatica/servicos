<?php
// clientes_del.php

// mostragem de dados de um cliente

if (!isset($_SESSION['a'])) {
    exit();
}

$sucesso = false;
$erro = false;
$msg = '';
$id  = -1;
$del = false;


if (isset($_GET["i"])) {
    $id = $_GET["i"];
}
if (isset($_GET['d'])) {
    $del = $_GET["d"];
}

// busca usuario
$gestor = new cl_gestorBD();
$param = [];
$sql = "";
$cliente = '';
$dados = '';

if ($id > 0) {
    $param = [":id" => $id];
    $sql = "SELECT * FROM clientes WHERE id_cliente = :id";
    $dados = $gestor->EXE_QUERY($sql, $param);
    $cliente = $dados[0];
    if (count($dados) == 0) {
        $msg  = "Cliente não encontrado!";
        $erro = true;
    }
    /* deleta o cliente selecionado */ 
    // atentar para os serviços
    if (!$erro && $del) {
        $sql = "DELETE FROM servicos WHERE id_cliente = :id";
        $gestor->EXE_NON_QUERY($sql, $param);
        $sql = "DELETE FROM clientes WHERE id_cliente = :id";
        $gestor->EXE_NON_QUERY($sql, $param);
        $msg  = "Cliente e serviços excluídos com sucesso!";
        $sucesso = true;
        // LOG
        funcoes::CriaLOG($_SESSION['nome_usuario'], ' excluiu o cliente ' . $id . 
        ' e seus serviços do BD');
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
        <a href="?a=clientes-list" class='btn btn-secondary btn-size-150'>Voltar</a>
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
            <div class="col-md-8 card m-3 pb-3 text-center">
                <h4 class='pt-4'>Excluir Dados do Cliente</h4>
                <h5 class="mt-3">Nome: <?php echo $cliente['nome'] ?></h5>
                <h5>Email: <?php echo $cliente['email'] ?></h5>
                <h5>Telefone: <?php echo $cliente['telefone'] ?></h5>
                <h5>Endereço: <?php echo $cliente['endereco'] ?></h5>
                <br>
                <h3 class="text-center text-danger">
                    ATENÇÃO! TODOS os lançamentos para este cliente serão EXCLUÍDOS!</h3>
                <br>
                <div class="text-center mt-2">
                    <a class="mr-5 btn btn-primary btn-size-150" 
                    href="?a=clientes-del&i=<?php echo $cliente['id_cliente'] ?>&d=true">Excluir</a>
                    <a class="btn btn-secondary btn-size-150" href="?a=clientes-list">Voltar</a>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php endif; ?>