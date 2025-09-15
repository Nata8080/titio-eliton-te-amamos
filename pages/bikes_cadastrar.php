<?php

require_once __DIR__ . '/../data/connection.php';
require_once __DIR__ . '/../model/Bikes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo = $_POST['modelo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $disponivel = $_POST['disponivel'] ?? '';

    $bike = new Bikes($conn);
    $bike->modelo = $modelo;
    $bike->descricao = $descricao;
    $bike->preco = $preco;
    $bike->disponivel = $disponivel;
    $resultado = $bike->cadastrar();
}
?>
<div class="form-container">
    <h1>Cadastrar Nova Bike</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="number" step="0.01" id="preco" name="preco" required>
        </div>
        <div class="form-group">
            <label for="disponivel">Disponível:</label>
            <select id="disponivel" name="disponivel" required>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit">Cadastrar Bike</button>
        </div>
        <?php
        if (isset($resultado)) {
            if ($resultado) {
                echo '<p style="color: green; text-align: center;">Bike cadastrada com sucesso!</p>';
            } else {
                echo '<p style="color: red; text-align: center;">Erro ao cadastrar bike. Tente novamente.</p>';
            }
        }
        ?>
    </form>
</div>
