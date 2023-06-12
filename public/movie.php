<?php

declare(strict_types=1);

use Entity\Cast;
use Html\AppWebPage;
use Entity\Cover;
use Entity\Movie;
use Entity\Collection\PeopleCollection;

$webPage = new AppWebPage();
$webPage->appendCssUrl("css\style.css");

$filmId = 1;
if (!empty($_GET['filmId']) && ctype_digit($_GET['filmId'])) {
    $filmId = (int)$_GET['filmId'];
}

$webPageFilm = Movie::findById($filmId);
$webPage->setTitle("Film - {$webPageFilm->getTitle()}");
$cover = Cover::findById($webPageFilm->getPosterId());
$img = base64_encode($cover->getJpeg());

$webPage->appendContent("<img src='data:image/jpeg;charset=utf-8;base64, {$img}'>");
$webPage->appendContent("<p>Original Title: {$webPageFilm->getOriginalTitle()}</p>");
$webPage->appendContent("<p>Release Date: {$webPageFilm->getReleaseDate()}</p>");
$webPage->appendContent("<p>Overview: {$webPageFilm->getOverview()}</p>");

$peopleCollection = new PeopleCollection();
$actors = $peopleCollection->findByMovieId($filmId);

if (!empty($actors)) {
    $webPage->appendContent("<h2>Acteurs :</h2>");

    foreach ($actors as $actor) {
        $cast = Cast::findByMovieAndPeopleId($filmId, $actor->getId());
        $role = $cast->getRole();
        $webPage->appendContent("<div>");
        $cover = $actor->getCover();
        if ($cover !== null) {
            $img = base64_encode($cover->getJpeg());
            $webPage->appendContent("<img src='data:image/jpeg;charset=utf-8;base64,{$img}' alt='{$actor->getName()}'>");
        } else {
            $webPage->appendContent("<img src='img/actor.png' alt='{$actor->getName()}'>");

        }

        $webPage->appendContent("<p>{$actor->getName()}</p>");
        $webPage->appendContent("<p>Rôle: {$role}</p>");
        $webPage->appendContent("</div>");
    }
} else {
    $webPage->appendContent("<p>Aucun acteur trouvé pour ce film.</p>");
}

echo $webPage->toHTML();
