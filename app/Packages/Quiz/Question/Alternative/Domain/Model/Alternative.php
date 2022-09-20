<?php

namespace App\Packages\Quiz\Question\Alternative\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Question\Domain\Model\Question;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="alternatives")
 */
class Alternative
{
    use Identifiable, TimestampableEntity;

    public function __construct(
        /** @ORM\Column(type="string", unique=true) */
        private string $name,

        /** @ORM\ManyToOne (
         *     targetEntity="App\Packages\Quiz\Question\Domain\Model\Question",
         *     cascade={"persist", "remove"},
         *     inversedBy="alternatives",
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

    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }
}
