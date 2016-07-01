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
 * Router Interface.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
interface Router
{
    /**
     * Constructor
     *
     * @param array $options
     */
    Public function __construct( array $options = [ ] );

    /**
     * map route
     *
     * @param string $rule
     * @param array  $target
     * @param array  $conditions
     * @param array  $options
     *
     * @return bool
     */
    public function map( $rule, array $target = [ ], array $conditions = [ ], array $options = [ ] );

    /**
     * set route
     *
     * @param Route $route
     * @param array $options
     *
     * @return Router
     */
    public function setRoute( Route $route, array $options = [ ] ): Router;

    /**
     * set callable route.
     *
     * @param Route $class
     *
     * @return Router
     */
    public function setRouteClass( Route $class ): Router;

    /**
     * set action method.
     *
     * @param string $action
     *
     * @return Router
     */
    public function setDefaultAction( string $action ): Router;

    /**
     * get action method.
     *
     * @return string
     */
    public function getDefaultAction(): string;

    /**
     * Set default controller.
     *
     * @param $controller
     *
     * @return Router
     */
    public function setDefaultController( string $controller ): Router;

    /**
     * get default controller.
     *
     * @return string
     */
    public function getDefaultController(): string;
}