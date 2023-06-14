<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

use Entity\Cast;
use Entity\Collection\MovieCollection;
use Entity\Cover;
use Html\AppWebPage;
use Entity\People;

$peopleId = 1;
if (!empty($_GET['peopleId']) && ctype_digit($_GET['peopleId'])) {
    $peopleId = (int)$_GET['peopleId'];
}

$actor = People::findById($peopleId);


$webPage = new AppWebPage("Détails de l'acteur : " . $actor->getName());
$webPage->appendCssUrl("css\style.css");
$webPage->setTitle("Films - {$actor->getName()}");

$cover = $actor->getCover();
$webPage->appendContent("
<nav class='navigation'>
    <div class='menu'>
        <a href='index.php'>Page d'acceuil</a>
        <a href='edition.php'>Page d'édition</a>
    </div>
</nav>
");

$webPage->appendContent("
        <div class='actor'>
            <div class='acteur__infos'>");

if ($cover !== null) {
    $img = base64_encode($cover->getJpeg());
    $webPage->appendContent("<div class='actor__image'><img src='data:image/jpeg;charset=utf-8;base64,{$img}' alt='{$actor->getName()}'></div>");

} else {
    $webPage->appendContent("<div class='actor__image'><img src='img/actor.png' alt='{$actor->getName()}'></div>");
}
if ($actor->getDeathday()!== null) {
    $mort=$actor->getDeathday();
} else {
    $mort= "Vivant(e)";
}

if ($actor->getBiography()!== "") {
    $Bio=$actor->getBiography();
} else {
    $Bio= "Non renseignée";
}
if ($actor->getPlaceOfBirth()!=="") {
    $Lieu=$actor->getPlaceOfBirth();
} else {
    $Lieu= "Non renseigné";
}
$webPage->appendContent("<div class='acteur__container'>
                    <div class='acteur__name'>Nom : {$actor->getName()}</div>
                    <div class='acteur__lieu'>Lieu de naissance : {$Lieu}</div>
                    <div class='acteur__date'>Date de naissance : {$actor->getBirthday()}  -  Date de mort: {$mort}</div>
                    <div class='acteur__biography'>Biographie : {$Bio}</div>
                </div>
            </div>
        </div>");

$movieCollection = new MovieCollection();
$movies = $movieCollection->findByPeopleId($peopleId);


if ($movies) {
    $webPage->appendContent("
        <div class='actor'>
        <h2>Filmographie</h2>
        <div class='actor__infos'>");
    foreach ($movies as $movie) {
        $cast = Cast::findByMovieAndPeopleId($movie->getId(), $actor->getId());
        $role = $cast->getRole();
        $webPage->appendContent("<div class='actor__container'><a href='movie.php?filmId={$movie->getId()}'>");
        $cover = $movie->getCover();
        if ($cover) {
            $img = base64_encode($cover->getJpeg());
            $webPage->appendContent("<div class='actor__image'><img src='data:image/jpeg;charset=utf-8;base64,{$img}' alt='{$actor->getName()}'></div>");
        } else {
            $webPage->appendContent("<div class='actor__image'><img src='img/movie.png' alt='{$actor->getName()}'></div>");
        }

        $webPage->appendContent("
        <div class='acteur__contenu'>
            <div class='acteur__film__info'>
                <div class='acteur__film__title'>Titre : {$movie->getTitle()}</div>
                <div class='acteur__film__date'>Date : {$movie->getReleaseDate()}</div>
            </div>
            <div class='acteur__role'>Rôle: {$role}</div>
    </div>
</a></div>");

    }

} else {
    $webPage->appendContent("<p>Aucun film trouvé pour cet acteur.</p>");
}

$webPage->appendContent("</div></div>");
echo $webPage->toHTML();
