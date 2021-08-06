<?php
// SETUP - inserir usuarios
// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

$homens = [
    'Luiz', 'Alberto', 'Miguel', 'Thiago', 'Samuel', 'Sergio', 'Gabriel', 'Joao',
    'Antonio', 'Fabio', 'Rogerio', 'Marcos', 'Jose', 'Henrique', 'Felipe', 'Fernando', 'Lourenzo', 'Pedro', 'Davi', 'Elias', 'Joaquim', 'Arnaldo', 'Armando', 'Alessandro', 'Jair', 'Julio'
];
$mulheres = [
    'Cindia', 'Raquel', 'Maria', 'Lourdes', 'Leora', 'Cristina', 'Ana', 'Nilce',
    'Claudia', 'Andreia', 'Divamar', 'Renata', 'Clara', 'Teresa', 'Beatriz', 'Gleice', 'Jaqueline', 'Marcia', 'Alessandra', 'Aline', 'Joana', 'Michele', 'Rita', 'Alice', 'Luiza', 'Juliana'
];
$sobrenome = [
    'Gomes', 'Freitas', 'Pinage', 'Silva', 'Souza', 'Fernandes', 'Figueira',
    'Pereira', 'Vargas', 'Barros', 'Dias', 'Teixiera', 'Pinto', 'Bolsonaro', 'Borges', 'Santos', 'Silveira', 'Meneguici', 'Rodrigues', 'Junior', 'Andrade', 'Antunes', 
    'Vilas Boas', 'Messias', 'Vasconcelos'
];

// aciona classe gestora de dados
$gestor = new cl_gestorBD();

$num_clientes = 25;

// agaga os dados da tabela clientes
$gestor->EXE_NON_QUERY('DELETE FROM clientes');

// reseta auto_increment para 1
//$gestor->EXE_NON_QUERY('ALTER TABLE clientes AUTO_INCREMENT = 1');
$gestor->RESET_AUTO_INCREMENT('clientes');

for ($i = 0; $i < $num_clientes; $i++) {
    // nomes
    $genero = rand(1, 2);
    $nome = '';
    if ($genero == 1) {
        $nome = $homens[rand(0, count($homens) - 1)] . ' ' .
            $sobrenome[rand(0, count($sobrenome) - 1)] . ' ' .
            $sobrenome[rand(1, count($sobrenome) - 1)];
    } else {
        $nome = $mulheres[rand(0, count($mulheres) - 1)] . ' ' .
            $sobrenome[rand(0, count($sobrenome) - 1)] . ' ' .
            $sobrenome[rand(1, count($sobrenome) - 1)];
    }

    // emails, telefone, endereco
    $email = str_replace(' ', '', strtolower(substr($nome, 0, 12))) . rand(1990, 2020) . '@email.com';
    $fone = '(22)' . rand(99111, 99999) . '-' . rand(0000, 9999);
    $ender = 'Rua: ' . $nome . ', ' . rand(1, 2000);

    //========================== 
    $id_user = round(rand(2, 5));

    $param  = [
        ':id_user' => $id_user,
        ':nome'    => $nome,
        ':email'   => $email,
        ':fone'    => $fone,
        ':ender'   => $ender
    ];

    $sql = "INSERT INTO clientes(id_usuario, nome, email, telefone, endereco, created_at) 
    VALUES(:id_user, :nome, :email, :fone, :ender, current_timestamp())";
      
    // insere usuarios na tabela
    $temp = $gestor->EXE_NON_QUERY($sql, $param);

}
?>

<div class="alert alert-warning text-center">
    <?php echo $num_clientes ?> Clientes inseridos com sucesso!
</div>