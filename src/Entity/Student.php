<?php

namespace App\Entity;

// Lab 3 - I.8 : simple PHP class (not a Doctrine entity)
class Student
{
    private ?int $id = null;
    private ?string $name = null;
    private ?int $age = null;

    public function __construct(?int $id = null, ?string $name = null, ?int $age = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }
}
