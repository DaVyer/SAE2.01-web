<?php

declare(strict_types=1);

use Html\AppWebPage;
use Entity\Movie;
use Entity\Collection\MovieCollection;
use Entity\Cover;

$webPage = new AppWebPage();

$webPage->setTitle("Films");
$webPage->appendCssUrl("css/style.css");

$listeFilm = (new Entity\Collection\MovieCollection())->findAll();


foreach ($listeFilm as $film) {
    $moviesName = $webPage->escapeString("{$film->getTitle()}");
    $webPageFilm = Movie::findById($film->getId())->getPosterId();
    $cover = Cover::findById($webPageFilm);
    $img = base64_encode($cover->getJpeg());
    $webPage->appendContent("
<div class='film'>
<a href='movie.php?filmId={$film->getId()}'>
    <div class='film__poster'>
    <img src='data:image/jpeg;charset=utf-8;base64, {$img}'>
    </div>
</a>
<a class='film__name' href class='movie.php?filmId={$film->getId()}'>".$moviesName."</a>
</div>
<br>
");
}

echo $webPage->toHTML();

