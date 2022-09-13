<?php

namespace App\Packages\Student\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="students")
 */
class Student
{
    use Identifiable, TimestampableEntity;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Packages\Quiz\Domain\Model\Quiz",
     *     mappedBy="student",
     * )
     */
    private ?Collection $quizzes = null;

    public function __construct(
        /** @ORM\Column(type="string") */
        private string $name,
        /** @ORM\Column(type="string") */
        private string $lastname,
        /** @ORM\Column(type="integer", unique=true) */
        private int $registerId,
    )
    {
        $this->quizzes = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getRegisterId(): int
    {
        return $this->registerId;
    }
}
