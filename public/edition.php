<?php


declare(strict_types=1);

use Html\AppWebPage;

$webPage = new \Html\AppWebPage();

$webPage->setTitle("Formulaire de création ou d'édition");

$webPage->appendCssUrl("css/style.css");



$webPage->appendContent("
    <nav class='navigation'>
    <div class='menu'>
        <a href='index.php'>Page d'acceuil</a>
    </div>
</nav>
<form method='POST' class='formulaire' action='Modification.php'>
    <div class='form__content'>
        <label for='title'>Entrer un titre de film
            <input type='text' name='title' id='title' placeholder='Ecriture exacte du film voulu' required>
        </label>
    </div>
    <div class='form__content'>
        <label for='originalLanguage'>Veuillez rentrer une version original
            <input type='text' name='originalLanguage' id='originalLanguage' placeholder='Alias de la langue' required>
        </label>
    </div>
    <div class='form__content'>
        <label for='originalTitle'>Veuillez rentrer un titre original
            <input type='text' name='originalTitle' id='originalTitle'  placeholder='Titre original du film'required>
        </label>
    </div>
    <div class='form__content'>
        <label for='overview'>Veuillez rentrer un résumé
            <input type='text' name='overview' id='overview ' placeholder='Résumé du film'>
        </label>
    </div>
    <div class='form__content'>
        <label for='posterId'>Veuillez rentrer un identifiant d'affiche
            <input type='text' name='posterId' id='posterId' accept='image/png' placeholder='Numéro de l’affiche voulu'>
        </label>
    </div>
    <div class='form__content'>
        <label for='releaseDate'>Veuillez choisir une date de sortie
            <input type='date' name='releaseDate' id='releaseDate' value='01/01/2023' required>
        </label>
    </div>    
    <div class='form__content'>
        <label for='runtime'>Veuillez rentrer la durée du film
            <input type='text' name='runtime' id='runtime' placeholder='Durée en minutes' required>
        </label>
    </div>
    <div class='form__content'>
        <label for='tagline'>Veuillez rentrer le slogan du film
            <input type='text' name='tagline' id='tagline' placeholder='Texte du slogan'>
        </label>
    </div>
    <div class='form__button'>
        <input type='submit' name='submit__form' id='submit__form'>
    </div>
</form>
");



echo $webPage->toHTML();
