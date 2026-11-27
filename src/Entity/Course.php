<?php

namespace App\Entity;

// Lab 3 - I.8 : simple PHP class (not a Doctrine entity)
class Course
{
    private ?int $id = null;
    private ?string $title = null;

    /**
     * @var Student[]
     */
    private array $students = [];

    public function __construct(?int $id = null, ?string $title = null)
    {
        $this->id = $id;
        $this->title = $title;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Student[]
     */
    public function getStudents(): array
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!in_array($student, $this->students, true)) {
            $this->students[] = $student;
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        $this->students = array_filter($this->students, fn($s) => $s !== $student);

        return $this;
    }
}
