<?php
// roteador frontend

// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

// acondiciona varialvel de controle
$a = 'home';
if (isset($_GET['a'])) {
    $a = $_GET['a'];
}

// seletor de paginas
switch($a){
    // pagina inicial  
    case 'home':                    
        include_once('./webgeral/inicio.php');   
    break;
    
    case 'inicio':                    
        include_once('./webgeral/inicio.php');   
    break;

    // login
    case 'login':                   
        include_once('./webgeral/usuarios/login.php');     
    break;

    // logout
    case 'logout':                   
        include_once('./webgeral/usuarios/logout.php');
    break;
    
    // signup
    case 'cadastro':  // precisa de aprovação manual do admin
        include_once('./webgeral/usuarios/usuario_cadastro.php');  
    break;

    // perfil
    case 'perfil':                   
        include_once('./webgeral/usuarios/usuario_perfil.php'); 
    break;
    
    // validacao
    case 'validar':                
        include_once('./webgeral/usuarios/usuario_validar.php');  
    break;

    // recuperação de senhas
    case 'recuperar-senha':        
        include_once('./sp-admin/users/recuperar_senha.php'); 
    break;

    // ***************************************
    // clientes
    case 'clientes-list':                 
        include_once('./webgeral/clientes/clientes_list.php'); 
    break;
    case 'clientes-add':                 
        include_once('./webgeral/clientes/clientes_add.php'); 
    break;
    case 'clientes-del':                 
        include_once('./webgeral/clientes/clientes_del.php'); 
    break;
    case 'clientes-upd':                 
        include_once('./webgeral/clientes/clientes_upd.php'); 
    break;

    // ***************************************
    // servicos
    case 'servicos-list':                 
        include_once('./webgeral/servicos/servicos_list.php'); 
    break;
    case 'servicos-add':                 
        include_once('./webgeral/servicos/servicos_add.php'); 
    break;
    case 'servicos-del':                 
        include_once('./webgeral/servicos/servicos_del.php'); 
    break;
    case 'servicos-upd':                 
        include_once('./webgeral/servicos/servicos_upd.php'); 
    break;

    // ***************************************
    // area de administração
    case 'usuarios-gerir':         
        include_once('./webgeral/admin/usuarios_gerir.php');
    break;
    case 'usuarios-add':           
        include_once('./webgeral/admin/usuarios_add.php');
    break;
    case 'usuarios-upd':           
        include_once('./webgeral/admin/usuarios_upd.php');
    break;
    case 'usuarios-del':           
        include_once('./webgeral/admin/usuarios_del.php');
    break;
    case 'permissoes-upd':         
        include_once('./webgeral/admin/permissoes_upd.php');
    break;
}
