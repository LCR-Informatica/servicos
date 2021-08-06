<?php
// Funções utilitarias
// verificar sessão

if (!isset($_SESSION['a'])) {
    exit();
}

class funcoes
{

    public static function VerificarLogin()
    {
        // verifica se há usuario na sessão ativa
        $resultado = false;
        if (isset($_SESSION['id_usuario'])) {
            $resultado = true;
        }
        return $resultado;
    }

    public static function IniciaSessao($dados)
    {
        $_SESSION['id_usuario'] = $dados[0]['id_usuario'];
        $_SESSION['nome_usuario'] = $dados[0]['nome'];
        $_SESSION['email_usuario'] = $dados[0]['email'];
        $_SESSION['permissoes'] = $dados[0]['permissoes'];
    }

    public static function DestroiSessao()
    {
        unset($_SESSION['id_usuario']);
        unset($_SESSION['nome_usuario']);
        unset($_SESSION['email_usuario']);
        unset($_SESSION['permissoes']);
    }

    public static function GeradorDeSenhaAleatorio($numChars)
    {
        // cria codigos para gerador de senhas
        $codigo = '';
        $caracteres = 'abcdefghijklmnopqrstwxyz0123456789ABCDEFGHIJKLMNOPQRSTWXYZ!?#$%&*()';
        for ($i = 0; $i < $numChars; $i++) {
            $codigo .= substr($caracteres, rand(0, strlen($caracteres)), 1);
        }

        return $codigo;
    }

    public static function GeradorDeCodigosAleatorio($numChars)
    {
        // cria codigos para gerador de senhas
        $codigo = '';
        $caracteres = 'abcdefghijklmnopqrstwxyz0123456789ABCDEFGHIJKLMNOPQRSTWXYZ';
        for ($i = 0; $i < $numChars; $i++) {
            $codigo .= substr($caracteres, rand(0, strlen($caracteres)), 1);
        }

        return $codigo;
    }

    public static function CriaLOG($usuario, $mensagem)
    {
        $gestor = new cl_gestorBD();
        $param = [ ':user' => $usuario, ':msg' => $mensagem ];
        $sql = "INSERT INTO logs(usuario, mensagem) VALUES(:user, :msg)";
        $gestor->EXE_NON_QUERY($sql, $param);
    }

    public static function Permissao($index)
    {
        // verifica se usuario da sessao tem permissao de acesso ativa('1')
        $ret = false;
        if (substr($_SESSION['permissoes'], $index, 1) == '1') {
            $ret = true;
        }
        return $ret;
    }

    public static function Paginacao($source, $pag_atual, $itens_pag, $tot_itens)
    {
        // gerencia o funcionamento da paginação
        $max_pag = ceil($tot_itens/$itens_pag);
        echo '<div class="row">';
            echo '<div class="col-sm-6 mb-1">';
                echo 'Página: '.$pag_atual.' ';
                if($pag_atual == 1){ // pag anterior
                    echo '<a class="p-0 btn btn-secondary"><<</a>';
                } else {
                    echo '<a class="p-0 btn btn-primary" href="'.$source.'&p='.($pag_atual-1).'"><<</a>';
                }
                echo ' | ';
                if($pag_atual==$max_pag){ // pag seguinte
                    echo '<a class="p-0 btn btn-secondary">>></a>';
                } else {
                    echo '<a class="p-0 btn btn-primary" href="'.$source.'&p='.($pag_atual+1).'">>></a>';
                }
                echo ' de '.$max_pag;
            echo '</div>';
            echo '<div class="col-sm-6 mb-1 text-right">';
                echo 'Total de '.$tot_itens.' itens';
            echo '</div>';
        echo '</div>';
    }

    public static function Datas()
    {
        $datahora = new DateTime();
        return $datahora->format('Y-m-d H-i-s');
    }

    public static function Config()
    {
        $ret = array(
            // variáveis da bd
            'BD_HOST'         => 'localhost',
            'BD_DATABASE'     => 'servicos',
            'BD_CHARSET'      => 'utf8',
            'BD_USERNAME'     => 'root',
            'BD_PASSWORD'     => 'root',

            //variáveis do email
            'MAIL_HOST'       => 'smtp.gmail.com',
            'MAIL_PORT'       => 587,
            'MAIL_USERNAME'   => 'cameraeuterpe@gmail.com',
            'MAIL_PASSWORD'   => 'Pu1ylc&*(', // em 09/07/2020
            'MAIL_FROM'       => 'cameraeuterpe@gmail.com',
            'MAIL_DEBUG'      => 0,

            //endereço base
            'BASE_URL'        => 'http://localhost/www/servicos/'
        );

        return $ret;
    }
}
