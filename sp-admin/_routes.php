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
// if( !funcoes::VerificarLogin() ){
//     // casos especiais
//     $routes_especiais=[
//         'setup',
//         'setup-criar-bd',
//         'setup-inserir-usuarios',
//         'setup-inserir-clientes',
//         'sair'
//     ];

//     // bypass nas rotas normais
//     if(!in_array($a, $routes_especiais)){
//         $a = 'inicio';
//     }
// }

// seletor de paginas
switch($a){

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
    case 'sair':                   
        header('Location: ../index.php'); 
    break;

}
