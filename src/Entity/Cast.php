<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Cast
{
    private int $movieId;
    private int $peopleId;
    private string $role;
    private int $orderIndex;
    private int $id;

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /**
     * @return int
     */
    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public static function findByMovieAndPeopleId(int $movieId, int $peopleId): ?Cast
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM cast
            WHERE movieId = :movieId AND peopleId = :peopleId
        SQL
        );

        $stmt->bindValue(':movieId', $movieId, PDO::PARAM_INT);
        $stmt->bindValue(':peopleId', $peopleId, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Entity\Cast");
        $stmt->execute();

        return $stmt->fetch();
    }
    

}