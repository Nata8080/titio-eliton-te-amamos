<?php
require_once __DIR__ . '/../data/connection.php';
require_once __DIR__ . '/../model/Bikes.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<p style="color: red; text-align: center;">ID de bike inválido.</p>';
    echo '<p style="text-align: center;"><a href="/">Voltar para a lista de bikes</a></p>';
    exit;
}

$id = $_GET['id'];

$bike = new Bikes($conn);
$bike_atual = $bike->consultarPorId($id);

if (!$bike_atual) {
    echo '<p style="color: red; text-align: center;">Bike não encontrada.</p>';
    echo '<p style="text-align: center;"><a href="/">Voltar para a lista de bikes</a></p>';
    exit;
}

$resultado = $bike->deletar($id);

if ($resultado) {
    header('Location: /?deleted=true');
} else {
    echo '<p style="color: red; text-align: center;">Erro ao deletar bike. Tente novamente.</p>';
    echo '<p style="text-align: center;"><a href="/">Voltar para a lista de bikes</a></p>';
}
