<?php

namespace Rz\GoogleAPIClientBundle\Twig\Extension;

use Rz\GoogleAPIClientBundle\Services\ConfigManager;

class GoogleServiceAnalyticsExtension extends \Twig_Extension
{
    protected $configManager;

    function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('rz_google_service_analytics_embed_api', array($this, 'gaEmbedAPI'), array('is_safe' => array('html')))
        );
    }

    public function gaEmbedAPI()
    {
        $system = $this->configManager->getConfig('system');
        if (!$this->configManager->hasConfigInConfigs('enabled',$system)) {
            return '<!-- RzGoogleAPIClient is disabled due to rz_google_api_client.settings.enabled=false in your configuration -->';
        }

        $gaEmbedAPI = <<<EOT
<!-- RzGoogleServiceAnalytics Embed API -->
<script type="text/javascript">
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!-- End RzGoogleServiceAnalytics Embed API -->
EOT;

        return $gaEmbedAPI;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'rz_google_service_analytics';
    }
}