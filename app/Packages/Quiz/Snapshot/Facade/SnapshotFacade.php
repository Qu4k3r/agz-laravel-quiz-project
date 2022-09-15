<?php

namespace App\Packages\Quiz\Snapshot\Facade;


use App\Packages\Quiz\Snapshot\Domain\Repository\SnapshotRepository;

class SnapshotFacade
{
    public function __construct(private SnapshotRepository $subjectRepository) {}
}
