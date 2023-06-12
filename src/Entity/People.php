<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class People
{
    private ?int $avatarId;
    private ?string $birthday;
    private ?string $deathday;
    private string $name;
    private string $biography;
    private string $placeOfBirth;
    private int $id;
}