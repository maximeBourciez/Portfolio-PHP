<?php

class ProjetTechnologie
{
    // Attributs
    private int $projet_id;
    private int $technologie_id;


    // Constructeur
    public function __construct(int $projet_id, int $technologie_id)
    {
        $this->projet_id = $projet_id;
        $this->technologie_id = $technologie_id;
    }

    // Encapsulation
    // getters
    public function getProjetId(): int
    {
        return $this->projet_id;
    }

    public function getTechnologieId(): int
    {
        return $this->technologie_id;
    }

    // setters
    public function setProjetId(int $projet_id): void
    {
        $this->projet_id = $projet_id;
    }

    public function setTechnologieId(int $technologie_id): void
    {
        $this->technologie_id = $technologie_id;
    }
}
