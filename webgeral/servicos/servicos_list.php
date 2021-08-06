<?php
// servicos listagem

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
$servicos = null;
$tot_itens = null;
$itens_pag = 6;
$param = [];
$sql = '';
$campo_busca = '';
$pagina = 1;
$nome_cli = '';

if (isset($_GET['i'])) {
    $cliente_atual = $_GET['i'];
}

// ************************  seção de busca  

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
$item_inicial = ($pagina * $itens_pag) - $itens_pag;

if (isset($_SESSION['texto-busca'])) {
    // filtra a pesquisa
    $campo_busca = $_SESSION['texto-busca'];
    $param = [':p' => "%" . $campo_busca . "%", ':id' => $cliente_atual];
    $sql = 'SELECT * FROM servicos WHERE id_cliente = :id AND (descricao 
     LIKE :p) ORDER BY descricao ASC LIMIT ' . $item_inicial . ',' . $itens_pag;
    $sql_tot = 'SELECT id_servico FROM servicos WHERE id_cliente = :id AND (descricao LIKE :p)';
} else {
    // sem filtro
    $param = [':id' => $cliente_atual];
    $sql = 'SELECT * FROM servicos WHERE id_cliente = :id ORDER BY descricao ASC 
     LIMIT ' . $item_inicial . ',' . $itens_pag;
    $sql_tot = 'SELECT id_servico FROM servicos WHERE id_cliente = :id';
}

$servicos = $gestor->EXE_QUERY($sql, $param);
$tot_itens = count($gestor->EXE_QUERY($sql_tot, $param));

// ****************** pega nome 
$param = [':id' => $cliente_atual];
$sql = 'SELECT nome FROM clientes WHERE id_cliente = :id';
$nome_cli = $gestor->EXE_QUERY($sql, $param)[0]['nome'];
?>

<div class="container-fluid perfil">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 card m-3 pb-3">
                <div class="row">
                    <div class="col text-center pt-3">
                        <h4>Cliente: <?= $nome_cli ?> </h4>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 align-self-center pb-1">
                        <h4>Listagem de Serviços</h4>
                    </div>
                    <div class="col-md-4 align-self-center">
                        <form action="?a=servicos-list&i=<?= $cliente_atual ?>" method="post">
                            <div class="form-inline">
                                <input class="form-control ml-2 p-1" type="text" name="txt-busca" 
                                placeholder="Pesquisa" value="<?= $campo_busca ?>">
                                <button class="p-1 btn btn-primary ml-2">
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="?a=servicos-list&c=true&i=<?= $cliente_atual ?>" 
                                class="p-1 btn btn-warning ml-2">
                                    <i class="fa fa-eraser"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 text-right align-self-center">
                        <a class="p-1 btn btn-primary btn-size-100 mr-2" 
                        href="?a=servicos-add&i=<?= $cliente_atual ?>">Lançar</a>
                        <a class="p-1 btn btn-secondary btn-size-100" href="?a=clientes-list">Voltar</a>
                    </div>
                </div>
                <div>
                    <?php funcoes::Paginacao('?a=servicos-list', $pagina, $itens_pag, $tot_itens); ?>
                </div>
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th class="text-center">Ações</th>
                    </thead>
                    <tbody>
                        <?php foreach ($servicos as $serv) : ?>
                            <tr>
                                <td><?= $serv['descricao'] ?></td>
                                <td>
                                    <?php if ($serv['orcamento']) {
                                        echo "Orçamento";
                                    } else {
                                        echo "Serviço";
                                    } ?>
                                </td>
                                <td><?php echo $serv['valor'] ?></td>
                                <td class="text-center">
                                    <a href="?a=servicos-upd&s=<?= $serv['id_servico']?>
                                     &i=<?= $cliente_atual ?>">
                                        <i class="text-primary ml-1 fa fa-edit"></i></a>
                                    <?php if ($serv['orcamento']) : ?>
                                        <a href="?a=servicos-del&s=<?= $serv['id_servico']?>
                                        &i=<?= $cliente_atual ?>">
                                            <i class="text-danger ml-1 fa fa-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>