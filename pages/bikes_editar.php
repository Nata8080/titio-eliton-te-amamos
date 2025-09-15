<?php
require_once __DIR__ . '/../data/connection.php';
require_once __DIR__ . '/../model/Bikes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $modelo = $_POST['modelo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $disponivel = isset($_POST['disponivel']) ? 1 : 0;

    $bike = new Bikes($conn);
    $bike->id = $id;
    $bike->modelo = $modelo;
    $bike->descricao = trim($descricao);
    $bike->preco = $preco;
    $bike->disponivel = $disponivel;
    $resultado = $bike->editar();
}

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
?>

<div class="form-container">
    <h1>Editar Bike</h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($bike_atual['id']); ?>">

        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($bike_atual['modelo']); ?>" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($bike_atual['descricao']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="number" step="0.01" id="preco" name="preco" value="<?php echo htmlspecialchars($bike_atual['preco']); ?>" required>
        </div>

        <div class="form-group">
            <label for="disponivel">
                <input type="checkbox" id="disponivel" name="disponivel" <?php echo $bike_atual['disponivel'] ? 'checked' : ''; ?>>
                Disponível
            </label>
        </div>

        <div class="form-group">
            <button type="submit">Editar Bike</button>
        </div>

        <?php
        if (isset($resultado)) {
            if ($resultado) {
                echo '<p style="color: green; text-align: center;">Bike alterada com sucesso!</p>';
            } else {
                echo '<p style="color: red; text-align: center;">Erro ao alterar bike. Tente novamente.</p>';
            }
        }
        ?>
    </form>
</div>
