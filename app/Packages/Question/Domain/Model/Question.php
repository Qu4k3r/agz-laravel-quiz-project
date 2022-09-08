<?php

namespace App\Packages\Question\Domain\Model;

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
         *     targetEntity="App\Packages\Subject\Domain\Model\Subject",
         *     mappedBy="question",
         *     cascade={"persist", "remove"},
         * )
         */
        private ArrayCollection $subjects,

        /**
         * @ORM\OneToMany(
         *     targetEntity="App\Packages\Answer\Domain\Model\Answer",
         *     mappedBy="question",
         *     cascade={"persist", "remove"},
         * )
         */
        private ?ArrayCollection $answers = null
    )
    {
        $this->subjects = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }
}
