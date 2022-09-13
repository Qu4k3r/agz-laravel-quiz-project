<?php

namespace App\Packages\Quiz\Question\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use App\Packages\Quiz\Domain\Model\Quiz;
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
         *     inversedBy="subject",
         *     cascade={"persist", "remove"},
         * )
         */
        private Subject $subject,

        /**
         * @ORM\OneToMany(
         *     targetEntity="App\Packages\Quiz\AlternativeQuestion\Domain\Model\AlternativeQuestion",
         *     mappedBy="question",
         *     cascade={"persist", "remove"},
         * )
         */
        private ?Collection $alternativeQuestions = null
    )
    {
        $this->alternativeQuestions = new ArrayCollection();
    }

    public function addAlternativeQuestions(Collection $alternativeQuestions): void
    {
        $alternativeQuestions->map(function ($alternativeQuestion) {
            if (!$this->alternativeQuestions->contains($alternativeQuestion)) {
                $this->alternativeQuestions->add($alternativeQuestion);
            }
        });
    }

    public function getAlternativeQuestions(): ?Collection
    {
        return $this->alternativeQuestions;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
