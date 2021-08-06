<?php
// clientes listagem

// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

// verifica se há um post e seta o valor da pesquisa na sessão
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['txt-busca'] != '') {
        $_SESSION['texto-busca'] = $_POST['txt-busca'];
    }
}

$gestor = new cl_gestorBD();
$clientes = null;
$tot_itens = null;
$itens_pag = 6;
$param = [];
$sql = '';
$campo_busca = '';
$pagina = 1;

if (isset($_GET['c'])) { // limpa sessão
    if ($_GET['c'] == true) {
        if (isset($_SESSION['texto-busca'])) {
            unset($_SESSION['texto-busca']);
            unset($_SESSION['pag-busca']);
        }
    }
}

if (isset($_GET['p'])) {
    $pagina = $_GET['p'];
    $_SESSION['pag-busca'] = $pagina;
}

if (isset($_SESSION['pag-busca'])) {
    $pagina = $_SESSION['pag-busca'];
}
$user_ativo = $_SESSION['id_usuario'];
$item_inicial = ($pagina * $itens_pag) - $itens_pag;

if (isset($_SESSION['texto-busca'])) {
    // filtra a pesquisa
    $campo_busca = $_SESSION['texto-busca'];
    $param = [':p'  => "%" . $campo_busca . "%", ':id' => $user_ativo];
    $sql = 'SELECT * FROM clientes WHERE id_usuario = :id AND (nome LIKE :p OR email LIKE :p) 
     ORDER BY nome ASC LIMIT ' . $item_inicial . ',' . $itens_pag;
    $sql_tot = 'SELECT id_cliente FROM clientes WHERE id_usuario = :id 
     AND (nome LIKE :p OR email LIKE :p)';
} else {
    // sem filtro
    $param = [':id' => $user_ativo];
    $sql = 'SELECT * FROM clientes WHERE id_usuario = :id ORDER BY nome 
     ASC LIMIT ' . $item_inicial . ',' . $itens_pag;
    $sql_tot = 'SELECT id_cliente FROM clientes WHERE id_usuario = :id';
}

$clientes = $gestor->EXE_QUERY($sql, $param);
$tot_itens = count($gestor->EXE_QUERY($sql_tot, $param));

?>

<div class="container-fluid perfil">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 card m-3 pb-3">
                <div class="row">
                    <div class="col-md-4 align-self-center mt-3 mb-3">
                        <h4>Listagem de Clientes</h4>
                    </div>
                    <div class="col-md-4 align-self-center">
                        <form action="?a=clientes-list" method="post">
                            <div class="form-inline">
                                <input class="form-control ml-3 p-1" type="text" name="txt-busca" placeholder="Pesquisa" value="<?php echo $campo_busca ?>">
                                <button class="p-1 btn btn-primary ml-2">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="?a=clientes-list&c=true" class="p-1 btn btn-warning ml-2">
                                    <i class="fa fa-eraser"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 text-right align-self-center">
                        <a class="p-1 btn btn-primary btn-size-150 mr-2" href="?a=clientes-add">Novo Cliente</a>
                        <a class="p-1 btn btn-secondary btn-size-150" href="?a=home">Voltar</a>
                    </div>

                </div>
                <div>
                    <?php funcoes::Paginacao('?a=clientes-list', $pagina, $itens_pag, $tot_itens); ?>
                </div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th class="text-center">Ações</th>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cli) : ?>
                            <tr>
                                <td><?php echo $cli['nome'] ?></td>
                                <td><a href="mailto:<?php echo $cli['email'] ?>">
                                        <?php echo $cli['email'] ?></a></td>
                                <td><?php echo $cli['telefone'] ?></td>
                                <td class="text-center">
                                    <a href="?a=servicos-list&i=<?php echo $cli['id_cliente'] ?>&n=<?php echo $cli['nome'] ?>">
                                        <i class="text-success fa fa-wrench"></i></a>
                                    <a href="?a=clientes-upd&i=<?php echo $cli['id_cliente'] ?>">
                                        <i class="text-primary ml-1 fa fa-edit"></i></a>
                                    <a href="?a=clientes-del&i=<?php echo $cli['id_cliente'] ?>">
                                        <i class="text-danger ml-1 fa fa-trash"></i></a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>