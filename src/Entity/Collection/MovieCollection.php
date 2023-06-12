<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use PDO;
class MovieCollection
{
    public function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM movie
            ORDER BY title, id
        SQL
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, "Entity\Artist");
    }
}