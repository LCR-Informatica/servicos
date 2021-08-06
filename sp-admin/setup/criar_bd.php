<?php
// SETUP - criar BD
// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

// cria BD
$gestor = new cl_gestorBD();

$configs = funcoes::Config();

// apaga BD caso exista
$gestor->EXE_NON_QUERY('DROP DATABASE IF EXISTS '.$configs['BD_DATABASE']);

// cria BD
$gestor->EXE_NON_QUERY("CREATE DATABASE ".$configs['BD_DATABASE']." CHARACTER SET UTF8 COLLATE utf8_general_ci");

// usa BD
$gestor->EXE_NON_QUERY('USE '.$configs['BD_DATABASE']);

// cria as tabelas
// USUARIOS
$gestor->EXE_NON_QUERY(
    'CREATE TABLE usuarios( '.
    'id_usuario        INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '. 
    'usuario           NVARCHAR(50), '. 
    'senha             NVARCHAR(200), '.
    'nome              NVARCHAR(50), '. 
    'email             NVARCHAR(50), '.
    'permissoes        NVARCHAR(50), '.
    'codigo_validacao  NVARCHAR(200), '.
    'validado          TINYINT(1), '.
    'created_at        DATETIME, '. 
    'updated_at        DATETIME DEFAULT CURRENT_TIMESTAMP )'
);

// LOGS
$gestor->EXE_NON_QUERY(
    'CREATE TABLE logs( '.
    'id_log       BIGINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '. 
    'usuario      NVARCHAR(50), '. 
    'mensagem     NVARCHAR(200), '.
    'data_hora    DATETIME DEFAULT CURRENT_TIMESTAMP )'
);

// CLIENTES
$gestor->EXE_NON_QUERY(
    'CREATE TABLE  clientes( '.
    'id_cliente    INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
    'id_usuario    INT UNSIGNED, '.
    'nome          NVARCHAR(50), '. 
    'email         NVARCHAR(50), '.
    'telefone      NVARCHAR(15), '. 
    'endereco      NVARCHAR(150), '.
    'created_at    DATETIME, '. 
    'updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP )'
);

// SERVIÇOS
$gestor->EXE_NON_QUERY(
    'CREATE TABLE  servicos( '.
    'id_servico    INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT, '.
    'id_cliente    INT UNSIGNED, '.
    'orcamento     BOOLEAN, '.
    'descricao     NVARCHAR(200), '. 
    'quantidade    TINYINT(5), '.
    'valor         FLOAT, '. 
    'created_at    DATETIME, '. 
    'updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP )'
);
?>

<div class="alert alert-primary text-center">
    Base de dados e tabelas criados com sucesso!
</div>