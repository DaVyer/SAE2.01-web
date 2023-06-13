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

$webPage->appendContent("<div class='list'>");
foreach ($listeFilm as $film) {
    $moviesName = $webPage->escapeString("{$film->getTitle()}");
    $webPageFilm = Movie::findById($film->getId())->getPosterId();
    $cover = null;
    $img = '';

    if ($webPageFilm !== null) {
        $cover = Cover::findById($webPageFilm);
        $img = base64_encode($cover->getJpeg());
    } else {
        $img = 'img/movie.png';
    }

    $webPage->appendContent("
        <div class='film'>
            <div class='film__poster'>");
    if ($cover !== null) {
        $webPage->appendContent("<a href='movie.php?filmId={$film->getId()}'><img src='data:image/jpeg;charset=utf-8;base64,{$img}' alt='{$film->getTitle()}'></a>");
    } else {
        $webPage->appendContent("<a href='movie.php?filmId={$film->getId()}'><img src='{$img}' alt='{$film->getTitle()}'></a>");
    }
    $webPage->appendContent("
                <div class='film__name'><a href='movie.php?filmId={$film->getId()}'>" . $moviesName . "</a></div>
            </div>
        </div>
        <br>
    ");
}
$webPage->appendContent("</div>");

echo $webPage->toHTML();