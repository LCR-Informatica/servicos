<?php
// roteador

// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

// limpar filtros de pesquisas
if(isset($_SESSION['texto-busca'])){
    unset($_SESSION['texto-busca']);
}

?>

<section class="container-fluid pd-20">
    <!-- botão para acessar setup -->
    <div class="text-center">
       <h2 class="m-3 p-3">Página de Serviços</h2>
       <hr>
       <a class="btn btn-primary btn-size-150" href="?a=setup">Setup</a>
       <a class="btn btn-secondary btn-size-150 ml-5" href="?a=sair">Sair</a>
    </div>

</section>