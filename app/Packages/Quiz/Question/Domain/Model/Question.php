<?php

namespace App\Packages\Quiz\Question\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Question\Alternative\Domain\Model\Option;
use App\Packages\Quiz\Subject\Domain\Model\Theme;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use function Psy\sh;

/**
 * @ORM\Entity
 * @ORM\Table(name="questions")
 */
class Question
{
    use Identifiable, TimestampableEntity;

    public function __construct(
        /** @ORM\Column(type="text") */
        private string $name,

        /**
         * @ORM\ManyToOne (
         *     targetEntity="App\Packages\Quiz\Subject\Domain\Model\Subject",
         *     cascade={"persist", "remove"},
         * )
         */
        private Theme $subject,

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

    public function getSubject(): Theme
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

    public function addAlternative(Option $alternative): void
    {
       if (!$this->alternatives->contains($alternative)) {
           $alternative->setQuestion($this);
           $this->alternatives->add($alternative);
       }
    }

    public function shuffleAlternatives(): void
    {
        $alternatives = $this->alternatives->toArray();
        $alternativesClone = $alternatives;
        shuffle($alternatives);
        if ($alternativesClone === $alternatives) {
            $this->shuffleAlternatives();
            return;
        }
        $this->alternatives = new ArrayCollection($alternatives);
    }
}
