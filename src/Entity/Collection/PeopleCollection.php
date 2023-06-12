<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\People;
use PDO;
class PeopleCollection
{
    /**
     * @param int $id
     * @return array
     */
    public function findByMovieId(int $movieId): array
    {
        $data = [];

        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
        SELECT p.*
        FROM people p
        JOIN cast c ON p.id = c.peopleId
        WHERE c.movieId = :movieId
        ORDER BY p.name
    SQL
        );

        $stmt->bindValue(':movieId', $movieId, PDO::PARAM_INT);
        $stmt->execute();

        $actors = $stmt->fetchAll(PDO::FETCH_CLASS, "Entity\People");

        foreach ($actors as $actor) {
            $data[] = $actor;
        }

        return $data;
    }
}
