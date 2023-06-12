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
    public static function findByActorId(int $actorId): arrayI
    {
        $data = [];

        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM people
            WHERE id = :actorId
            ORDER BY year DESC, name
        SQL
        );

        $stmt->bindValue(':actorId', $actorId);
        $stmt->execute();

        $actors = $stmt->fetchAll(PDO::FETCH_CLASS, "Entity\People");

        foreach ($actors as $actor) {
            $data[] = $actor;
        }

        return $data;
    }
}