<?php

declare(strict_types=1);

namespace Appocular\Clients\Contracts;

interface Assessor
{
    /**
     * Report diff result to Assessor.
     */
    public function reportDiff(string $image_kid, string $baseline_kid, string $diff_kid, bool $different): void;
}
