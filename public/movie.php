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

$webPage->appendCssUrl("public/style.css");

$webPageFilm = Movie::findById((int)$_GET['filmId']);
$webPage->setTitle("Film - {$webPageFilm->getTitle()}");
$cover = Cover::findById($webPageFilm->getPosterId());
$img = base64_encode($cover->getJpeg());

$webPage->appendContent("
            <div class='film__infos'>
                <div class='film__poster'><img src='data:image/jpeg;charset=utf-8;base64, {$img}'></div>
                <div class='film__container'>
                    <div>
                        <div class='film__title'>Titre : {$webPageFilm->getTitle()}</div>
                        <div class='film__date'>Date de sortie : {$webPageFilm->getReleaseDate()}</div>
                    </div>
                    <div class='film__originalTitle'>Titre original : {$webPageFilm->getOriginalTitle()}</div>
                    <div class='film__tagline'>Slogan : {$webPageFilm->getTagline()}</div>
                    <div class='film__overview'>Résumé : {$webPageFilm->getOverview()}</div>
                </div>
            </div>");

echo $webPage->toHTML();
