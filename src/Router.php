<?php
/**
 * This file is part of {@see \arabcoders\router} package.
 *
 * (c) 2014-2016 Abdul.Mohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\router;

use arabcoders\router\
{
    Interfaces\Route as RouteInterface,
    Interfaces\Router as RouterInterface
};

/**
 * Routes Handler.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Router implements RouterInterface
{
    /**
     * @var string True Class name as it passed.
     */
    public $controller;

    /**
     * @var string
     */
    public $controllerName;

    /**
     * @var string
     */
    public $action;

    /**
     * @var array
     */
    public $params = [ ];

    /**
     * @var string Default controller
     */
    protected $defaultController = 'index';

    /**
     * @var string Default action
     */
    protected $defaultAction = 'index';

    /**
     * @var string request URI
     */
    protected $requestUri;

    /**
     * @var RouteInterface
     */
    protected $routeClass;

    public function __construct( array $options = [ ] )
    {
        if ( !empty( $options['uri'] ) )
        {
            $uri = $options['uri'];
        }
        else
        {
            $uri = ( ( !empty( $_SERVER['REQUEST_URI'] ) ) ? $_SERVER['REQUEST_URI'] : null );
        }

        if ( !empty( $options['script'] ) )
        {
            $script = $options['script'];
        }
        else
        {
            $script = ( ( !empty( $_SERVER['SCRIPT_NAME'] ) ) ? $_SERVER['SCRIPT_NAME'] : null );
        }

        $uri = explode( '/', $uri );

        $script = explode( '/', $script );

        for ( $i = 0, $rot = sizeof( $script ); $i < $rot; $i++ )
        {
            if ( $uri[$i] == $script[$i] )
            {
                unset( $uri[$i] );
            }
        }

        $uri = '/' . join( '/', $uri );

        $pos = strpos( $uri, '?' );
        if ( $pos )
        {
            $uri = substr( $uri, 0, $pos );
        }

        $this->requestUri = $uri;
    }

    public function map( $rule, array $target = [ ], array $conditions = [ ], array $options = [ ] )
    {
        if ( empty( $this->routeClass ) )
        {
            $this->routeClass = new Route();
        }

        /**
         * @var route $route
         */
        $route = $this->routeClass->route(
            [
                'rule'       => $rule,
                'request'    => $this->requestUri,
                'target'     => $target,
                'conditions' => $conditions,
                'options'    => $options,
            ]
        );

        if ( $route->isMatched() )
        {
            $this->setRoute( $route );

            return true;
        }

        return false;
    }

    public function setRoute( RouteInterface $route, array $options = [ ] ): RouterInterface
    {
        if ( !empty( $route->params ) )
        {
            $params = $route->params;
        }

        if ( !empty( $params['action'] ) )
        {
            $this->action = $params['action'];
            unset( $params['action'] );
        }
        else
        {
            $this->action = $this->defaultAction;
        }

        if ( isset( $params['controller'] ) )
        {
            $this->controller = $params['controller'];
            unset( $params['controller'] );
        }
        else
        {
            $this->controller = $this->defaultController;
        }

        $this->params = $params;

        $w = explode( '_', $this->controller );

        foreach ( $w as $k => $v )
        {
            $w[$k] = ucfirst( $v );
        }

        $this->controllerName = implode( '', $w );

        return $this;
    }

    public function setRouteClass( RouteInterface $class ): RouterInterface
    {
        $this->routeClass = $class;

        return $this;
    }

    public function setDefaultAction( string $action ): RouterInterface
    {
        $this->defaultAction = $action;

        return $this;
    }

    public function getDefaultAction(): string
    {
        return $this->defaultAction;
    }

    public function setDefaultController( string $controller ): RouterInterface
    {
        $this->defaultController = $controller;

        return $this;
    }

    public function getDefaultController(): string
    {
        return $this->defaultController;
    }

}