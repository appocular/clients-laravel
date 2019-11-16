<?php

declare(strict_types=1);

namespace Appocular\Clients\Contracts;

interface Differ
{
    /**
     * Submit diffing request to Differ.
     *
     * @param string $image_kid
     *   Keeper ID of image.
     * @param string $baseline_kid
     *   Keeper ID of baseline image.
     */
    public function submit(string $image_kid, string $baseline_kid): void;
}
