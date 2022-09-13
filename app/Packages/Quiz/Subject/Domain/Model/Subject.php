<?php

namespace App\Packages\Quiz\Subject\Domain\Model;

use App\Packages\Doctrine\Domain\Behavior\Identifiable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="subjects")
 */
class Subject
{
    use Identifiable, TimestampableEntity;

    public function __construct(
        /** @ORM\Column(type="string", unique=true) */
        private string $name,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }
}
