<?php

namespace App\Packages\Quiz\Snapshot\Domain\Repository;

use App\Packages\Base\Domain\Repository\Repository;
use App\Packages\Quiz\Snapshot\Domain\Model\Snapshot;

class SnapshotRepository extends Repository
{
    protected string $entityName = Snapshot::class;
}
