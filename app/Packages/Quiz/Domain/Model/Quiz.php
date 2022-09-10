<?php

namespace App\Packages\Quiz\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use App\Packages\Student\Domain\Model\Student;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="quizzes")
 */
class Quiz
{
    use Identifiable, TimestampableEntity;

    const OPENED = 'OPENED';
    const CLOSED = 'CLOSED';

    public function __construct(
        /**
         * @ORM\OneToOne(
         *     targetEntity="App\Packages\Student\Domain\Model\Student",
         *     inversedBy="quiz"
         * )
         */
        private Student $student,

        /**
         * @ORM\OneToOne(
         *     targetEntity="App\Packages\Quiz\Subject\Domain\Model\Subject",
         *     inversedBy="quiz"
         * )
         */
        private Subject $subject,

        /** @ORM\Column(type="smallint") */
        private int $totalQuestions,

        /**
         * @ORM\Column (
         *     type="jsonb",
         * )
         */
        private array $questions,

        /** @ORM\Column(type="smallint", nullable=true) */
        private ?int $score = null,

        /** @ORM\Column(type="string") */
        private string $status = self::OPENED,
    )
    {
    }
}
