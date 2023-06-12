<?php

declare(strict_types=1);

use Html\AppWebPage;
use Entity\Movie;
use Entity\Collection\MovieCollection;

$webPage = new AppWebPage();

$webPage->setTitle("Film");
$webPage->appendCssUrl("public/style.css");

$listeFilm = (new Entity\Collection\MovieCollection())->findAll();

foreach ($listeFilm as $film) {
    $moviesName = $webPage->escapeString("{$film->getTitle()}");
    $webPage->appendContent("<a href='movie.php?movieId={$film->getId()}'>".$moviesName."</a><br>");
}

echo $webPage->toHTML();
