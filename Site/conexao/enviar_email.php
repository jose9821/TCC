<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/phpmailer/Exception.php';
require_once __DIR__ . '/phpmailer/PHPMailer.php';
require_once __DIR__ . '/phpmailer/SMTP.php';
require_once __DIR__ . '/config_email.php';

/**
 * Envia um e-mail de texto simples via SMTP.
 * Retorna true se enviou; false se falhou (o motivo vai para email_erro.log).
 */
function enviar_email($para, $nome_destino, $assunto, $corpo) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USUARIO;
        $mail->Password   = str_replace(' ', '', SMTP_SENHA);
        $mail->SMTPSecure = SMTP_SEGURANCA;
        $mail->Port       = SMTP_PORTA;
        $mail->CharSet    = 'UTF-8';
        $mail->Timeout    = 15;

        $mail->setFrom(SMTP_REMETENTE_EMAIL, SMTP_REMETENTE_NOME);
        $mail->addAddress($para, $nome_destino);
        $mail->Subject = $assunto;
        $mail->Body    = $corpo;
        $mail->isHTML(false);

        $mail->send();
        return true;
    } catch (Exception $e) {
        registrar_erro_email($mail->ErrorInfo);
        return false;
    } catch (\Exception $e) {
        registrar_erro_email($e->getMessage());
        return false;
    }
}

function registrar_erro_email($texto) {
    $linha = date('Y-m-d H:i:s') . ' - ' . $texto . "\n";
    $ok = @file_put_contents(__DIR__ . '/email_erro.log', $linha, FILE_APPEND);
    if ($ok === false) {
        error_log('RG Eats e-mail: ' . $texto);
    }
}
