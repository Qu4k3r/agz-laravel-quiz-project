<?php

namespace App\Packages\Quiz\Snapshot\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Domain\Model\Quiz;
use App\Packages\Student\Domain\Model\Student;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="snapshots")
 */
class Snapshot
{
    use Identifiable, TimestampableEntity;

    public function __construct(
        /**
         * @ORM\ManyToOne(
         *     targetEntity="App\Packages\Quiz\Domain\Model\Quiz",
         *     cascade={"persist", "remove"},
         * )
         */
        private Quiz $quiz,
        /**
         * @ORM\ManyToOne(
         *     targetEntity="App\Packages\Student\Domain\Model\Student",
         *     cascade={"persist", "remove"},
         * )
         */
        private Student $student,
        /** @ORM\Column(type="string") */
        private string $subjectName,
        /** @ORM\Column(type="string") */
        private string $questionName,
        /** @ORM\Column(type="string") */
        private string $alternativeName,
        /** @ORM\Column(type="boolean") */
        private bool $isCorrect,
        /** @ORM\Column(type="boolean") */
        private ?bool $studentAlternative = null,
        /** @ORM\Column(type="boolean") */
        private ?bool $rightAnswer = null,
    ) {}
}
