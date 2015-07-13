<?php

namespace Rz\GoogleAPIClientBundle\Services;

/**
 * Class GoogleClient
 *
 * This is the google client that is used by almost every api
 */
class GoogleServiceAnalytics extends \Google_Service_Analytics
{
    /**
     * @var GoogleClient client
     *
     *
     */
    public $gClient;

    /**
     * Constructor
     * @param GoogleClient $client
     */
    public function __construct(GoogleClient $gClient)
    {
        parent::__construct($gClient->getGoogleClient());
        $this->gClient = $gClient;
    }

    public function authenticate() {

        // Create and configure a new client object.
        $client = $this->getClient();
        $client->setApplicationName("g_service_analytics");
        $configManager  = $this->gClient->getConfigManager();

        $serviceConfig = $configManager->getConfig('service');


        // Read the generated client_secrets.p12 key.
        $key = file_get_contents($configManager->getConfigInConfigs('certificate_p12', $serviceConfig));
        $cred = new \Google_Auth_AssertionCredentials(
            $configManager->getConfigInConfigs('client_email', $serviceConfig),
            array(\Google_Service_Analytics::ANALYTICS_READONLY),
            $key
        );
        $client->setAssertionCredentials($cred);
        if($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }

        return $client;
    }

    /**
     * @return GoogleClient
     */
    public function getGClient()
    {
        return $this->gClient;
    }

    /**
     * @param GoogleClient $gClient
     */
    public function setGClient($gClient)
    {
        $this->gClient = $gClient;
    }
}