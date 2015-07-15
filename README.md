GoogleAPIClientBundle
=====================
The GoogleBundle adds the ability to add various Google services to your application.
Currently Implemented: Google Analytics, Google Tag Manager and Client API

**STABLE VERSION**

Installation
============

Add the following to your composer.json file:

```json

    {
        "require": {
            "rz/google-api-client-bundle" : "1.0.*"
        }
    }
    
```

Install the libraries by running:

```bash

    composer install

```

If everything worked, the Google Bundle can now be found at vendor/rz/google-api-client-bundle.

Finally, be sure to enable the bundle in AppKernel.php by including the following:

```php

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            //...
            new Rz\GoogleAPIClientBundle\RzGoogleAPIClientBundle(),
        );
    }
    
```

Configuration
=============

Google Analytics

```yaml

    rz_google_api_client:
      settings:
        google_services:
          ################
          # Sample Analytics Code replace with you own tracking code
          ################
          analytics:
            enabled: true
            tracking_id: UA-XXXXXXXX-X
            tracker_name: __rz_gaTracker
          ################
          # Sample GTM Code replace with you own tracking code
          ################
          tag_manager:
            enabled: true
            gtm_id: GTM-XXXXXX
    
        ################
        # Google Client API
        ################
        client_api:
          ################
          # Google Client API Public API
          ################
          public:
            app_name: rz-cms-XXXXXX
            api_key: ~
            site_name: rz-cms
          ################
          # Google Client API Service Account
          ################
          service:
            app_name: ~
            client_id: ~
            client_email: ~
            certificate_fingerprint: ~
            certificate_key: %kernel.root_dir%/config/rmzamora/rz/google_api_key/YOUR_KEY_HERE.json
            certificate_p12: %kernel.root_dir%/config/rmzamora/rz/google_api_key/YOUR_KEY_HERE.p12
            certificate_password: XXXXXXXX
          ################
          # Google Client API Web Application
          ################
          web_app:
            client_id: ~
            client_secret: ~

```

#### View Twig Helper

google analytics tracking code:

    {{ rz_google_analytics_tracking_code() }}
    
google analytics event ie:pageview:

    {{ rz_google_analytics_page_view() }}  
    
google analytics custom event ie:pageview with paramters:

    {{ rz_google_analytics_page_view_custom({'page': /MY_PAGE_URL}) }}

google analytics dashboard requires RzBlockBundle and RzAdminBundle:
    
    {{ rz_google_service_analytics_embed_api() }} //embed code required to use Analytics EmbedAPI
    
    # SHOW YOUR SITE ANALYTICS on YOUR SonataAdmin Dashbaord - sonata_admin.yml
    dashboard:
        blocks:
            - { position: top, type: rz_google_api_client.block.admin_ga_site_traffic, settings: { mode: admin, title: Google Analytics } }
            
    # Register Block under sonata_block.yml           
    rz_google_api_client.block.admin_ga_site_traffic:
        contexts: [admin]
        
--------------
### screenshot
--------------
![Alt text](https://raw.githubusercontent.com/rzproject/cms-sandbox/1.3/app/Resources/docs/screenshots/rz-cms-sandbox-dashboard-001.jpg)

Back to: [rzproject](http://rzproject.github.io)