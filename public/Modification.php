<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Movie;
use Html\AppWebPage;

$webPage = new AppWebPage();

$webPage->setTitle("Création ou modification d'un film");

$webPage->appendCssUrl("css/style.css");

// Rajout d'un en-tête expliquant comment fonctionne le form

if (isset($_POST['title'])) {
    $title = $_POST['title'];

    $stmt = MyPdo::getInstance()->prepare(<<<'SQL'
                                SELECT * FROM movie WHERE title = :title
                                SQL);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_CLASS, "Entity\Movie");
    $stmt->execute();
    $movie = $stmt->fetch();


    $title = $_POST['title'];
    $originalLanguage = $_POST['originalLanguage'];
    $originalTitle = $_POST['originalTitle'];
    $releaseDate = $_POST['releaseDate'];
    $runtime = intval($_POST['runtime']);

    if ($movie !== false) {
        if (isset($_POST['posterId'])) {
            if (!empty($_POST['posterId'])) {
                $posterId = (int)$_POST['posterId'];
            } else {
                $posterId = $movie->getPosterId();
            }
        } else {
            $posterId = $movie->getPosterId();
        }
    } else {
        $posterId = null;
    }

    if (isset($_POST['overview'])) {
        $overview = $_POST['overview'];
    } else {
        $overview = $movie->getOverview();
    }

    if (isset($_POST['tagline'])) {
        $tagline = $_POST['tagline'];
    } else {
        $tagline = $movie->getTagline();
    }

    if ($movie) {
        $movie->setTitle($title);
        $movie->setOriginalLanguage($originalLanguage);
        $movie->setOriginalTitle($originalTitle);
        $movie->setReleaseDate($releaseDate);
        $movie->setRuntime($runtime);
        $movie->setOverview($overview);
        $movie->setTagline($tagline);

        $movie->update();

        $webPage->appendContent("<p>Le film a été modifié avec succès.</p>");
    } else {
        $newMovie = Movie::create($title, $originalLanguage, $originalTitle, $overview, $releaseDate, $runtime, $tagline, $posterId);

        $newMovie->insert();

        $webPage->appendContent("<p>Le film a été ajouté avec succès.</p>");
    }
} else {
    $webPage->appendContent("<p>Aucune donnée n'a été soumise.</p>");
}

echo $webPage->toHTML();
