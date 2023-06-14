<?php

declare(strict_types=1);

use Html\AppWebPage;
use Entity\Movie;
use Entity\Collection\MovieCollection;
use Entity\Cover;
use Entity\Genre;
use Entity\Collection\GenreCollection;

$webPage = new AppWebPage();

$webPage->setTitle("Films");
$webPage->appendCssUrl("css/style.css");

$genreCollection = new GenreCollection();
$genres = $genreCollection->findAll();

if (isset($_GET['genreId'])) {
    $selectedGenreId = $_GET['genreId'];
} else {
    $selectedGenreId = null;
}

$webPage->appendContent("<div class='filter'>");
$isActive = "";
if ($selectedGenreId === null || $selectedGenreId === "all") {
    $isActive = "active";
}
$webPage->appendContent("<a href='index.php?genreId=all' class='" . $isActive . "'>Tous les genres</a>");
foreach ($genres as $genre) {
    $genreId = $webPage->escapeString(strval($genre->getId()));
    $genreName = $webPage->escapeString($genre->getName());
    if ($selectedGenreId === $genreId) {
        $isActive = "active";
    } else {
        $isActive = "";
    }
    $webPage->appendContent("<a href='index.php?genreId={$genreId}' class='{$isActive}'>{$genreName}</a>");
}
$webPage->appendContent("</div>");

$movieCollection = new MovieCollection();
$listeFilm = [];

if ($selectedGenreId === null || $selectedGenreId === "all") {
    $listeFilm = $movieCollection->findAll();
} else {
    $listeFilm = $movieCollection->findByGenreId($selectedGenreId);
}

$webPage->appendContent("<div class='list'>");
foreach ($listeFilm as $film) {
    $filmId = $webPage->escapeString(strval($film->getId()));
    $moviesName = $webPage->escapeString($film->getTitle());
    $webPageFilm = $film->getPosterId();
    $cover = null;
    $img = '';

    if ($webPageFilm !== null) {
        $cover = Cover::findById($webPageFilm);
        $img = base64_encode($cover->getJpeg());
    } else {
        $img = 'img/movie.png';
    }

    $filmTitle = $webPage->escapeString($film->getTitle());
    $webPage->appendContent("
        <div class='film'>
            <div class='film__poster'>");
    if ($cover !== null) {
        $webPage->appendContent("<a href='movie.php?filmId={$filmId}'><img src='data:image/jpeg;charset=utf-8;base64,{$img}' alt='{$filmTitle}'></a>");
    } else {
        $webPage->appendContent("<a href='movie.php?filmId={$filmId}'><img src='{$img}' alt='{$filmTitle}'></a>");
    }
    $webPage->appendContent("
                <div class='film__name'><a href='movie.php?filmId={$filmId}'>" . $moviesName . "</a></div>
            </div>
        </div>
        <br>
    ");
}
$webPage->appendContent("</div>");

echo $webPage->toHTML();
