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
            FROM album
            WHERE artistId = :artistId
            ORDER BY year DESC, name
        SQL
        );

        $stmt->bindValue(':artistId', $actorId);
        $stmt->execute();

        $albums = $stmt->fetchAll(PDO::FETCH_CLASS, "Entity\People");

        foreach ($albums as $album) {
            $data[] = $album;
        }

        return $data;
    }
}