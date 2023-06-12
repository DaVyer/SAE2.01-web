<?php

declare(strict_types=1);


use Entity\Movie;
use Html\AppWebPage;

require_once '../src/Html/WebPage.php';
require_once '../vendor/autoload.php';

$webpage = new AppWebPage();
$webpage->setTitle("Informations");

if (isset($_GET['filmId'])) {
    $filmId = (int)$_GET['filmId'];

    try {
        $MovieName = Movie::findById($filmId);
        $Peoples = $MovieName->getPeoples();

        $webpage->appendContent("<h1>{$MovieName->getTitle()}</h1>");

        if (count($Peoples) > 0) {
            $webpage->appendContent("<h2>Cast:</h2>");
            $webpage->appendContent("<ul>");

            foreach ($Peoples as $people) {
                $webpage->appendContent("<li>{$people->getName()}</li>");
            }

            $webpage->appendContent("</ul>");
        } else {
            $webpage->appendContent("<p>Aucun album disponible pour cet artiste.</p>");
        }

    }
}
echo $webpage->toHTML();