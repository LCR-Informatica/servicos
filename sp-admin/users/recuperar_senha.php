<?php
// recuperar senha
// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$erro = false;
$msg_erro = '';
$msg_enviada = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $gestor = new cl_gestorBD();
    $param = [':email' => $email];
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $dados = $gestor->EXE_QUERY($sql, $param);

    if (count($dados) == 0) {
        $erro = true;
        $msg_erro = "Email não está cadastrado como válido.";
    } else {
        // recuper senha
        $nova_senha_provisoria = funcoes::GeradorDeSenhaAleatorio(rand(10, 20));

        // enviar email para usuario
        $email = new cl_Email();

        $msg_email = [
            $dados[0]['email'],
            ' SERVIÇOS - Recuperação de senha',
            "<h3>SERVIÇOS</h3><h4>RECUPERAÇÃO DA SENHA</h4><p>A nova senha é: " . $nova_senha_provisoria . ", anote-a em local seguro</p>"
        ];

        $msg_enviada = $email->EnviarEmail($msg_email);

        if ($msg_enviada) {
            // alterar a senha na BD
            $param = [':id'    => $dados[0]['id_usuario'],
                      ':senha' => md5($nova_senha_provisoria)];
            $sql = 'UPDATE usuarios SET senha = :senha WHERE id_usuario = :id';
            $dados = $gestor->EXE_NON_QUERY($sql, $param);

            //echo $nova_senha_provisoria;

            // LOG
            funcoes::CriaLOG($dados[0]['nome'], 'solicitou troca de senha.');
        } else {
            $erro = true;
            $msg_erro = 'ATENÇAO, o email de recuperação não foi enviado corretamente, tente novamente.';
        }
    }
}

?>

<?php if ($msg_enviada) : ?>
    <!-- envioa de msg de erro -->
    <?php if ($erro) : ?>
        <div class="alert alert-danger text-center">
            <?php echo $msg_erro; ?>
        </div>
    <?php endif; ?>

    <!-- exibição de formulario -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4 card m-3 p-2 text-center">
                <h3>
                    Recuperação de senha efetuada com sucesso.
                    Verifique a caixa de mensagens do email digitado!
                </h3>
                <a href='?a=inicio' class="btn btn-secondary btn-size-150 text-center">Voltar</a>
            </div>
        </div>
    </div>

<?php else : ?>
    <!-- apresenta msg de sucesso para recyperação de senha -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="text-dark col-md-4 card m-3 p-2">
                <form action="?a=recuperar-senha" method="post">
                    <div class='form-group text-center'>
                        <h2>Recuperar senha</h2>
                        <p>Digite aqui o email cadastrado para recuperar a senha.</p>
                    </div>
                    <div class="form-group p-2">
                        <input type='email' name='email' class="form-control" placeholder="Email do Usuário" required>
                    </div>
                    <div class="form-group text-center">
                        <button role='submit' class="btn btn-primary btn-size-150 mr-3">Recuperar</button>
                        <a href='?a=inicio' class="btn btn-secondary btn-size-150">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endif; ?>