<?php

namespace App\Packages\Quiz\Subject\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Domain\Model\Quiz;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="subjects")
 */
class Subject
{
    use Identifiable, TimestampableEntity;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Packages\Quiz\Domain\Model\Quiz",
     *     mappedBy="subject",
     *     cascade={"persist", "remove"},
     * )
     */
    private ?Quiz $quiz = null;

    public function __construct(
        /** @ORM\Column(type="string", unique=true) */
        private string $name,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }
}
