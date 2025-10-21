<?php

namespace Silex\ckan;


// use Guzzle\Common\Collection; // cannot find how to replace this
use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;

class CkanClient extends Client {	

    /**
     * Factory method to create a new CkanClient
     *
     * The following array keys and values are available options:
     * - baseUrl: Base URL of web service
     * - scheme:   URI scheme: http or https
     * - username: API username
     * - password: API password
     *
     * @param array|Collection $config Configuration data
     *
     * @return self
     */
    public static function factory($config = array())
    {
        $default = array(
            'baseUrl' => '{scheme}://{username}.test.com/',
            'scheme'  => 'https',
            'apiKey'  => ''
        );
        $required = array('baseUrl');
        // $config = Collection::fromConfig($config, $default, $required); // no docs available who show how to update this to guzzlehttp
        $client = new self($config->get('baseUrl'), $config);
        if (!empty($config['apiKey'])){
            $client->defaultHeaders->set('X-CKAN-API-Key', $config['apiKey']);
        }

        // Attach a service description to the client
        $description = ServiceDescription::factory(__DIR__ . '/service.json');
        $client->setDescription($description);

        return $client;
    }

}
