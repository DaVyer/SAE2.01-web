<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Movie
{

    private ?int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private ?string $overview;
    private string $releaseDate;
    private int $runtime;
    private ?string $tagline;
    private string $title;
    private ?int $id = null;


    /**
     * @return int
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @return string
     */
    public function getOverview(): ?string
    {
        return $this->overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @return string
     */
    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $posterId
     */
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public static function findById(int $id): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM movie
                WHERE id = :movieId
            SQL
        );

        $stmt->bindValue(':movieId', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Entity\Movie");
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getCover(): ?Cover
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
        SELECT *
        FROM image
        WHERE id = :imageId
    SQL
        );

        $stmt->bindValue(':imageId', $this->posterId, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Entity\Cover");
        $stmt->execute();

        $cover = $stmt->fetch();

        if ($cover !== false) {
            return $cover;
        } else {
            return null;
        }
    }

    public function delete(): Movie
    {
        $stmt = myPdo::getInstance()->prepare(
            <<<SQL
            DELETE FROM movie
            WHERE id = :movieId
SQL
        );
        $stmt->bindValue(':movieId', $this->getId());
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "Entity\Movie");
        $stmt->execute();

        $this->setId(null);
        return clone $this;
    }

    public function update(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            UPDATE movie
            SET title = :movieTitle, 
                originalLanguage = :movieOL, 
                originalTitle = :movieOT, 
                overview = :movieOverview, 
                releaseDate = :movieRD, 
                runtime = :movieRunTime,
                tagline = :movieTagline,
                posterId = :moviePosterId
            WHERE id = :movieId
SQL
        );
        $stmt->bindValue(':movieTitle', $this->getTitle());
        $stmt->bindValue(':movieOL', $this->getOriginalLanguage());
        $stmt->bindValue(':movieOT', $this->getOriginalTitle());
        $stmt->bindValue(':movieOverview', $this->getOverview());
        $stmt->bindValue(':movieRD', $this->getReleaseDate());
        $stmt->bindValue(':movieRunTime', $this->getRuntime());
        $stmt->bindValue(':movieTagline', $this->getTagline());
        $stmt->bindValue(':moviePosterId', $this->getPosterId());
        $stmt->bindValue(':movieId', $this->getId());

        $stmt->setFetchMode(PDO::FETCH_CLASS, "Entity\Movie");
        $stmt->execute();

        return clone $this;
    }

    public static function create(
        string $title,
        string $originalLanguage,
        string $originalTitle,
        string $overview,
        string $releaseDate,
        int $runtime,
        string $tagline,
        int $posterId = null,
        int $id = null
    ): Movie {
        $newMovie = new Movie();
        $newMovie->setTitle($title);
        $newMovie->setOriginalLanguage($originalLanguage);
        $newMovie->setOriginalTitle($originalTitle);
        $newMovie->setOverview($overview);
        $newMovie->setReleaseDate($releaseDate);
        $newMovie->setRuntime($runtime);
        $newMovie->setTagline($tagline);
        $newMovie->setPosterId($posterId);
        $newMovie->setId($id);

        return $newMovie;
    }

    public function insert()
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
                INSERT INTO movie (title, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, posterId)
                VALUES (:movieTitle, :movieOL, :movieOT, :movieOverview, :movieRD, :movieRunTime, :movieTagline, :moviePosterId)
            SQL
        );

        $this->setId((int) MyPdo::getInstance()->lastInsertId());

        $stmt->bindValue(':movieTitle', $this->title);
        $stmt->bindValue(':movieOL', $this->originalLanguage);
        $stmt->bindValue(':movieOT', $this->originalTitle);
        $stmt->bindValue(':movieOverview', $this->overview);
        $stmt->bindValue(':movieRD', $this->releaseDate);
        $stmt->bindValue(':movieRunTime', $this->runtime);
        $stmt->bindValue(':movieTagline', $this->tagline);
        $stmt->bindValue(':moviePosterId', $this->posterId);

        $stmt->execute();


        return clone $this;
    }

    public function save()
    {
        if (isset($this->id)) {
            $movie = $this->update();
        } else {
            $movie = $this->insert();
        }

        return $movie;
    }

}
