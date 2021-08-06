<?php
// SETUP - inserir usuarios (meus clientes)
// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$cod_validacao = funcoes::GeradorDeCodigosAleatorio(30);
$validado = 1;

// aciona classe gestora de dados
$gestor = new cl_gestorBD();

// agaga os dados da tebela usuarios
$gestor->EXE_NON_QUERY('DELETE FROM usuarios');

// reseta auto_increment para 1
$gestor->EXE_NON_QUERY('ALTER TABLE usuarios AUTO_INCREMENT = 1');

//========================== 
// usuario 1
$param = [
    ':usuario'      => 'admin',
    ':senha'        => md5('admin'),
    ':nome'         => 'Administrador',
    ':email'        => 'cameraeuterpe@gmail.com',
    ':permissoes'   => str_repeat('1',50),
    ':cod_validacao' => $cod_validacao,
    ':validado'      => $validado
];
$sql = 'INSERT INTO usuarios(usuario, senha, nome, email, permissoes, codigo_validacao, validado, created_at)
VALUES(:usuario, :senha, :nome, :email, :permissoes, :cod_validacao, :validado, current_timestamp())';

// insere usuario na tabela
$gestor->EXE_NON_QUERY($sql , $param );

//========================== 
// usuario 2
$param = [
    ':usuario'      => 'luiz',
    ':senha'        => md5('luiz'),
    ':nome'         => 'Luiz Gomes',
    ':email'        => 'luiz@email.com',
    ':permissoes'   => str_repeat('1',50),
    ':cod_validacao' => $cod_validacao,
    ':validado'      => $validado
];
$sql = 'INSERT INTO usuarios(usuario, senha, nome, email, permissoes, codigo_validacao, validado, created_at)
VALUES(:usuario, :senha, :nome, :email, :permissoes, :cod_validacao, :validado, current_timestamp())';;

// insere usuarios na tabela
$gestor->EXE_NON_QUERY($sql , $param );

//========================== 
// usuario 3
$param = [
    ':usuario'      => 'cindia',
    ':senha'        => md5('cindia'),
    ':nome'         => 'Cindia Gomes',
    ':email'        => 'cindia@email.com',
    ':permissoes'   => str_repeat('1',50),
    ':cod_validacao' => $cod_validacao,
    ':validado'      => $validado
];
$sql = 'INSERT INTO usuarios(usuario, senha, nome, email, permissoes, codigo_validacao, validado, created_at)
VALUES(:usuario, :senha, :nome, :email, :permissoes, :cod_validacao, :validado, current_timestamp())';

// insere usuarios na tabela
$gestor->EXE_NON_QUERY($sql , $param );

//========================== 
// usuario 4
$param = [
    ':usuario'      => 'raquel',
    ':senha'        => md5('raquel'),
    ':nome'         => 'Raquel Gomes',
    ':email'        => 'raquel@email.com',
    ':permissoes'   => '0'.str_repeat('1',49),
    ':cod_validacao' => $cod_validacao,
    ':validado'      => $validado
];
$sql = 'INSERT INTO usuarios(usuario, senha, nome, email, permissoes, codigo_validacao, validado, created_at)
VALUES(:usuario, :senha, :nome, :email, :permissoes, :cod_validacao, :validado, current_timestamp())';

// insere usuarios na tabela
$gestor->EXE_NON_QUERY($sql , $param );

//========================== 
// usuario 5
$param = [
    ':usuario'      => 'miguel',
    ':senha'        => md5('miguel'),
    ':nome'         => 'Miguel Gomes',
    ':email'        => 'miguel@email.com',
    ':permissoes'   => '0'.str_repeat('1',49),
    ':cod_validacao' => $cod_validacao,
    ':validado'      => $validado
];
$sql = 'INSERT INTO usuarios(usuario, senha, nome, email, permissoes, codigo_validacao, validado, created_at)
VALUES(:usuario, :senha, :nome, :email, :permissoes, :cod_validacao, :validado, current_timestamp())';

// insere usuarios na tabela
$gestor->EXE_NON_QUERY($sql , $param );

//=========================================================================

// reseta auto_increment para 1
$gestor->EXE_NON_QUERY('ALTER TABLE usuarios AUTO_INCREMENT = 1');

?>
<div class="alert alert-success text-center">Dados inseridos com sucesso!</div>