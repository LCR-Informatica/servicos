<?php
// servicos_add.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$sucesso    = false;
$erro       = false;
$msg        = '';
$cliente_atual = '';

if(isset($_GET['i'])){
    $cliente_atual = $_GET['i'];
} else {
    $erro = true;
    $msg  = "Cliente não enviado";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $descr  = $_POST['txt-descr'];
    $tipo   = $_POST['txt-tipo'];
    $valor  = $_POST['txt-valor'];
    $qtde   = $_POST['txt-qtde'];

    // inicializa classe gestora de BD
    $gestor = new cl_gestorBD();

    // gravar dados da base
    if (!$erro) {

        $param  = [
            ':id_cli' => $cliente_atual,
            ':descr'  => $descr,
            ':tipo'   => $tipo,
            ':valor'  => $valor,
            ':qtde'   => $qtde
        ];
        $sql  = "INSERT INTO servicos(id_cliente, descricao, orcamento, valor, quantidade, created_at) 
            VALUES(:id_cli, :descr, :tipo, :valor, :qtde, current_timestamp())";
        $gestor->EXE_NON_QUERY($sql, $param);

        $sucesso = true;
        $msg = 'Dados gravados om sucesso.';

        // LOG
        funcoes::CriaLOG($_SESSION['nome_usuario'], ' cadastrou servico para cliente ' . $cliente_atual .
         ' no BD');
    }
}

?>

<?php if ($erro) : ?>
    <div class='m-3 pt-3 pb-2 alert alert-danger text-center'>
        <h5><?= $msg ?></h5>
    </div>
    <div class="m-3 p-2 text-center">
        <a href="?a=servicos-list&i=<?= $cliente_atual?>" 
         class='btn btn-secondary btn-size-150'>Voltar</a>
    </div>
<?php else : ?>
    <?php if ($sucesso) : ?>
        <div class='m-3 pt-3 pb-2 alert alert-success text-center'>
            <h5><?= $msg ?></h5>
        </div>
    <?php endif; ?>
    <div class="container-fluid perfil">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 card m-3 pb-3">
                <h4 class='text-center pt-4 pb-2'>Incluir Novo Serviço/Orçamento</h4>
                <form action="?a=servicos-add&i=<?= $cliente_atual?>" method="post">
                    <div class="col-md-8 offset-md-1 mt-1 pb-1">
                        <div class='row ml-2 form-group'>
                            <label class="col-sm-4 col-form-label">
                                <strong>Descriçao:</strong></label>
                            <input class='col-sm form-control' type="text" 
                            name="txt-descr" required maxlength="80"
                            placeholder="Digite a descrição do serviço." 
                            pattern=".{5,80}" title="Entre 5 e 80 carcateres.">
                        </div>
                        <div class='row ml-2 form-group'>
                            <div class="col-sm-4">
                                <label class="col-form-label font-weight-bold">Tipo:</label>
                            </div>
                            <div class="col-sm mt-2">
                                <input type="radio" id="orcamento" name="txt-tipo" checked value='1'>
                                <label class='ml-2' for="orcamento">Orçamento</label>
                                <input class='ml-5' type="radio" id="servico" name="txt-tipo" value='0'>
                                <label class='ml-2' for="servico">Serviço</label>
                            </div>
                        </div>
                        <div class='row ml-2 form-group'>
                            <label class="col-sm-4 col-form-label">
                                <strong>Valor:</strong></label>
                            <input class='col-sm-4 form-control text-right' type="text" 
                            name="txt-valor" required placeholder="9,999.99">
                        </div>
                        <div class='row ml-2 form-group'>
                            <label class="col-sm-4 col-form-label">
                                <strong>Quantidade:</strong></label>
                            <input class='col-sm-2 form-control' type="number" 
                            name="txt-qtde" required min="1" max="10" value="1"
                            placeholder="Digite a quantidade.">
                        </div>
                    </div>
                    <div class="text-center pb-1 pt-2">
                        <button type="submit" class="btn btn-primary btn-size-150">Incluir</button>
                        <a class="btn btn-secondary btn-size-150 ml-5" 
                         href="?a=servicos-list&i=<?= $cliente_atual ?>">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
<?php endif; ?>