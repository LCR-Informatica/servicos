<?php
// usuarios_add.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$permissao  = funcoes::Permissao(0);
$sucesso    = false;
$erro       = false;
$msg        = '';

// controle de permissao indice 
// só administradores podem incluir novos usuarios
$ps = funcoes::Permissoes();

if ($permissao) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario    = $_POST['txt-usuario'];
        $senha      = $_POST['txt-senha'];
        $nome       = $_POST['txt-nome'];
        $email      = $_POST['txt-email'];

        $permissoes = [];
        if (isset($_POST['check-permissoes'])) {
            $permissoes = $_POST['check-permissoes'];
        }

        $permissoes_total = count($ps);
        $permissoes_finais = '';

        for ($i = 0; $i < 50; $i++) {
            if ($i < $permissoes_total) {
                if (in_array($i, $permissoes)) {
                    $permissoes_finais .= '1';
                } else {
                    $permissoes_finais .= '0';
                }
            } else {
                $permissoes_finais .= '1';
            }
        }

        // inicializa classe gestora de BD
        $gestor = new cl_gestorBD();

        // verificar ocerrencia de dados de usuario na base
        $param  = [':usuario'  => $usuario];
        $sql    = "SELECT usuario FROM usuarios WHERE usuario = :usuario";
        $temp   = $gestor->EXE_QUERY($sql, $param);
        if (count($temp) != 0) {
            $erro = true;
            $msg = 'Identificação já cadastrada para outro usuário! Favor escolher outra identificação.';
        }

        // verificar ocerrencia de dados de email na base
        $param  = [':email'  => $email];
        $sql    = "SELECT email FROM usuarios WHERE email = :email";
        $temp   = $gestor->EXE_QUERY($sql, $param);
        if (count($temp) != 0) {
            $erro = true;
            $msg = 'Email já cadastrado para outro usuário! Favor escolher outro email.';
        }

        // enviar email de confirmação de cadastro
        if (!$erro) {
            $dados_email = [
                $email,
                "SERVIÇOS - Criação de conta de novo usuário.",
                "<p>Foi criada uma nova conta de usuário com os seguintes dados:</p>
                 <p>Usuário: $usuario</p> <p>Senha: $senha</p>"
            ];
            $mailTo = new cl_Email();
            $mailTo->EnviarEmail($dados_email);

            if (!$mailTo) {
                $erro = true;
                $msg = 'Erro no envio do email! Favor tentar novamente mais tarde!';
            }
        }

        // gravar dados da base
        if (!$erro) {
            $param  = [
                ':usuario'      => $usuario,
                ':senha'        => md5($senha),
                ':nome'         => $nome,
                ':email'        => $email,
                ':permissoes'   => $permissoes_finais
            ];
            $sql  = "INSERT INTO usuarios(usuario, senha, nome, email, permissoes, created_at) 
                VALUES(:usuario, :senha, :nome, :email, :permissoes, current_timestamp())";
            $temp = $gestor->EXE_NON_QUERY($sql, $param);

            $sucesso = true;
            $msg = 'Dados gravados om sucesso. Email de cadastro enviado para o usuário.';

            // LOG
            funcoes::CriaLOG($_SESSION['nome'], 'incluiu usuario ' . $nome . ' no BD');
            funcoes::CriaLOG($_SESSION['nome'], 'enviou email de cadastro do usuario ' . $nome);
        }
    }
}
?>

<?php if (!$permissao) : ?>
    <?php include_once('../../inc/sem_permissao.php')  // nao tem permissao 
    ?>
<?php else : // tem permissao 
?>
    <?php if (!$erro) : ?>
        <?php if ($sucesso) : ?>
            <div class='m-3 pt-3 pb-2 alert alert-success text-center'>
                <h5><?php echo $msg ?></h5>
            </div>
        <?php endif; ?>
        <div class="container-fluid perfil">
            <div class="container offset-md-2 col-md-8 pt-2 pb-2">
                <div class="card mt-1 mb-1">
                    <h4 class='text-center mt-3'>Adicionar Usuário</h4>
                    <hr>
                    <div class="row mb-2">
                        <div class="col">
                            <form action="?a=usuarios-add" method="post">
                                <div class="col-md-10 offset-md-1 mt-1 pb-1">
                                    <div class='row ml-2 form-group'>
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Nome:</strong></label>
                                        <input class='col-sm-8 form-control' type="text" 
                                        name="txt-nome" required 
                                        placeholder="Digite o nome do usuário" 
                                        pattern=".{4,50}" title="Entre 5 e 50 carcateres.">
                                    </div>
                                    <div class='row ml-2 form-group'>
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Email:</strong></label>
                                        <input class='col-sm-8 form-control' type="email" 
                                        name="txt-email" required 
                                        placeholder="Digite o email do usuário" 
                                        pattern=".{4,50}" title="Entre 5 e 50 carcateres.">
                                    </div>
                                    <div class='row ml-2 form-group'>
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Usuário:</strong></label>
                                        <input class='col-sm-8 form-control' type="text" 
                                        name="txt-usuario" required 
                                        placeholder="Digite a identificação do usuário" 
                                        pattern=".{4,50}" title="Entre 5 e 50 carcateres.">
                                    </div>
                                    <div class='row ml-2 form-group'>
                                        <label class="col-sm-2 col-form-label">
                                            <strong>Senha:</strong></label>
                                        <input class='col-sm-8 form-control' type="password" 
                                        name="txt-senha" id='txt_senha' required readonly 
                                        placeholder="Senha do usuário">
                                        <button type="button" class="btn btn-primary ml-2" 
                                        onclick="gerarSenha(15)">Gerar Senha</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center pb-1">
                                    <a class="btn btn-secondary btn-size-150 mr-2" 
                                    href="?a=usuarios-gerir">
                                        Voltar</a>
                                    <button type="submit" class="btn btn-primary btn-size-150 mr-2">
                                        Incluir</button>
                                    <button type="button" class="btn btn-info btn-size-250" 
                                    data-toggle="collapse" data-target='#caixa_permissoes'>
                                        Definir Permissões</button>
                                </div>
                                <div class='collapse card m-3 p-1' id="caixa_permissoes">
                                    <div class="row m-3">
                                        <?php
                                        $id = 0;
                                        $perm = $ps;
                                        foreach ($perm as $p) { ?>
                                            <div class="col-sm-4 checkbox">
                                                <input type="checkbox" name="check-permissoes[]" 
                                                id="checkbox-permissao" value='<?= $id; ?>'>
                                                <span class="permissao-titulo"><?= $p['permissao'] ?>
                                                </span>
                                                <p class="permissao-sumario"><?= $p['sumario'] ?></p>
                                            </div>
                                        <?php $id++;
                                        } ?>
                                    </div>
                                    <div class='text-center'>
                                        <a href="#" onclick="checar(true); 
                                        return false">Marcar Todas</a> |
                                        <a href="#" onclick="checar(false); 
                                        return false">Desmarcar Todas</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class='m-3 pt-3 pb-2 alert alert-danger text-center'>
            <h5><?php echo $msg ?></h5>
        </div>
    <?php endif; ?>
<?php endif; ?>