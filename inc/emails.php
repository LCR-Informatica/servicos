<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    class cl_Email{
        
        // =========================================================
        public static function EnviarEmail($dados){
            require '../phpmailer/src/Exception.php';
            require '../phpmailer/src/PHPMailer.php';
            require '../phpmailer/src/SMTP.php';
            // dados[0] = endereço de email do destinatário
            // dados[1] = assunto
            // dados[2] = mensagem

            //configurações
            $configs = funcoes::Config();
		
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPOptions = array('ssl' => 
                    array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    )
                );
            $mail->isHTML();
            $mail->SMTPDebug = $configs['MAIL_DEBUG'];
            $mail->Host = $configs['MAIL_HOST'];
            $mail->Port = $configs['MAIL_PORT'];
            $mail->SMTPAuth = true;
            $mail->Username = $configs['MAIL_USERNAME'];                                                
            $mail->Password = $configs['MAIL_PASSWORD'];
            $mail->setFrom ($configs['MAIL_FROM'], 'SERVICOS');
            $mail->addAddress($dados[0], $dados[0]);
            $mail->CharSet = "UTF-8";
            //assunto
            $mail->Subject = $dados[1];
            //mensagem
            $mail->Body = $dados[2];               
            //envio da mensagem
            $enviada = false;
            if($mail->send()){ $enviada = true; }
            return $enviada;
        }

    }
?>