<?php
declare(strict_types=1);

namespace Entity;

class Cover
{
    private string $jpeg;
    private int $id;

    /**
     * @return string
     */ 
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


}