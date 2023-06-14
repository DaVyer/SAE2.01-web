<?php

declare(strict_types=1);

use Entity\Cast;
use Html\AppWebPage;
use Entity\Cover;
use Entity\Movie;
use Entity\Collection\PeopleCollection;

$webPage = new AppWebPage();
$webPage->appendCssUrl("css/style.css");

$filmId = 1;
if (!empty($_GET['filmId']) && ctype_digit($_GET['filmId'])) {
    $filmId = (int)$_GET['filmId'];
}

$webPageFilm = Movie::findById($filmId);
$webPage->setTitle("Film - {$webPageFilm->getTitle()}");
$webPage->appendContent("
<nav class='navigation'>
    <div class='menu'>
        <a href='index.php'>Page d'acceuil</a>
        <a href='edition.php'>Page d'édition</a>
    </div>
</nav>
");


$coverId = $webPageFilm->getPosterId();
if ($coverId !== null) {
    $cover = Cover::findById($coverId);
} else {
    $cover = null;
}
if ($cover !== null) {
    $img = "data:image/jpeg;charset=utf-8;base64, " . base64_encode($cover->getJpeg());
} else {
    $img = 'img/movie.png';
}

$webPage->appendContent("
        <div class='film'>
            <div class='film__infos'>
                <div class='film__poster'><img src='$img'></div>
                <div class='film__container'>
                    <div>
                        <div class='film__title'>Titre : {$webPageFilm->getTitle()}</div>
                        <div class='film__date'>Date de sortie : {$webPageFilm->getReleaseDate()}</div>
                    </div>
                    <div class='film__originalTitle'>Titre original : {$webPageFilm->getOriginalTitle()}</div>
                    <div class='film__tagline'>Slogan : {$webPageFilm->getTagline()}</div>
                    <div class='film__overview'>Résumé : {$webPageFilm->getOverview()}</div>
                </div>
            </div>
        </div>");

$peopleCollection = new PeopleCollection();
$actors = $peopleCollection->findByMovieId($filmId);

if (!empty($actors)) {
    $webPage->appendContent("
    <div class='actor'>
    <h2>Acteurs</h2>
    <div class='actor__infos'>");

    foreach ($actors as $actor) {
        $cast = Cast::findByMovieAndPeopleId($filmId, $actor->getId());
        $role = $cast->getRole();
        $webPage->appendContent("<div class='actor__container'><a href='acteur.php?peopleId={$actor->getId()}'> ");
        $cover = $actor->getCover();

        if ($cover !== null) {
            $img = base64_encode($cover->getJpeg());
            $webPage->appendContent("<div class='actor__image'><img src='data:image/jpeg;charset=utf-8;base64,{$img}' alt='{$actor->getName()}'></div>");

        } else {
            $webPage->appendContent("<div class='actor__image'><img src='img/actor.png' alt='{$actor->getName()}'></div>");
        }

        $webPage->appendContent("
        <div class='actor__content'>
            <div class='actor__name'>
                <p>{$actor->getName()}</p>
            </div>
        <div class='actor__role'>
            <p>Rôle: {$role}</p>
        </div>
    </div>
</a></div>");
    }
} else {
    $webPage->appendContent("<p>Aucun acteur trouvé pour ce film.</p>");
}

$webPage->appendContent("</div></div>");

$webPage->appendContent("
    <form method='post' action='deleteMovie.php'>
        <input type='hidden' name='filmId' value='$filmId'>
        <input type='submit' value='Supprimer'>
    </form>
");
echo $webPage->toHTML();
