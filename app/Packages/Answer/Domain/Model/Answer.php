<?php

namespace App\Packages\Answer\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Question\Domain\Model\Question;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="answers")
 */
class Answer
{
    use Identifiable, TimestampableEntity;

    public function __construct(
        /** @ORM\Column(type="string") */
        private string $name,

        /**
         * @ORM\ManyToOne   (
         *     targetEntity="App\Packages\Question\Domain\Model\Question",
         *     inversedBy="answers",
         * )
         */
        private Question $question,

        /** @ORM\Column(type="boolean") */
        private bool $isCorrect,
    ) {}
}
