<?php
/**
 * This file is part of the wikibusiness.org package.
 *
 * (c) WikiBusiness <http://company.wikibusiness.org/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WB\GisgraphyBundle;

/**
 * Class GisgraphyAddress
 *
 * @package WB\GisgraphyBundle
 * @author  Hasse Ramlev Hansen <hh@wikibusiness.org>
 */
class GisgraphyAddress implements \ArrayAccess
{
    /**
     * @var array
     */
    private $address;

    /**
     * @param array $address
     */
    public function __construct($address = [])
    {
        $this->address = $address;
    }

    /**
     * Return the address array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->address;
    }

    /**
     * Show values from the parsed address.
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->address);
    }

    /**
     * {@inheritdoc}
     */
    public function __get($key)
    {
        if (isset($this->address[$key])) {
            return $this->address[$key];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, array $arguments = [])
    {
        $action = substr($method, 0, 3);
        $key    = substr($method, 3);

        if ('get' === $action) {
            return $this->__get($key);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->address[] = $value;
        } else {
            $this->address[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->address[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->address[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return isset($this->address[$offset]) ? $this->address[$offset] : null;
    }
}
