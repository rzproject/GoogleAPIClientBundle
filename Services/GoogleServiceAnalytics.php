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
        $configManager  = $this->gClient->getConfigManager();
        $client->setApplicationName($configManager->getGoogleClientServiceAPIAppName());
        if(!$configManager->isGoogleClientAPIEnabled()) {
            return false;
        }
        // Read the generated client_secrets.p12 key.
        $key = file_get_contents($configManager->getGoogleClientServiceAPICertificateP12());
        $cred = new \Google_Auth_AssertionCredentials(
            $configManager->getGoogleClientServiceAPIClientEmail(),
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