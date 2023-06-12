<?php

declare(strict_types=1);

use Html\AppWebPage;
use Entity\Cover;
use Entity\Movie;

$webPage = new AppWebPage();
$webPage->appendCssUrl("css\style.css");

$filmId = 1;
if (isset($_GET['filmId'])) {
    if (!empty($_GET['filmId'])) {
        if (ctype_digit($_GET['filmId'])) {
            $filmId = $_GET['filmId'];
        }
    }
}

$webPageFilm = Movie::findById((int)$_GET['filmId']);
$webPage->setTitle("Film - {$webPageFilm->getTitle()}");
$cover = Cover::findById($webPageFilm->getPosterId());
$img = base64_encode($cover->getJpeg());

$webPage->appendContent("
            <div class='film__infos'>
                <div class='film__poster'><img src='data:image/jpeg;charset=utf-8;base64, {$img}'></div>
                <div class='film__title'>{$webPageFilm->getTitle()}</div>
                <div class='film__date'>{$webPageFilm->getReleaseDate()}</div>
                <div class='film__originalTitle'>{$webPageFilm->getOriginalTitle()}</div>
                <div class='film__tagline'>{$webPageFilm->getTagline()}</div>
                <div class='film__overview'>{$webPageFilm->getOverview()}</div>
            </div>");

echo $webPage->toHTML();
