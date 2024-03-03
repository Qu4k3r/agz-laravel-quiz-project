<?php

namespace App\Packages\Base\Domain\Repository;

use LaravelDoctrine\ORM\Facades\EntityManager;

class Repository extends AbstractRepository
{
    public function add(object $entity)
    {
        EntityManager::persist($entity);
    }

    public function update(object $entity): object
    {
        return EntityManager::merge($entity);
    }

    public function remove(object $entity): void
    {
        EntityManager::remove($entity);
    }

    public function flush(): void
    {
        EntityManager::flush();
    }
}
