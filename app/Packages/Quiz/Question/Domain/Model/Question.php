<?php

namespace App\Packages\Quiz\Question\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Subject\Domain\Model\Subject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany (
     *     targetEntity="App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative",
     *     mappedBy="question",
     *     cascade={"persist", "remove"},
     * )
     */
    private ?Collection $alternatives;

    public function __construct(
        /** @ORM\Column(type="string") */
        private string $name,

        /**
         * @ORM\ManyToOne (
         *     targetEntity="App\Packages\Quiz\Subject\Domain\Model\Subject",
         *     cascade={"persist", "remove"},
         * )
         */
        private Subject $subject,
    )
    {
        $this->alternatives = new ArrayCollection();
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlternatives(): array
    {
        return $this->alternatives->toArray();
    }
}
