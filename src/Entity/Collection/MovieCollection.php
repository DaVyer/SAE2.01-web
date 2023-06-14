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

        return $stmt->fetchAll(PDO::FETCH_CLASS, "Entity\Movie");
    }

    public function findByPeopleId(int $peopleId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
        SELECT m.*
        FROM movie m
        INNER JOIN cast c ON m.id = c.movieId
        WHERE c.peopleId = :peopleId
        SQL
        );

        $stmt->bindValue(':peopleId', $peopleId, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Entity\Movie");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findByGenreId(?string $genreId): array
    {
        if ($genreId === null || $genreId === "all") {
            return $this->findAll();
        }

        $query = "
        SELECT m.*
        FROM movie m
        INNER JOIN movie_genre mg ON m.id = mg.movieId
        WHERE mg.genreId = :genreId
        ORDER BY m.title
    ";

        $stmt = myPdo::getInstance()->prepare($query);
        $stmt->bindValue(':genreId', $genreId);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "Entity\Movie");
        $stmt->execute();

        return $stmt->fetchAll();
    }
}