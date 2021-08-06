<?php
// usuarios_gerir.php
// permissao indice (ex.: 2) => posição no campo permissoes da tabela de usuarios 001...
// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$permissao = funcoes::Permissao(0);
$erro = false;
$msg = '';

// verifica permissao de acesso
// acesso somente permitido a administradores
?>

<?php if (!$permissao) : // se nao tem permissao ?>

    <?php include_once('../inc/sem_permissao.php') ?>

<?php else : // se tem permissao ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 offset-sm-1 card m-3 pt-2 pb-2">
                <h4 class='text-center mt-3 mb-1'>Gerenciar Usuários Clientes</h4>
                <hr>
                <div class="text-center pb-1">
                    <a class="btn btn-secondary btn-size-150" href="?a=inicio">Voltar</a>
                    <a class='ml-5 btn btn-primary btn-size-150' href="?a=usuarios-add">Novo Usuário...</a>
                </div>
                <div class="row pt-2 pb-2">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <th></th>
                            <th>Usuário</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th class="text-right">Opções</th>
                        </thead>
                        <tbody>
                            <?php
                            // busca usuarios
                            $gestor = new cl_gestorBD();
                            $param = [':id' => 1];
                            $sql = "SELECT * FROM usuarios WHERE id_usuario != :id";
                            $dados = $gestor->EXE_QUERY($sql, $param);
                            ?>
                            <?php foreach ($dados as $du) : ?>
                                <tr>
                                    <td><?php if (substr($du['permissoes'], 0, 1) == 1) : // testa se é admin?>
                                            <i class="fa fa-user"></i>
                                        <?php else : ?>
                                            <i class="fa fa-user-o"></i>
                                        <?php endif; ?></td>
                                    <td><?php echo $du['usuario']; ?></td>
                                    <td><?php echo $du['nome']; ?></td>
                                    <td><?php echo $du['email']; ?></td>
                                    <td><?php
                                        $id = $du['id_usuario'];
                                        $drop = true;
                                        $btn = 'btn btn-primary';
                                        $perm = substr($du['permissoes'], 0, 1); // administrador
                                        if ($_SESSION['id_usuario'] != 1) {
                                            if ($id == $_SESSION['id_usuario']) {
                                                $drop = false;
                                            }
                                            if ($perm == 1) {
                                                $drop = false;
                                            }
                                        } else {
                                            if ($perm == 1) {
                                                $btn = 'btn btn-danger';
                                            }
                                        }?>
                                        <?php if ($drop) : ?>
                                            <div class="dropdown text-right">
                                                <button class="<?php echo $btn ?> fa fa-cog" type="button" id="d2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="d2">
                                                    <a class="dropdown-item" href="?a=usuarios-upd&id=<?php echo $id ?>">
                                                    <i class="fa fa-edit"></i> Editar usuário</a>
                                                    <a class="dropdown-item" href="?a=permissoes-upd&id=<?php echo $id ?>">
                                                    <i class="fa fa-list"></i> Editar permissões</a>
                                                    <a class="dropdown-item" href="?a=usuarios-del&id=<?php echo $id ?>">
                                                    <i class="fa fa-trash"></i> Excluir usuário</a>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="text-right">
                                                <i class="fa fa-cog btn btn-secondary disabled"></i>
                                            </div>
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

<?php endif; ?>