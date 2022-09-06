<?php

namespace App\Packages\Quiz\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="students")
 */
class Quiz
{
    use Identifiable, TimestampableEntity;

    public function __construct(
        /**
         * @ORM\Id
         * @ORM\Column(type="string")
         */
        private string $name,
        /**
         * @ORM\Id
         * @ORM\Column(type="string")
         */
        private string $lastname
    ) {}
}
