<?php
// ===== CONFIGURAÇÃO DO ENVIO DE E-MAIL (SMTP via GMAIL) =====
// Requisitos: verificação em 2 etapas ativada na conta Google e uma "Senha de app" gerada.
// Use a senha de app (16 letras), NÃO a senha normal do Gmail. Pode colar com ou sem espaços.

define('SMTP_HOST',      'smtp.gmail.com');
define('SMTP_PORTA',     587);
define('SMTP_SEGURANCA', 'tls');

define('SMTP_USUARIO',   'escolafodinhas@gmail.com');       // <- seu Gmail completo
define('SMTP_SENHA',     'pdwo lvwj bnjs hdrl');     // <- senha de app

define('SMTP_REMETENTE_EMAIL', SMTP_USUARIO);          // no Gmail deve ser o mesmo e-mail
define('SMTP_REMETENTE_NOME',  'RG Eats');
