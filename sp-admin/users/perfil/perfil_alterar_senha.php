<?php
// perfil_alterar_senha.php
// permissao indice 2 = pode alterar senha
// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$erro = false;
$sucesso = false;
$permissao = funcoes::Permissao(2);
$msg = '';

// verifica permissao de acesso
if ($permissao) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // busca os valores dos inputs
        $senha_atual = $_POST['txt-senha-atual'];
        $senha_nova_1 = $_POST['txt-nova-senha-1'];
        $senha_nova_2 = $_POST['txt-nova-senha-2'];

        /* 
        1. a senha atual tem que ser igaul a da BD
        2. a senha 1 tem que ser igual a senha 2
        3. pode gravar no BD
        NOTA: atençao ao MD5
        */
        
        $gestor = new cl_gestorBD();
        $param = [
            'id_usuario'    => $_SESSION['id_usuario'],
            'senha'         => md5($senha_atual)
        ];
        $sql = 'SELECT id_usuario, senha FROM usuarios WHERE id_usuario = :id_usuario AND senha = :senha';
        $dados = $gestor->EXE_QUERY($sql, $param);

        if (count($dados) == 0) {
            $erro = true;
            $msg = "Senha atual não coincide.";
        }

        if (!$erro) {
            if ($senha_nova_1 != $senha_nova_2) {
                $erro = true;
                $msg = "Novas senhas são diferentes entre si.";
            }
        }

        if (!$erro) {
           
            $param = [
                'id_usuario' => $_SESSION['id_usuario'],
                'senha'      => md5($senha_nova_1)
            ];
            $sql = 'UPDATE usuarios SET senha = :senha, updated_at = current_timestamp() 
            WHERE id_usuario = :id_usuario';
            $dados = $gestor->EXE_NON_QUERY($sql, $param);

            $sucesso = true;
            $msg = 'Senha atualizada com sucesso!';

            // LOG
            funcoes::CriaLOG($_SESSION['nome_usuario'], 'alterou a senha.');
        }
    }
}
?>
<?php if (!$permissao) : // nao tem permissao?>

    <?php include_once('inc/sem_permissao.php') ?>

<?php else : // tem permissao ?>
    
    <?php if ($erro) : ?>
        <div class='alert alert-danger text-center'><?php echo $msg ?></div>
    <?php endif; ?>

    <?php if ($sucesso) : ?>

        <div class='alert alert-success text-center'><?php echo $msg ?></div>
        <div class="m-3 p-2 text-center">
            <a href="?a=perfil" class='mr-2 btn btn-secondary btn-size-150'>Voltar</a>
        </div>

    <?php else : ?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 card m-3 p-2">
                    <h4 class='text-center mt-3'>Alterar Senha</h4>
                    <hr>
                    <form action='?a=perfil-alterar-senha' method="post">
                        <div class="row mt-1 form-group">
                            <div class="ml-2 pt-2 col-sm-3">
                                <strong>Senha atual:</strong>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="txt-senha-atual" class="form-control" require title="No mínimo 4 e no máximo 20 caracteres." pattern=".{4,20}" placeholder="Digite a senha atual">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="ml-2 pt-2 col-sm-3"><strong>Nova Senha:</strong></div>
                            <div class="col-sm-8">
                                <input type="text" name="txt-nova-senha-1" class="form-control" require title="No mínimo 4 e no máximo 20 caracteres." pattern=".{4,20}" placeholder="Digite a nova senha">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="ml-2 pt-2 col-sm-3"> <strong>Repetir:</strong></div>
                            <div class="col-sm-8">
                                <input type="text" name="txt-nova-senha-2" class="form-control mb-1" require title="No mínimo 4 e no máximo 20 caracteres." pattern=".{4,20}" placeholder="Repita a nova senha">
                            </div>
                        </div>
                        <hr>
                        <div class="text-center mb-2">
                            <a href="?a=perfil" class='btn btn-secondary btn-size-150'>Voltar</a>
                            <button role="submit" class='ml-4 btn btn-primary btn-size-150'>Alterar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>