<?php 
// roteador backend

// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

// acondiciona varialvel de controle
$a = 'inicio';
if (isset($_GET['a'])) {
    $a = $_GET['a'];
}

// verifica se há usuario logado
if( !funcoes::VerificarLogin() ){
    // casos especiais
    $routes_especiais=[
        'recuperar-senha',
        'setup',
        'setup-criar-bd',
        'setup-inserir-usuarios',
        'setup-inserir-clientes',
        'sair'
    ];

    // bypass nas rotas normais
    if(!in_array($a, $routes_especiais)){
        $a = 'login';
    }
}


// seletor de paginas
switch($a){
    // ***************************************
    // AREA DE USUARIO  
    case 'login':                  
        include_once('users/login.php'); 
    break;
    case 'logout':                 
        include_once('users/logout.php'); 
    break;
    case 'recuperar-senha':        
        include_once('users/recuperar_senha.php'); 
    break;

    // ***************************************
    // Perfil
    case 'perfil':                 
        include_once('users/perfil/perfil_menu.php');
    break;
    case 'perfil-alterar-senha':   
        include_once('users/perfil/perfil_alterar_senha.php'); 
    break;
    case 'perfil-alterar-email':   
        include_once('users/perfil/perfil_alterar_email.php'); 
    break;

    // ***************************************
    // area de administração
    case 'usuarios-gerir':         
        include_once('users/admin/usuarios_gerir.php');
    break;
    case 'usuarios-add':           
        include_once('users/admin/usuarios_add.php');
    break;
    case 'usuarios-upd':           
        include_once('users/admin/usuarios_upd.php');
    break;
    case 'usuarios-del':           
        include_once('users/admin/usuarios_del.php');
    break;
    case 'permissoes-upd':         
        include_once('users/admin/permissoes_upd.php');
    break;

    // ***************************************
    // area de setup
    case 'setup':                  
        include_once('setup/setup.php'); 
    break;
    // criar BD
    case 'setup-criar-bd':         
        include_once('setup/setup.php');
    break;
    // inserir usuarios
    case 'setup-inserir-usuarios':  
        include_once('setup/setup.php'); 
    break;
    // inserir clientes na tabela
    case 'setup-inserir-clientes':
        include_once('setup/setup.php');
    break;

    case 'inicio':                 
        include_once('inicio.php'); 
    break;
    case 'about':                  
        include_once('about.php'); 
    break;
    case 'sair':                   
        header('Location: ../index.php'); 
    break;

}
