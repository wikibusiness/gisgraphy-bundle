<?php
/*
 * This file is part of the wikibusiness.org package.
 *
 * (c) WikiBusiness <http://company.wikibusiness.org/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WB\GisgraphyBundle\Client;

use GuzzleHttp\Client;
use WB\GisgraphyBundle\GisgraphyAddress;

/**
 * Class Gisgsraphy
 *
 * @package WB\GisgraphyBundle\Client
 * @author  Hasse Ramlev Hansen <hh@wikibusiness.org>
 */
class Gisgraphy
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $defaultOptions = [
        'indent' => true,
        'format' => 'json',
    ];

    /**
     * @var string
     */
    private $rawAddress;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $endpoint = 'http://services.gisgraphy.com/addressparser';

    /**
     * @param null $rawAddress
     * @param null $countryCode
     */
    public function __construct($rawAddress = null, $countryCode = null)
    {
        $this->client = new Client();

        $this->setAddress($rawAddress);
        $this->setCountryCode($countryCode);
    }

    /**
     * Set source address string.
     *
     * @param string $rawAddress
     *
     * @return $this
     */
    public function setAddress($rawAddress)
    {
        $this->rawAddress = str_replace([',', "\n"], ' ', $rawAddress);

        return $this;
    }

    /**
     * Set country code for the address, must be iso 2 char version.
     *
     * @param string $countryCode
     *
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Decode the address.
     *
     * @param array $options
     *
     * @return bool|GisgraphyAddress
     */
    public function decode(array $options = [])
    {
        $options = array_merge($this->defaultOptions, $options);

        $options['country'] = $this->countryCode;
        $options['address'] = $this->rawAddress;

        try {
            $response = $this->client->get($this->endpoint.'?'.http_build_query($options));
            $address  = $response->json();

            if (0 === $address['numFound']) {
                return false;
            }

            return new GisgraphyAddress((array) $address['result'][0]);
        } catch (\Exception $e) {
            // Handle exception.
        }

        return false;
    }
}
