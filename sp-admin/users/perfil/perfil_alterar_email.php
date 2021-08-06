<?php
// perfil_alterar_email.php
// permissao indice 2 = pode alterar email
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

        // busca o valore do input

        $email_novo  = $_POST['txt-novo-email'];


        $gestor = new cl_gestorBD();
        $param = [
            'id_usuario'    => $_SESSION['id_usuario'],
            'email'         => $email_novo
        ];
        $sql = 'SELECT id_usuario, email FROM usuarios WHERE id_usuario <> :id_usuario AND email = :email';
        $dados = $gestor->EXE_QUERY($sql, $param);

        if (count($dados) != 0) {
            $erro = true;
            $msg = "Email já cadastrado para outro usuário.";
        }

        if (!$erro) {

            $param = [
                'id_usuario'    => $_SESSION['id_usuario'],
                'email'         => $email_novo,
                'data_atu'      => funcoes::Datas()
            ];
            $sql = 'UPDATE usuarios SET email = :email, updated_at = :data_atu WHERE id_usuario = :id_usuario';
            $dados = $gestor->EXE_NON_QUERY($sql, $param);

            $_SESSION['email'] = $email_novo;

            $sucesso = true;
            $msg = 'Email atualizado com sucesso!';

            // LOG
            funcoes::CriaLOG($_SESSION['nome_usuario'] ,'alterou o email.');
        }
    }
}
?>
<?php if (!$permissao) : // nao tem permissao
?>

    <?php include_once('inc/sem_permissao.php') ?>

<?php else : // tem permissao 
?>

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
                    <h4 class='text-center mt-3'>Alterar Email</h4>
                    <hr>
                    <form action='?a=perfil-alterar-email' method="post">

                        <div class="row mt-1 form-group">
                            <div class="col-sm-3 pt-2 ml-2">
                                <strong>Email atual:</strong>
                            </div>
                            <div class="col-sm-8">
                                <label class="form-control">
                                <?php echo $_SESSION['email_usuario'] ?></label>
                            </div>                             
                        </div>

                        <div class="row form-group">
                            <div class="ml-2 pt-2 col-sm-3">
                                <strong>Novo Email:</strong>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="txt-novo-email" class="form-control mb-1" require title="No mínimo 5 e no máximo 50 caracteres." pattern=".{5,50}" placeholder="Digite o novo email">
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