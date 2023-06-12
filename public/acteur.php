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
$webPage->setTitle("Films - {$actor->getName()}");

$cover = Cover::findById($actor->getAvatarId());
$img = base64_encode($cover->getJpeg());

$webPage->appendContent("<h2>{$actor->getName()}</h2>");
$webPage->appendContent("<img src='data:image/jpeg;charset=utf-8;base64, {$img}' alt='{$actor->getName()}'>");
$webPage->appendContent("<p>Date de naissance : {$actor->getBirthday()}</p>");
$webPage->appendContent("<p>Lieu de naissance : {$actor->getPlaceOfBirth()}</p>");
$webPage->appendContent("<p>Biographie : {$actor->getBiography()}</p>");

$movieCollection = new MovieCollection();
$movies = $movieCollection->findByPeopleId($peopleId);


if ($movies) {
    $webPage->appendContent("<h3>Filmographie</h3>");
    $webPage->appendContent("<ul>");
    foreach ($movies as $movie) {
        $cast = Cast::findByMovieAndPeopleId($movie->getId(), $actor->getId());
        $role = $cast->getRole();
        $cover = $movie->getCover();
        if ($cover) {
            $img = base64_encode($cover->getJpeg());
            $webPage->appendContent("<img src='data:image/jpeg;charset=utf-8;base64,{$img}' alt='{$actor->getName()}'>");
        } else {
            $webPage->appendContent("<img src='img/actor.png' alt='{$actor->getName()}'>");
        }
        $webPage->appendContent("<p>Rôle : {$role}</p>");
        $webPage->appendContent("<p>{$movie->getTitle()}</p>");
        $webPage->appendContent("<p>{$movie->getReleaseDate()}</p>");
    }
    $webPage->appendContent("</ul>");
} else {
    $webPage->appendContent("<p>Aucun film trouvé pour cet acteur.</p>");
}

echo $webPage->toHTML();