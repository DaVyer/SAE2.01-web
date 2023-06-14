<?php

namespace Entity\Collection;

use Database\MyPdo;

class GenreCollection
{
    public function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM genre
            ORDER BY name, id
        SQL
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, "Entity\Genre");
    }
}