<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Cover
{
    private string $jpeg;
    private int $id;

    /**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public static function findById(int $id): Cover
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM image
                WHERE id = :imageId
            SQL
        );

        $stmt->bindValue(':imageId', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Entity\Cover");
        $stmt->execute();

        return $stmt->fetch();
    }
}
