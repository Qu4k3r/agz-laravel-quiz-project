<?php

namespace App\Packages\Quiz\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Student\Domain\Model\Student;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="quizzes")
 */
class Quiz
{
    use Identifiable, TimestampableEntity;

    const OPENED = 'open';
    const CLOSED = 'close';

    public function __construct(
        /**
         * @ORM\OneToOne(
         *     targetEntity="App\Packages\Student\Domain\Model\Student",
         *     inversedBy="user"
         * )
         */
        private Student $student,

        /** @ORM\Column(type="datetime") */
        private \DateTime $sentAt,

        /** @ORM\Column(type="smallint") */
        private int $totalQuestions,

        /**
         * @ORM\OneToMany(
         *     targetEntity="App\Packages\Question\Domain\Model\Question",
         *     mappedBy="quiz",
         *     cascade={"persist", "remove"},
         * )
         */
        private ArrayCollection $questions,

        /** @ORM\Column(type="smallint", nullable=true) */
        private ?int $score = null,

        /** @ORM\Column(type="string") */
        private string $status = self::OPENED,
    )
    {
        $this->questions = new ArrayCollection();
    }
}
