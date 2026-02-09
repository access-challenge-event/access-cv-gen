<?php

namespace Classes;

class DatabaseTable {
    public function __construct(
        public \PDO $pdo,
        public string $table,
        public $primaryKey
    ) {}

    // insert function
    public function insert($values) {
        $sql = 'INSERT INTO ' . $this->table . ' (';
        $keys = array_keys($values);
    
        $sql .= implode(', ', $keys) . ')';
        $sql .= ' VALUES (';
        $placeholders = implode(', :', $keys);
        $sql .= ':' . $placeholders . ')';
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($values);
    }
    

    // delete function
    public function delete($id) {
        $sql = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $sql->execute(['id' => $id]);
    }

    // save function
    public function save($record) {
        if ($record[$this->primaryKey] === '') {
            unset($record[$this->primaryKey]);
        }

        try {
            $this->insert($record);
        }
        catch (\Exception) {
            $this->update($record, $this->primaryKey);
        }
    }

    // update function
    public function update($record, $primaryKey) {
        $query = 'UPDATE ' . $this->table . ' SET ';
    
        $parameters = [];
        foreach ($record as $key => $value) {
            $parameters[] = $key . ' = :' .$key;
        }
    
        $query .= implode(', ', $parameters);
    
        $query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';
    
        $record['primaryKey'] = $record[$primaryKey];
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($record);
    }

    // query functions
    public function findAndOrder($attribute, $value, $orderBy, $order) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $attribute . '=:value ORDER BY ' . $orderBy . ' ' . $order);
        $stmt->execute(['value' => $value]);

        return $stmt->fetchAll();
    }

    public function findByOrder($attribute, $order) {
        $stmt = $this->pdo->prepare('SELECT *  FROM ' . $this->table . ' ORDER BY ' . $attribute . ' ' . $order);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    public function find($field, $value) {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . '=:value');
        $stmt->execute(['value' => $value]);
    
        return $stmt->fetchAll();
    }
}