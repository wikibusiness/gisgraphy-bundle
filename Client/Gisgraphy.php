<?php
/*
 * This file is part of the WB\ElasticaBundle package.
 *
 * (c) WikiBusiness <http://company.wikibusiness.org/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WB\GisgraphyBundle\Client;

use GuzzleHttp\Client;

/**
 * Class Gisgsraphy
 *
 * @package WB\GisgraphyBundle\Client
 * @author  Hasse Ramlev Hansen <hh@wikibusiness.org>
 */
class Gisgsraphy
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
    private $country;

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
     */
    public function setAddress($address)
    {
        $this->address = str_replace(',', ' ', $address);

    }

    /**
     * @param $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param array $options
     *
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     */
    public function parse(array $options = [])
    {
        $options = array_merge($this->default_options, $options);

        $options['country'] = $this->country;
        $options['address'] = $this->address;

        $response = $this->client->get($this->endpoint, http_build_query($options));

        return $response;
    }
}