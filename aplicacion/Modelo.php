<?php

namespace aplicacion;

require_once 'Database.php';

use PDO;
use Exception;


abstract class Modelo
{
    private PDO $pdo;
    protected string $tabla;
    protected array $original = [];
    protected array $attributes = [];
    protected string $primaryKey = 'id';
    protected array $relations = [];

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->attributes)) {
            $this->attributes[$name] = $value;
        }
    }

    public function all(array $with = []): array
    {
        try {
            $sql = $this->buildSelectQuery($with);
            $prepare = $this->pdo->prepare($sql);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw new Exception("Error fetching all records: " . $e->getMessage());
        }
    }

    protected function buildSelectQuery(array $with = []): string
    {
        $select = "SELECT {$this->tabla}.*";
        $join = "";

        foreach ($with as $relation) {

            if (isset($this->relations[$relation])) {

                $related = $this->relations[$relation];
                $relatedTable = $related['table'];
                $foreignKey = $related['foreign_key'];
                $primaryKey = $related['primary_key'] ?? $this->primaryKey;

                $select .= ", {$relatedTable}.*";
                $join .= " JOIN {$relatedTable} ON {$this->tabla}.{$foreignKey} = {$relatedTable}.{$primaryKey}";
            }
        }

        return "$select FROM {$this->tabla} $join";
    }

    public function find(int|string $id): ?object
    {
        try {
            $sql = "SELECT * FROM {$this->tabla} WHERE {$this->primaryKey} = :id";
            $prepare = $this->pdo->prepare($sql);
            $prepare->bindParam(':id', $id);
            $prepare->execute();
            $result = $prepare->fetch(PDO::FETCH_OBJ);
            return $result ?: null;
        } catch (Exception $e) {
            throw new Exception("Error fetching record with ID $id: " . $e->getMessage());
        }
    }

    public function create(): bool
    {
        try {
            $columns = array_keys($this->attributes);
            $placeholders = implode(",", array_fill(0, count($columns), "?"));
            $sql = "INSERT INTO {$this->tabla} (" . implode(",", $columns) . ") VALUES ($placeholders)";
            $prepare = $this->pdo->prepare($sql);
            $this->bindValues($prepare, array_values($this->attributes));
            $prepare->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error creating record: " . $e->getMessage());
        }
    }

    public function delete(int|string $id): bool
    {
        try {
            $sql = "DELETE FROM {$this->tabla} WHERE {$this->primaryKey} = :id";
            $prepare = $this->pdo->prepare($sql);
            $prepare->bindParam(':id', $id);
            $prepare->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error deleting record with ID $id: " . $e->getMessage());
        }
    }

    public function update(int $id): bool
    {
        try {
            $columns = array_keys($this->attributes);
            $setClause = implode(" = ?, ", $columns) . " = ?";
            $sql = "UPDATE {$this->tabla} SET $setClause WHERE id = ?";
            $prepare = $this->pdo->prepare($sql);
            $this->bindValues($prepare, array_merge(array_values($this->attributes), [$id]));
            $prepare->execute();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error updating record with ID $id: " . $e->getMessage());
        }
    }

    public function where(string $column, $value): array
    {
        try {
            $sql = "SELECT * FROM {$this->tabla} WHERE $column = ?";
            $prepare = $this->pdo->prepare($sql);
            $prepare->bindParam(1, $value);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw new Exception("Error fetching record with $column = $value: " . $e->getMessage());
        }
    }

    private function bindValues($prepare, array $values): void
    {
        foreach ($values as $i => $value) {
            $prepare->bindValue($i + 1, $value);
        }
    }
}
