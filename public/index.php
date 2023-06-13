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
    $cover = Cover::findById($webPageFilm);
    $img = base64_encode($cover->getJpeg());
    $webPage->appendContent("
<div class='film'>
    <div class='film__poster'>");
    if ($webPageFilm !== null) {
        $img = base64_encode($cover->getJpeg());
        $webPage->appendContent("<a href='movie.php.filmId={$film->getId()}'><img src='data:image/jpeg;charset=utf-8;base64,{$img}' alt='{$film->getTitle()}'></a>");

    } else {
        $webPage->appendContent("<a href='movie.php.filmId={$film->getId()}'><img src='img/movie.png' alt='{$film->getTitle()}'></a>");
    }
    $webPage->appendContent("
    
<div class='film__name'><a href='movie.php?filmId={$film->getId()}'>".$moviesName."</a></div>
</div></div>
<br>
");
}
$webPage->appendContent("</div>");

echo $webPage->toHTML();

