<?php
// validar usuario

// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$erro    = false;
$sucesso = false;
$msg     = '';

// verifica se há o v na url

if(!isset($_GET['v'])){
    $erro = true;
    $msg  = "Código de ativação não encontrado!";
}

if(!$erro){
    $codigo = $_GET['v'];
    $gestor = new cl_gestorBD();
    $param  = [':codigo' => $codigo];
    $sql    = "SELECT * FROM usuarios WHERE codigo_validacao = :codigo";
    $temp   = $gestor->EXE_QUERY($sql, $param);
    if(count($temp)==0){
        $erro = true;
        $msg  = "Não foi encontrado usuário com o código indicado!";
    }
    if(!$erro){
        if($temp[0]['validado']==1){
            $erro = true;
            $msg  = "Conta já validada!";
        }
    }

    if(!$erro){
        $param  = [':id' => $temp[0]['id_usuario'], ':validado' => 1];
        $sql    = "UPDATE usuarios SET validado = :validado WHERE id_usuario = :id";
        $temp   = $gestor->EXE_NON_QUERY($sql, $param);
        $sucesso= true;
        $msg    = 'Conta ativada com sucesso!';
    }
}


?>
<div class="container-fluid index-container">
    <?php if ($erro) : ?>
        <div class='alert alert-danger text-center'><?php echo $msg ?></div>
    <?php endif; ?>

    <?php if ($sucesso) : ?>
        <div class='alert alert-success text-center'><?php echo $msg ?></div>
    <?php endif; ?>
    
</div>
