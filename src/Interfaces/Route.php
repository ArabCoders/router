<?php
/**
 * This file is part of {@see \arabcoders\router} package.
 *
 * (c) 2014-2016 Abdul.Mohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\router\Interfaces;

/**
 * Route Interface.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */

interface Route
{
    /**
     * parse route
     *
     * @param array $params
     */
    public function route( array $params = [ ] );

    /**
     * Whether the route matches.
     *
     * @return bool
     */
    public function isMatched(): bool;
}