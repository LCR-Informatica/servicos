<?php
// perfil.php

// controle de sessão

if (!isset($_SESSION['a'])) {
    exit();
}

if (!funcoes::VerificarLogin()) {
    exit();
}

$erro    = false;
$sucesso = false;
$msg     = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $p = $_GET['p'];
    $gestor = new cl_gestorBD();

    switch ($p) {
        
        case 1: // alterar nome do usuario
            $param = [':id'   => $_SESSION['id_usuario'],
                      ':nome' => $_POST['nome']  ];

            $sql   = "SELECT * FROM usuarios WHERE nome = :nome AND id_usuario = :id";
            $dados = $gestor->EXE_QUERY($sql, $param);

            if (count($dados) != 0) { // não achou outro usuario com o nome digitado
                $temp = $gestor->EXE_NON_QUERY('UPDATE usuarios SET nome = :nome 
                WHERE id_usuario = :id', $param);
                $sucesso = true;
                $msg = 'Nome de usuário alterado com sucesso!';
            }

            break;

        case 2: // alterar email do usuario
            $param = [
                ':id' => $_SESSION['id_usuario'],
                ':email' => $_POST['email']
            ];
            $sql   = "SELECT * FROM usuarios WHERE email = :email AND id_usuario <> :id";
            $dados = $gestor->EXE_QUERY($sql, $param);
            if (count($dados) == 0) {
                $gestor->EXE_NON_QUERY('UPDATE usuarios SET email = :email 
                WHERE id_usuario = :id', $param);
                $sucesso = true;
                $msg = 'Email de usuário alterado com sucesso!';
            } else {
                $erro = true;
                $msg  = 'Email já cadastrado para outro usuário!';
            }
            break;

        case 3: // alterar senha do usuario
            $senha_nova = $_POST['senha_nova'];
            $senha_nova1 = $_POST['senha_nova1'];
            if ($senha_nova != $senha_nova1) {
                $erro = true;
                $msg  = "Senhas digitadas não conferem!";
            } else {
                $param = [
                    ':id' => $_SESSION['id_usuario'],
                    ':senha' => md5($_POST['senha_atual'])
                ];
                $sql   = "SELECT * FROM usuarios WHERE id_usuario = :id AND senha = :senha";
                $dados = $gestor->EXE_QUERY($sql, $param);
                if (count($dados) == 0) {
                    $gestor->EXE_NON_QUERY('UPDATE usuarios SET senha = :senha_nova 
                    WHERE id_usuario = :id', $param);
                    $sucesso = true;
                    $msg = 'Senha de usuário alterado com sucesso!';
                }
            }
            break;
    }
}

$param  = [':id' => $_SESSION['id_usuario']];
$sql    = 'SELECT * FROM usuarios WHERE id_usuario = :id';
$gestor = new cl_gestorBD();
$dados  = $gestor->EXE_QUERY($sql, $param)[0];

?>

<div class="conteiner-fluid perfil">
    <div class="container pt-3 pb-3">
        <div class="row">
            <div class="col-sm-8 offset-sm-2 col-12">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="cx-cliente">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" 
                                data-target="#cp1" aria-expanded="true" 
                                aria-controls="cp1">
                                    Alterar Nome do Usuário
                                </button>
                                <button class="btn btn-link" disabled>Nome atual: 
                                <?php echo $dados['nome'] ?></button>
                            </h5>
                        </div>
                        <div id="cp1" class="collapse show" aria-labelledby="cx-cliente" 
                            data-parent="#accordion">
                            <div class="card-body">
                                <form class="form-group" action="?a=perfil&p=1" 
                                    method="post">
                                    <div class="row">
                                        <input class="col-sm-8 ml-3 form-control" 
                                        type="text" name="nome" 
                                        value="<?php echo $dados['nome'] ?>" required>
                                        <button class="col-sm-3 ml-3 btn btn-primary" 
                                        type="submit">Alterar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="cx-email">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" 
                                data-toggle="collapse" data-target="#cp2" 
                                aria-expanded="false" aria-controls="cp2">
                                    Alterar Email do Usuário
                                </button>
                                <button class="btn btn-link" disabled>Email atual: 
                                    <?php echo $dados['email'] ?></button>
                            </h5>
                        </div>
                        <div id="cp2" class="collapse" aria-labelledby="cx-email" 
                            data-parent="#accordion">
                            <div class="card-body">
                                <form class="form-group" action="?a=perfil&p=2" 
                                    method="post">
                                    <div class="row">
                                        <input class="col-sm-8 ml-3 form-control" 
                                        type="email" name="email" placeholder="Digite o novo email" required>
                                    </div>
                                    <div class="row mt-2">
                                        <input class="col-sm-8 ml-3 form-control" 
                                        type="email" name="email-2" 
                                        placeholder="Repita o novo email" required>
                                        <button class="col-sm-3 ml-3 btn btn-primary" 
                                        type="submit">Alterar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="cx-senha">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" 
                                data-toggle="collapse" data-target="#cp3" 
                                aria-expanded="false" aria-controls="cp3">
                                    Alterar Senha do Usuário
                                </button>
                            </h5>
                        </div>
                        <div id="cp3" class="collapse" aria-labelledby="cx-senha" 
                            data-parent="#accordion">
                            <div class="card-body">
                                <form class="form-group" action="?a=perfil&p=3" 
                                    method="post">
                                    <div class="row">
                                        <input class="col-sm-8 ml-3 form-control" 
                                        type="password" name="senha-atual" 
                                        placeholder="Digite a senha atual" required>
                                    </div>
                                    <div class="row mt-2">
                                        <input class="col-sm-8 ml-3 form-control" 
                                        type="password" name="senha-nova" 
                                        placeholder="Digite a nova senha" required>
                                    </div>
                                    <div class="row mt-2">
                                        <input class="col-sm-8 ml-3 form-control" 
                                        type="password" name="senha-nova-2" 
                                        placeholder="Repita a nova senha" required>
                                        <button class="col-sm-3 ml-3 btn btn-primary" 
                                        type="submit">Alterar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>