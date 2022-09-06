<?php

namespace App\Packages\Question\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Domain\Model\Quiz;
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

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Packages\Quiz\Domain\Model\Quiz",
     *     inversedBy="questions",
     *     cascade={"persist", "remove"},
     * )
     */
    private Quiz $quiz;

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
    )
    {
        $this->subjects = new ArrayCollection();
    }
}
