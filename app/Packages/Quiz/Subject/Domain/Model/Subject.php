<?php

namespace App\Packages\Quiz\Subject\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Quiz\Question\Domain\Model\Question;
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
     * @ORM\OneToOne(
     *     targetEntity="App\Packages\Quiz\Question\Domain\Model\Question",
     *     mappedBy="subject",
     * )
     */
    private ?Question $question = null;

    /**
     * @ORM\OneToOne(
     *     targetEntity="App\Packages\Quiz\Domain\Model\Quiz",
     *     mappedBy="subject",
     * )
     */
    private ?Quiz $quiz = null;

    public function __construct(
        /** @ORM\Column(type="string") */
        private string $name,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }
}
