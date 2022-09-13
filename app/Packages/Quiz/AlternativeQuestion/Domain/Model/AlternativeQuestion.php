<?php

namespace App\Packages\Quiz\AlternativeQuestion\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Question\Domain\Model\Question;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="alternative_questions")
 */
class AlternativeQuestion
{
    use Identifiable, TimestampableEntity;

    public function __construct(
        /** @ORM\Column(type="string") */
        private string $name,

        /**
         * @ORM\ManyToOne   (
         *     targetEntity="App\Packages\Quiz\Question\Domain\Model\Question",
         *     inversedBy="alternativeQuestions",
         * )
         */
        private Question $question,

        /** @ORM\Column(type="boolean") */
        private bool $isCorrect,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }
}
