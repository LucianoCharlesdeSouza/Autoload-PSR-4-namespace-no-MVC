<?php

return [
    'mail_enviado_por' => app('app_name'),
    'mail_nomedestinatario' => app('app_name'),
    'mail_emaildestinatario' => 'souzacomprog@gmail.com',
    'mail_host' => 'smtp.gmail.com',
    'mail_smtpauth' => true,
    'mail_username' => 'souzacomprog@gmail.com',
    'mail_password' => 'suasenhaaqui',
    'mail_smtpsecure' => 'tls',
    'mail_port' => 587,
    'mail_charset' => 'UTF-8',
    'mail_smtpoptions' => [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ],
    'mail_smtpdebug' => 0
];
