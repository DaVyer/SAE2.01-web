<?php
declare(strict_types=1);

use Entity\Movie;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filmId'])) {
    $filmId = (int)$_POST['filmId'];

    $movie = Movie::findById($filmId);

    $movie->delete();

    header('Location: index.php');
} else {
    header('Location: index.php');
}
exit;
