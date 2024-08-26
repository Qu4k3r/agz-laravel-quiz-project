<?php

namespace App\Packages\Quiz\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Student\Domain\Model\Student;
use Carbon\Carbon;
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
    const LIMIT_TIME_IN_MINUTES = 60;

    public function __construct(
        /**
         * @ORM\ManyToOne(
         *     targetEntity="App\Packages\Student\Domain\Model\Student",
         *     inversedBy="student",
         *     cascade={"persist", "remove"},
         * )
         */
        private Student $student,

        /** @ORM\Column(type="string") */
        private string $subject,

        /** @ORM\Column(type="smallint") */
        private int $totalQuestions,

        /** @ORM\Column(type="float", nullable=true) */
        private ?float $score = null,

        /** @ORM\Column(type="string") */
        private string $status = self::OPENED,
    ) {}
}
