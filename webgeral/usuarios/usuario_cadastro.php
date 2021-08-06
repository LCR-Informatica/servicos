<?php
// usuario_cadastro.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

if (!funcoes::Permissao(0)){
    exit();
}

$sucesso   = false;
$erro      = false;
$msg       = '';
$usuario   = '';
$nome      = '';
$email     = '';
$cod_valid = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = $_POST['txt-usuario'];
    $nome    = $_POST['txt-nome'];
    $email   = $_POST['txt-email'];
    $senha1  = $_POST['txt-senha-1'];
    $senha2  = $_POST['txt-senha-2'];


    if ($senha1 != $senha2) {
        $erro = true;
        $msg  = "As senhas não coincidem!";
    }

    if (!$erro) {
        // inicializa classe gestora de BD
        $gestor = new cl_gestorBD();

        // verificar ocerrencia de dados de usuario na base
        $param = [':usuario'  => $usuario];
        $sql   = "SELECT usuario FROM usuarios WHERE usuario = :usuario";
        if (count($gestor->EXE_QUERY($sql, $param)) != 0) {
            $erro = true;
            $msg = 'Identificação já cadastrada para outro usuário! Favor escolher outra identificação.';
        }

        //verificar ocerrencia de dados de email na base
        $param  = [':email'  => $email];
        $sql    = "SELECT email FROM usuarios WHERE email = :email";
        if (count($gestor->EXE_QUERY($sql, $param)) != 0) {
            $erro = true;
            $msg = 'Email já cadastrado para outro usuário! Favor escolher outro email.';
        }

        $cod_valid = funcoes::GeradorDeCodigosAleatorio(30);

        // enviar email de confirmação de cadastro (validação)
        if (!$erro) {

            $config      = funcoes::Config();
            $link        = $config['BASE_URL'].'?a=validar&v='.$cod_valid;
            $dados_email = [ $email,
                "SERVIÇOS - Confirmação de conta de novo usuário.",
                "<h3><p>Foi criada uma nova conta de usuário, clique no link para confirmar o cadastro.</p>".
                "<a href=$link>$link</a></h3>"
            ];
            $mailTo = new cl_Email();
            $mailTo->EnviarEmail($dados_email);

            if (!$mailTo) {
                $erro = true;
                $msg  = 'Erro no envio do email! Favor tentar novamente mais tarde!';
            }

        }

        // gravar dados da base
        if (!$erro) {
            $param = [
                ':usuario' => $usuario,
                ':senha'   => md5($senha1),
                ':nome'    => $nome,
                ':email'   => $email
            ];

            $sql = "INSERT INTO usuarios(usuario, senha, nome, email, created_at) 
            VALUES(:usuario, :senha, :nome, :email, current_timestamp())";
            $user = $gestor->EXE_NON_QUERY($sql, $param);

            $sucesso = true;
            $msg     = 'Dados gravados om sucesso. Email de validação enviado para o usuário.';

            // LOG
            funcoes::CriaLOG('Sistema', 'incluiu o usuário '.$nome.' no BD');
            funcoes::CriaLOG('Sistema', 'enviou um email de confirmação de cadastro do usuário '.$nome);
        }
    }
}

?>

<div class="container-fluid index-container perfil">
    <?php if ($erro) : ?>
        <div class='alert alert-danger text-center'><?= $msg ?></div>
    <?php endif; ?>

    <?php if ($sucesso) : ?>
        <div class='alert alert-success text-center'><?= $msg ?></div>
    <?php endif; ?>
    <div class="container bg-white card">
        <div class="row">
            <div class="col-sm-6">
                <div class="card mt-4 p-2">
                    <p class="text-center font-weight-bold">Termo de aceitação</p>
                    <p class="text-justify">
                    O usuário se compromete em permanecer em dia com suas obrigações finenceiras 
                    para que seja possível a manutenção e funcionamento do servidor assim como o 
                    acesso ao mesmo on-line.</p>
                    <p class="text-justify">
                    O usuário tem o direito de cancelar o serviço após 1 (hum) ano de contrato, 
                    prazo mínimo para contratação dos serviços de acesso ao sistema on-line, 
                    necessário este período por conta do período mínimo de contratação de serviços 
                    do servidor de hospedagem.</p>
                    <p class="text-justify">
                    O usuário terá as atualizações gratuitas pelo período de contratação dos serviços. 
                    No momento de cancelamento dos mesmos o usuário receberá todos os seus dados 
                    armazenados em formato sql, para que possa se reintegrar a outro sistema caso deseje.</p>
                </div>
            </div>
            <div class="col-sm-6 mt-2 mb-2">
                <h4 class='text-center pb-3'>Cadastrar Novo Usuário</h4>
                <form action="?a=cadastro" method="post">
                    <div class='form-group'>
                        <input class='form-control' type="text" name="txt-nome" required 
                        placeholder="Nome do cliente" pattern=".{4,50}" 
                        title="Entre 5 e 50 carcateres." value='<?= $nome ?>'>
                    </div>

                    <div class='form-group'>
                        <input class='form-control' type="email" name="txt-email" required 
                        placeholder="Email do cliente" pattern=".{4,50}" 
                        title="Entre 5 e 50 carcateres." value='<?= $email ?>'>
                    </div>

                    <div class='form-group'>
                        <input class='form-control' type="text" name="txt-usuario" required 
                        placeholder="Identificação do cliente" pattern=".{4,20}" 
                        title="Entre 4 e 20 carcateres." value='<?= $usuario ?>'>
                    </div>

                    <div class='form-group'>
                        <input class='form-control' type="password" name="txt-senha-1" 
                        id='txt_senha-1' placeholder="Senha do cliente" pattern=".{4,20}" 
                        title="Entre 4 e 20 carcateres." required>
                    </div>

                    <div class='form-group'>
                        <input class='form-control' type="password" name="txt-senha-2"
                         id='txt_senha-2' placeholder="Repetir a Senha" pattern=".{4,20}" 
                         title="Entre 4 e 20 carcateres." required>
                    </div>

                    <div class='form-group text-center'>
                        <input type="checkbox" name="check-termos" id="check-termos" required>
                        <label id='show' for="check-termos">Lí e aceito os Termos de aceitação.</label>
                    </div>

                    <div class="text-center">
                        <a class="btn btn-secondary btn-size-150 mr-2" href="?a=home">Voltar</a>
                        <button type="submit" class="btn btn-primary btn-size-150 mr-2">Cadastrar</button>
                    </div>
                    
                </form>
            </div>
            
        </div>
    </div>
</div>
