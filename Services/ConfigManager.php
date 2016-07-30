<?php

namespace Rz\GoogleAPIClientBundle\Services;

use Rz\GoogleAPIClientBundle\Exception\ConfigManagerException;

class ConfigManager
{
    protected $configs;

    /**
     * Creates a CKEditor config manager.
     *
     * @param array $configs The CKEditor configs.
     */
    public function __construct(array $configs = array())
    {
        $this->setConfigs($configs);
    }

    /**
     * {@inheritdoc}
     */
    public function hasConfigs()
    {
        return !empty($this->configs);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfigs(array $configs)
    {
        foreach ($configs as $name => $config) {
            $this->setConfig($name, $config);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasConfig($name)
    {
        return isset($this->configs[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($name)
    {
        if (!$this->hasConfig($name)) {
            throw ConfigManagerException::configDoesNotExist($name);
        }

        return $this->configs[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig($name, array $config)
    {
        $this->configs[$name] = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function hasConfigInConfigs($name, $config)
    {
        return isset($config[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigInConfigs($name, $config)
    {
        if ($this->hasConfigInConfigs($name, $config)) {
            return $config[$name];
        } else {
            return;
        }
    }

    public function getGoogleServices()
    {
        if (!$this->hasConfig('google_services')) {
            throw ConfigManagerException::configDoesNotExist('google_services');
        }

        return $this->getConfig('google_services');
    }

    public function getGoogleClientAPI()
    {
        if (!$this->hasConfig('client_api')) {
            throw ConfigManagerException::configDoesNotExist('client_api');
        }

        return $this->getConfig('client_api');
    }

    public function isGoogleClientAPIEnabled()
    {
        $clientAPI = $this->getGoogleClientAPI();
        if ($this->hasConfigInConfigs('enabled', $clientAPI)) {
            return $this->getConfigInConfigs('enabled', $clientAPI);
        } else {
            return;
        }
    }

    ###
    #  google_services.analytics
    ###

    public function getGoogleServicesAnalytics()
    {
        $clientAPI = $this->getGoogleServices();
        if ($this->hasConfigInConfigs('analytics', $clientAPI)) {
            return $this->getConfigInConfigs('analytics', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleServicesAnalyticsEnabled()
    {
        $clientAPI = $this->getGoogleServicesAnalytics();
        if ($this->hasConfigInConfigs('enabled', $clientAPI)) {
            return $this->getConfigInConfigs('enabled', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleServicesAnalyticsTrackingId()
    {
        $clientAPI = $this->getGoogleServicesAnalytics();
        if ($this->hasConfigInConfigs('tracking_id', $clientAPI)) {
            return $this->getConfigInConfigs('tracking_id', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleServicesAnalyticsTrackerName()
    {
        $clientAPI = $this->getGoogleServicesAnalytics();
        if ($this->hasConfigInConfigs('tracker_name', $clientAPI)) {
            return $this->getConfigInConfigs('tracker_name', $clientAPI);
        } else {
            return;
        }
    }

    ###
    #  google_services.tag_manager
    ###

    public function getGoogleServicesTagManager()
    {
        $clientAPI = $this->getGoogleServices();
        if ($this->hasConfigInConfigs('tag_manager', $clientAPI)) {
            return $this->getConfigInConfigs('tag_manager', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleServicesTagManagerEnabled()
    {
        $clientAPI = $this->getGoogleServicesTagManager();
        if ($this->hasConfigInConfigs('enabled', $clientAPI)) {
            return $this->getConfigInConfigs('enabled', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleServicesTagManagerGTMId()
    {
        $clientAPI = $this->getGoogleServicesTagManager();
        if ($this->hasConfigInConfigs('gtm_id', $clientAPI)) {
            return $this->getConfigInConfigs('gtm_id', $clientAPI);
        } else {
            return;
        }
    }


    ###
    #  client_api.service
    ###
    public function getGoogleClientServiceAPI()
    {
        $clientAPI = $this->getGoogleClientAPI();
        if ($this->hasConfigInConfigs('service', $clientAPI)) {
            return $this->getConfigInConfigs('service', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientServiceAPIAppName()
    {
        $clientAPI = $this->getGoogleClientServiceAPI();
        if ($this->hasConfigInConfigs('app_name', $clientAPI)) {
            return $this->getConfigInConfigs('app_name', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientServiceAPIClientId()
    {
        $clientAPI = $this->getGoogleClientServiceAPI();
        if ($this->hasConfigInConfigs('client_id', $clientAPI)) {
            return $this->getConfigInConfigs('client_id', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientServiceAPIClientEmail()
    {
        $clientAPI = $this->getGoogleClientServiceAPI();
        if ($this->hasConfigInConfigs('client_email', $clientAPI)) {
            return $this->getConfigInConfigs('client_email', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientServiceAPICertificateFingerprint()
    {
        $clientAPI = $this->getGoogleClientServiceAPI();
        if ($this->hasConfigInConfigs('certificate_fingerprint', $clientAPI)) {
            return $this->getConfigInConfigs('certificate_fingerprint', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientServiceAPICertificateP12()
    {
        $clientAPI = $this->getGoogleClientServiceAPI();
        if ($this->hasConfigInConfigs('certificate_p12', $clientAPI)) {
            return $this->getConfigInConfigs('certificate_p12', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientServiceAPICertificateKey()
    {
        $clientAPI = $this->getGoogleClientServiceAPI();
        if ($this->hasConfigInConfigs('certificate_key', $clientAPI)) {
            return $this->getConfigInConfigs('certificate_key', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientServiceAPICertificatePassword()
    {
        $clientAPI = $this->getGoogleClientServiceAPI();
        if ($this->hasConfigInConfigs('certificate_password', $clientAPI)) {
            return $this->getConfigInConfigs('certificate_password', $clientAPI);
        } else {
            return;
        }
    }

    ###
    #  client_api.web_app
    ###
    public function getGoogleClientWebAppAPI()
    {
        $clientAPI = $this->getGoogleClientAPI();
        if ($this->hasConfigInConfigs('web_app', $clientAPI)) {
            return $this->getConfigInConfigs('web_app', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientWebAppAPIClientId()
    {
        $clientAPI = $this->getGoogleClientWebAppAPI();
        if ($this->hasConfigInConfigs('client_id', $clientAPI)) {
            return $this->getConfigInConfigs('client_id', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientWebAppAPIClientSecret()
    {
        $clientAPI = $this->getGoogleClientWebAppAPI();
        if ($this->hasConfigInConfigs('client_secret', $clientAPI)) {
            return $this->getConfigInConfigs('client_secret', $clientAPI);
        } else {
            return;
        }
    }

    ###
    #  client_api.public
    ###
    public function getGoogleClientPublicAPI()
    {
        $clientAPI = $this->getGoogleClientAPI();
        if ($this->hasConfigInConfigs('public', $clientAPI)) {
            return $this->getConfigInConfigs('public', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientPublicAPIAppName()
    {
        $clientAPI = $this->getGoogleClientPublicAPI();
        if ($this->hasConfigInConfigs('app_name', $clientAPI)) {
            return $this->getConfigInConfigs('app_name', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientPublicAPIKey()
    {
        $clientAPI = $this->getGoogleClientPublicAPI();
        if ($this->hasConfigInConfigs('api_key', $clientAPI)) {
            return $this->getConfigInConfigs('api_key', $clientAPI);
        } else {
            return;
        }
    }

    public function getGoogleClientPublicAPISiteName()
    {
        $clientAPI = $this->getGoogleClientPublicAPI();
        if ($this->hasConfigInConfigs('site_name', $clientAPI)) {
            return $this->getConfigInConfigs('site_name', $clientAPI);
        } else {
            return;
        }
    }
}
