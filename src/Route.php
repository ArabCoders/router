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

/**
 * Route Handler
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Route implements Interfaces\Route
{
    /**
     * @var boolean
     */
    public $isMatched = false;

    /**
     * @var array
     */
    public $params = [ ];

    /**
     * @var string
     */
    private $url = '';

    /**
     * @var array conditions
     */
    private $conditions = [ ];

    public function route( array $params = [ ] )
    {
        $this->url = $params['rule'];

        $this->conditions = $params['conditions'];

        preg_match_all( '@:([\w]+)@', $params['rule'], $p_names, PREG_PATTERN_ORDER );

        $p_names = $p_names[0];

        $url_regex = preg_replace_callback( '@:[\w]+@', function ( $matches )
        {
            $key = str_replace( ':', '', $matches[0] );

            if ( array_key_exists( $key, $this->conditions ) )
            {
                return '(' . $this->conditions[$key] . ')';
            }

            return '([a-zA-Z0-9_\+\-%]+)';

        }, $params['rule'] );

        $url_regex .= '/?';

        if ( preg_match( '@^' . $url_regex . '$@', $params['request'], $p_values ) )
        {
            array_shift( $p_values );

            foreach ( $p_names as $index => $value )
            {
                $this->params[substr( $value, 1 )] = urldecode( $p_values[$index] );
            }

            foreach ( $params['target'] as $key => $value )
            {
                $this->params[$key] = $value;
            }

            $this->isMatched = true;
        }
    }

    public function isMatched(): bool
    {
        return $this->isMatched;
    }
}
