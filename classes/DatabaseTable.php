<?php
class DatabaseTable
{
    /**
     * Class constructor.
     */
    public function __construct(private PDO $pdo, private string $table, private string $primaryKey)
    {
    }

    public function total()
    {
        $stmt = $this->pdo->prepare(query: 'SELECT COUNT(*) FROM `' . $this->table . '`');
        $stmt->execute();
        $row = $stmt->fetch();
        return $row[0];
    }

    public function find($field, $value)
    {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` = :value';

        $values = [
            'value' => $value,
        ];

        $stmt = $this->pdo->prepare(query: $query);
        $stmt->execute(params: $values);

        return $stmt->fetchAll();
    }

    private function insert($values)
    {
        $query = 'INSERT INTO `' . $this->table . '` (';

        foreach ($values as $key => $value) {
            $query .= '`' . $key . '`,';
        }

        $query = rtrim(string: $query, characters: ',');
        $query .= ') VALUES (';

        foreach ($values as $key => $value) {
            $query .= ':' . $key . ',';
        }

        $query = rtrim(string: $query, characters: ',');

        $query .= ')';

        $stmt = $this->pdo->prepare($query);

        $stmt->execute(params: $values);
    }

    private function update($values)
    {
        $query = 'UPDATE `' . $this->table . '` SET ';

        foreach ($values as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ',';
        }

        $query = rtrim(string: $query, characters: ',');

        $query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';

        // Set the :primaryKey variable
        $values['primaryKey'] = $values['id'];

        $stmt = $this->pdo->prepare(query: $query);
        $stmt->execute(params: $values);
    }

    public function delete($field, $value)
    {
        $values = [':value' => $value];

        $stmt = $this->pdo->prepare(query: 'DELETE FROM `' . $this->table . '` WHERE `' . $field . '` = :value');

        $stmt->execute(params: $values);
    }

    function findAll()
    {
        $stmt = $this->pdo->prepare(query: 'SELECT * FROM `' . $this->table . '`');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function save($record)
    {
        try {
            if (empty($record[$this->primaryKey])) {
                unset($record[$this->primaryKey]);
            }

            $this->insert(values: $record);

        } catch (PDOException $e) {
            $this->update(values: $record);
        }
    }
}