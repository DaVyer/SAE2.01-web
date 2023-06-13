<?php


declare(strict_types=1);

use Html\AppWebPage;

$webPage = new \Html\AppWebPage();

$webPage->setTitle("Formulaire de création, d'édition ou de suppression d'un film");

$webPage->appendCssUrl("css/style.css");

$webPage->appendContent("
<form method='get' class='formulaire'>
    <div class='form__input'>
        <label for='id'>Entrer un id de film
            <input type='text' name='id' id='id'>
        </label>
        <label for='title'>Entrer un titre de film
            <input type='text' name='title' id='title' required>
        </label>
        <label for='originalLanguage'>Veuillez rentrer une version original
            <input type='text' name='originalLanguage' id='originalLanguage'>
        </label>
        <label for='originalTitle'>Veuillez rentrer un titre original
            <input type='text' name='originalTitle' id='originalTitle'>
        </label>
        <label for='overview'>Veuillez rentrer un résumé
            <input type='text' name='overview' id='overview'>
        </label>
        <label for='posterId'>Veuillez rentrer un identifiant d'affiche
            <input type='text' name='posterId' id='posterId'>
        </label>
        <label for='releaseDate'>Veuillez rentrer une date de sortie
            <input type='text' name='releaseDate' id='releaseDate'>
        </label>
        <label for='runtime'>Veuillez rentrer la durée du film
            <input type='text' name='runtime' id='runtime'>
        </label>
        <label for='tagline'>Veuillez rentrer la slogan du film
            <input type='text' name='tagline' id='tagline'>
        </label>
    </div>
    <input type='submit' name='submit__form' id='submit__form'>
</form>
");

echo $webPage->toHTML();