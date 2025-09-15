<?php
require_once __DIR__ .'/../data/db_config.php';

$deleteDB = 'DROP DATABASE IF EXISTS '.DB_NAME.';';
$criarDB = 'CREATE DATABASE IF NOT EXISTS '.DB_NAME.';';
$usarDB = 'USE '.DB_NAME.';';

$crearTabela = "
    CREATE TABLE IF NOT EXISTS bikes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        modelo VARCHAR(255) NOT NULL,
        descricao TEXT,
        preco DECIMAL(10,2) NOT NULL,
        disponivel TINYINT(1) NOT NULL DEFAULT 1,
        createAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updateAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
";

$insertDados = "
    INSERT INTO bikes (modelo, descricao, preco, disponivel) VALUES
    ('Mountain Bike XTR', 'Bike de alta performance para trilhas', 3500.00, 1),
    ('Speedster 3000', 'Bike de estrada leve e rápida', 4500.50, 1),
    ('City Cruiser', 'Bike confortável para uso urbano', 1200.99, 0),
    ('Mountain Bike ZRX', 'Bike robusta para trilhas difíceis', 4000.00, 1),
    ('Hybrid Pro', 'Bike híbrida para cidade e trilha leve', 2800.00, 1);
";

try {
    // Conexão inicial sem banco de dados
    $pdo = new PDO(
        dsn: 'mysql:host='.DB_HOST, 
        username: DB_USER, 
        password: DB_PASS
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Deletar banco de dados se existir
    $pdo->exec(statement: $deleteDB);

    // Criar banco de dados
    $pdo->exec(statement: $criarDB);
    // Selecionar banco de dados
    $pdo->exec(statement: $usarDB);

    // Criar tabela
    $pdo->exec($crearTabela);

    // Inserir dados   
    $pdo->exec(statement: $insertDados);

    echo "Banco de dados, tabela 'bikes' e dados criados com sucesso!";
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
