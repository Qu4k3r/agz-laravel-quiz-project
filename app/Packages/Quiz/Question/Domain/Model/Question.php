<?php

namespace App\Packages\Quiz\Question\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative;
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

        /**
         * @ORM\OneToMany (
         *     targetEntity="App\Packages\Quiz\Question\Alternative\Domain\Model\Alternative",
         *     mappedBy="question",
         *     cascade={"persist", "remove"},
         * )
         */
        private ?Collection $alternatives = null,
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

    public function addAlternative(Alternative $alternative): void
    {
       if (!$this->alternatives->contains($alternative)) {
//           $alternative->setQuestion($this);
           $this->alternatives->add($alternative);
       }
    }
}
