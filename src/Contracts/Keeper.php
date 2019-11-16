<?php

declare(strict_types=1);

namespace Appocular\Clients\Contracts;

interface Keeper
{
    /**
     * Store image.
     *
     * Submits PNG data and returns it's Keeper ID.
     *
     * @param string $data
     *   Binary PNG data.
     *
     * @return string
     *   Keeper ID of stored image.
     */
    public function store(string $data): string;

    /**
     * Get image.
     *
     * Fetches the image with the given Keeper ID.
     *
     * @param string $kid
     *   Image Keeper ID to fetch.
     *
     * @return string|null
     *   PNG data or null if not found.
     */
    public function get(string $kid): ?string;
}
