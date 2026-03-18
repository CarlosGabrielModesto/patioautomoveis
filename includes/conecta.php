<?php
/**
 * Arquivo de Conexão com o Banco de Dados
 * DriveEasy - Pátio de Automóveis
 * 
 * Realiza a conexão segura com o MySQL usando mysqli.
 * Inclua este arquivo em todas as páginas que precisam de acesso ao banco.
 */

// Configurações de conexão
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'patioautomoveis_db');
define('DB_CHARSET', 'utf8');

// Tenta conectar ao banco de dados
$conectaBD = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se a conexão foi estabelecida com sucesso
if (!$conectaBD) {
    // Em produção, nunca exiba detalhes do erro para o usuário final
    error_log("Falha na conexão com o BD: " . mysqli_connect_error());
    die(json_encode([
        'erro' => true,
        'mensagem' => 'Falha ao conectar com o banco de dados. Tente novamente mais tarde.'
    ]));
}

// Define o charset da conexão para evitar problemas com acentos
mysqli_set_charset($conectaBD, DB_CHARSET);
