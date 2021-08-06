<?php
// cliente_add.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$sucesso    = false;
$erro       = false;
$msg        = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_user  = $_POST['txt-id'];
    $nome     = $_POST['txt-nome'];
    $email    = $_POST['txt-email'];
    $telefone = $_POST['txt-fone'];
    $endereco = $_POST['txt-ender'];

    // inicializa classe gestora de BD
    $gestor = new cl_gestorBD();

    // gravar dados da base
    if (!$erro) {

        $param  = [
            ':id_user' => $id_user,
            ':nome'    => $nome,
            ':email'   => $email,
            ':fone'    => $telefone,
            ':ender'   => $endereco
        ];
        $sql  = "INSERT INTO clientes(id_usuario, nome, email, telefone, endereco, created_at) 
            VALUES(:id_user, :nome, :email, :fone, :ender, current_timestamp())";
        $temp = $gestor->EXE_NON_QUERY($sql, $param);

        $sucesso = true;
        $msg = 'Dados gravados om sucesso.';

        // LOG
        funcoes::CriaLOG($_SESSION['nome_usuario'], ' incluiu o cliente ' . 
        $temp[0]['id_cliente'] . ' no BD');
    }
}


?>

<?php if ($erro) : ?>
    <div class='m-3 pt-3 pb-2 alert alert-danger text-center'>
        <h5><?php echo $msg ?></h5>
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
                <h4 class='text-center pt-4 pb-3'>Incluir Novo Cliente</h4>
                <form action="?a=clientes-add" method="post">
                    <div class="col-md-8 offset-md-1 mt-1 pb-1">
                        <div class='row ml-2 form-group'>
                            <input type="hidden" name="txt-id" 
                            value="<?php echo $_SESSION['id_usuario']?>">
                            <label class="col-sm-3 col-form-label">
                                <strong>Nome:</strong></label>
                            <input class='col-sm form-control' type="text" 
                            name="txt-nome" required 
                            placeholder="Digite o nome do cliente" 
                            pattern=".{4,50}" title="Entre 5 e 50 carcateres.">
                        </div>
                        <div class='row ml-2 form-group'>
                            <label class="col-sm-3 col-form-label">
                                <strong>Email:</strong></label>
                            <input class='col-sm form-control' type="email" 
                            name="txt-email" required 
                            placeholder="Digite o email do cliente" 
                            pattern=".{5,50}" title="Entre 5 e 50 carcateres.">
                        </div>
                        <div class='row ml-2 form-group'>
                            <label class="col-sm-3 col-form-label">
                                <strong>Telefone:</strong></label>
                            <input class='col-sm-4 form-control text-right' type="tel" 
                            name="txt-fone" required
                            placeholder="(99)99999-9999" 
                            pattern="\([0-9]{2}\)[0-9]{5}-[0-9]{4}">
                        </div>
                        <div class='row ml-2 form-group'>
                            <label class="col-sm-3 col-form-label">
                                <strong>Endereço:</strong></label>
                            <input class='col-sm form-control' type="text" 
                            name="txt-ender" required 
                            placeholder="Digite o endereço do cliente" 
                            pattern=".{10,100}" title="Entre 10 e 100 carcateres.">
                        </div>
                    </div>
                    <div class="text-center pt-2 pb-1">
                        <button type="submit" class="btn btn-primary btn-size-150">Incluir</button>
                        <a class="btn btn-secondary btn-size-150 ml-5" 
                        href="?a=clientes-list">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
<?php endif; ?>