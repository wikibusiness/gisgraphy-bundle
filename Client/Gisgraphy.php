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
    private $default_options = [
        'indent' => true,
        'format' => 'json',
    ];

    private $address;

    /**
     * @var string
     */
    private $country_code;

    /**
     * @var string
     */
    private $endpoint = 'http://services.gisgraphy.com/addressparser';

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param $address
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = str_replace(',', ' ', $address);

        return $this;
    }

    /**
     * @param $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country_code = $country;

        return $this;
    }

    /**
     * @param array $options
     *
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     */
    public function parse(array $options = [])
    {
        $options = array_merge($this->default_options, $options);

        $options['country'] = $this->country_code;
        $options['address'] = $this->address;

        try {
            $response               = $this->client->get($this->endpoint.'?'.http_build_query($options));
            $this->gisgraphyAddress = json_decode($response->getBody()->getContents());

            return new GisgraphyAddress((array)$this->gisgraphyAddress->result[0]);
        } catch (\Exception $e) {
            return false;
        }
    }
}
