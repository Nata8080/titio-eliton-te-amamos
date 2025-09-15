<title>Listar Bikes</title>
</style>
<div class="container">
    <h1>Listar Bikes</h1>
    <form action="" method="post" class="search-form">
        <input type="search" name="buscar" id="buscar" value="<?php echo htmlspecialchars($_POST['buscar'] ?? ''); ?>" placeholder="Buscar bike...">
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Modelo</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Disponível</th>
            <th style="width: 120px;">Ação</th>
        </tr>
        <?php
        require_once __DIR__ . '/../data/connection.php';
        require_once __DIR__ . '/../model/Bikes.php';

        $bike = new Bikes($conn);
        $lista = $bike->consultarTodas(htmlspecialchars($_POST['buscar'] ?? ''));

        foreach ($lista as $item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['id']) . "</td>";
            echo "<td>" . htmlspecialchars($item['modelo']) . "</td>";
            echo "<td>" . htmlspecialchars($item['descricao']) . "</td>";
            echo "<td>" . htmlspecialchars($item['preco']) . "</td>";
            echo "<td>" . (htmlspecialchars($item['disponivel']) ? 'Sim' : 'Não') . "</td>";
            echo "<td><a href='?page=editar&id=" . $item['id'] . "'>Editar</a> | <a href='?page=deletar&id=" . $item['id'] . "' onclick=\"return confirm('Tem certeza que deseja deletar esta bike?');\">Deletar</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
