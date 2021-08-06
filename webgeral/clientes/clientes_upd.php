<?php
// cliente_alterar.php

// mostragem de dados de um cliente

if (!isset($_SESSION['a'])) {
    exit();
}

$sucesso = false;
$erro = false;
$msg = '';
$id  = -1;

if (isset($_GET["i"])) {
    $id = $_GET["i"];
}

// busca usuario
$gestor = new cl_gestorBD();
$param = [];
$sql = "";
$cliente = '';

// request post

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_cli   = $_POST['txt-cli'];
    $nome     = $_POST['txt-nome'];
    $email    = $_POST['txt-email'];
    $telefone = $_POST['txt-fone'];
    $endereco = $_POST['txt-ender'];

    // inicializa classe gestora de BD
    $gestor = new cl_gestorBD();

    // gravar dados da base
    if (!$erro) {

        $param  = [
            ':id_cli'  => $id_cli,
            ':nome'    => $nome,
            ':email'   => $email,
            ':fone'    => $telefone,
            ':ender'   => $endereco
        ];
        $sql  = "UPDATE clientes SET nome = :nome, email = :email, 
        telefone = :fone, endereco = :ender WHERE id_cliente = :id_cli";
        $gestor->EXE_NON_QUERY($sql, $param);

        $sucesso = true;
        $msg = 'Dados gravados om sucesso.';

        $param = [":id" => $id_cli];
        $sql   = "SELECT * FROM clientes WHERE id_cliente = :id";
        $cliente = $gestor->EXE_QUERY($sql, $param)[0];

        // LOG
        funcoes::CriaLOG($_SESSION['nome_usuario'], ' alterou o cliente ' . $id_cli . ' no BD');
    }
} else {

    if ($id > 0) {
        $param = [":id" => $id];
        $sql   = "SELECT * FROM clientes WHERE id_cliente = :id";
        $cliente = $gestor->EXE_QUERY($sql, $param)[0];
        if (count($cliente) == 0) {
            $msg  = "Cliente não encontrado!";
            $erro = true;
        }
    } else {
        $msg  = "Cliente não encontrado!";
        $erro = true;
    }
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
                <div class="col-md-8 card m-3 pb-3">
                    <h4 class='text-center pt-4 pb-2'>Alterar Dados do Cliente</h4>
                    <form action="?a=clientes-upd" method="post">
                        <input type="hidden" name="txt-cli" value="<?= $cliente['id_cliente'] ?>">
                        <div class="col-md-8 offset-md-1 mt-1 pb-1">
                            <div class='row ml-2 form-group'>
                                <label class="col-sm-3 col-form-label">
                                    <strong>Nome:</strong></label>
                                <input class='col-sm form-control' 
                                type="text" value="<?= $cliente['nome'] ?>" 
                                name="txt-nome" required 
                                placeholder="Digite o nome do cliente" 
                                pattern=".{4,50}" title="Entre 5 e 50 carcateres.">
                            </div>
                            <div class='row ml-2 form-group'>
                                <label class="col-sm-3 col-form-label">
                                    <strong>Email:</strong></label>
                                <input class='col-sm form-control' 
                                type="email" value="<?= $cliente['email'] ?>" 
                                name="txt-email" required 
                                placeholder="Digite o email do cliente" 
                                pattern=".{5,50}" title="Entre 5 e 50 carcateres.">
                            </div>
                            <div class='row ml-2 form-group'>
                                <label class="col-sm-3 col-form-label">
                                    <strong>Telefone:</strong></label>
                                <input class='col-sm-4 form-control text-right' 
                                type="tel" name="txt-fone" required 
                                placeholder="(99)99999-9999 " value="<?= $cliente['telefone'] ?>" 
                                pattern="\([0-9]{2}\)[0-9]{5}-[0-9]{4}">
                            </div>
                            <div class='row ml-2 form-group'>
                                <label class="col-sm-3 col-form-label">
                                    <strong>Endereço:</strong></label>
                                <input class='col-sm form-control' 
                                type="text" name="txt-ender" required 
                                value="<?= $cliente['endereco'] ?>" 
                                placeholder="Digite o endereço do cliente" 
                                pattern=".{10,100}" title="Entre 10 e 100 carcateres.">
                            </div>
                        </div>
                        <div class="text-center pt-2 pb-1">
                            <button type="submit" class="btn btn-primary btn-size-150">Alterar</button>
                            <a class="btn btn-secondary btn-size-150 ml-5" 
                             href="?a=clientes-list">Voltar</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>