<?php
class Bikes
{
    public $id;
    public $modelo;
    public $descricao;
    public $preco;
    public $disponivel;

    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function cadastrar(): bool
    {
        try {
            $sql = "INSERT INTO bikes (`modelo`, `descricao`, `preco`, `disponivel`) VALUES (?, ?, ?, ?)";
            $dados = [
                $this->modelo,
                $this->descricao,
                $this->preco,
                $this->disponivel
            ];
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($dados);
            return ($stmt->rowCount() > 0);
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar bike: " . $e->getMessage());
            throw new Exception("Erro ao cadastrar bike: " . $e->getMessage());
        }
    }

    public function consultarTodas($search = '')
    {
        try {
            if ($search) {
                $sql = "SELECT * FROM bikes WHERE modelo LIKE ? OR descricao LIKE ?";
                $search = trim($search);
                $search = "%{$search}%";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$search, $search]);
            } else {
                $sql = "SELECT * FROM bikes";
                $stmt = $this->conn->query($sql);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao consultar bikes: " . $e->getMessage());
            throw new Exception("Erro ao consultar bikes: " . $e->getMessage());
        }
    }

    public function consultarPorId($id)
    {
        try {
            $sql = "SELECT * FROM bikes WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao consultar bike por ID: " . $e->getMessage());
            throw new Exception("Erro ao consultar bike por ID: " . $e->getMessage());
        }
    }

    public function editar()
    {
        try {
            $sql = "UPDATE bikes SET modelo = ?, descricao = ?, preco = ?, disponivel = ? WHERE id = ?";
            $dados = [
                $this->modelo,
                $this->descricao,
                $this->preco,
                $this->disponivel,
                $this->id
            ];
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($dados);
            return ($stmt->rowCount() > 0);
        } catch (PDOException $e) {
            error_log("Erro ao alterar bike: " . $e->getMessage());
            throw new Exception("Erro ao alterar bike: " . $e->getMessage());
        }
    }

    public function deletar($id): bool
    {
        try {
            $sql = "DELETE FROM bikes WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return ($stmt->rowCount() > 0);
        } catch (PDOException $e) {
            error_log("Erro ao deletar bike: " . $e->getMessage());
            throw new Exception("Erro ao deletar bike: " . $e->getMessage());
        }
    }
}
