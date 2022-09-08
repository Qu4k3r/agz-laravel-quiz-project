<?php

namespace App\Packages\Quiz\Question\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="questions")
 */
class Question
{
    use Identifiable, TimestampableEntity;

    public function __construct(
        /** @ORM\Column(type="string") */
        private string $name,

        /**
         * @ORM\OneToMany(
         *     targetEntity="App\Packages\Quiz\Subject\Domain\Model\Subject",
         *     mappedBy="question",
         *     cascade={"persist", "remove"},
         * )
         */
        private ArrayCollection $subjects,

        /**
         * @ORM\OneToMany(
         *     targetEntity="App\Packages\Quiz\AlternativeQuestion\Domain\Model\AlternativeQuestion",
         *     mappedBy="question",
         *     cascade={"persist", "remove"},
         * )
         */
        private ?ArrayCollection $alternativeQuestions = null
    )
    {
        $this->subjects = new ArrayCollection();
        $this->alternativeQuestions = new ArrayCollection();
    }
}
