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
            new \Twig_SimpleFunction('rz_google_service_analytics_embed_api', array($this, 'gaEmbedAPI'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('rz_google_analytics_tracking_code', array($this, 'gAnalyticsTrackingCode'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('rz_google_analytics_page_view', array($this, 'gAnalyticsPageView'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('rz_google_analytics_page_view_custom', array($this, 'gAnalyticsPageViewCustom'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('rz_google_tag_manager_code', array($this, 'gATagManagerCode'), array('is_safe' => array('html')))
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

    public function gAnalyticsTrackingCode()
    {
        $ga = $this->configManager->getConfig('google_services');
        $analyticsSettings = $this->configManager->getConfigInConfigs('analytics',$ga);

        if (!$analyticsSettings && !$analyticsSettings['enabled']) {
            return '<!-- Google Analytics tracking is disabled due to rz_google_api_client.settings.google_services.analytics.enabled=false in your configuration -->';
        }

        $gaTrackingCode = <<<EOT
<!-- Google Analytics Code -->
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','rz_google_analytics_tracking_code_tracker_name');

rz_google_analytics_tracking_code_tracker_name('create', 'rz_google_analytics_tracking_code', 'auto');
</script>
<!-- Google Analytics Code -->
EOT;

        if($analyticsSettings['tracker_name']) {
            $gaTrackingCode = str_replace('rz_google_analytics_tracking_code_tracker_name', $analyticsSettings['tracker_name'], $gaTrackingCode);
        }

        return str_replace('rz_google_analytics_tracking_code', $analyticsSettings['tracking_id'], $gaTrackingCode);
    }

    public function gAnalyticsPageView()
    {
        $ga = $this->configManager->getConfig('google_services');
        $analyticsSettings = $this->configManager->getConfigInConfigs('analytics',$ga);

        if (!$analyticsSettings && !$analyticsSettings['enabled']) {
            return '<!-- Google Analytics tracking is disabled due to rz_google_api_client.settings.google_services.analytics.enabled=false in your configuration -->';
        }

            $gaTrackingCode = <<<EOT
<!-- Google Analytics Event -->
<script type="text/javascript">
rz_google_analytics_tracking_code_tracker_name('send', 'pageview');
</script>
<!-- Google Analytics Event -->
EOT;

        if($analyticsSettings['tracker_name']) {
            $gaTrackingCode = str_replace('rz_google_analytics_tracking_code_tracker_name', $analyticsSettings['tracker_name'], $gaTrackingCode);
        }

        return $gaTrackingCode;
    }

    public function gAnalyticsPageViewCustom($settings = array())
    {
        $ga = $this->configManager->getConfig('google_services');
        $analyticsSettings = $this->configManager->getConfigInConfigs('analytics',$ga);

        if (!$analyticsSettings && !$analyticsSettings['enabled']) {
            return '<!-- Google Analytics tracking is disabled due to rz_google_api_client.settings.google_services.analytics.enabled=false in your configuration -->';
        }
        if(isset($settings)) {
            $gaTrackingCode = <<<EOT
<!-- Google Analytics Event -->
<script type="text/javascript">
rz_google_analytics_tracking_code_tracker_name('send', 'pageview', {'page': 'rz_google_analytics_tracking_code_tracker_page'});
</script>
<!-- Google Analytics Event -->
EOT;
        } else {
            $gaTrackingCode = <<<EOT
<!-- Google Analytics Event -->
<script type="text/javascript">
rz_google_analytics_tracking_code_tracker_name('send', 'pageview');
</script>
<!-- Google Analytics Event -->
EOT;
        }


        if($analyticsSettings['tracker_name']) {
            $gaTrackingCode = str_replace('rz_google_analytics_tracking_code_tracker_name', $analyticsSettings['tracker_name'], $gaTrackingCode);
        }

        if(isset($settings) && isset($settings['page'])) {
            $gaTrackingCode = str_replace('rz_google_analytics_tracking_code_tracker_page', $settings['page'], $gaTrackingCode);
        }

        return $gaTrackingCode;
    }

    public function gATagManagerCode()
    {
        $gtm = $this->configManager->getConfig('google_services');
        $gtmSettings = $this->configManager->getConfigInConfigs('tag_manager',$gtm);

        if (!$gtmSettings && !$gtmSettings['enabled']) {
            return '<!-- Google Tag Manager is disabled due to rz_google_api_client.settings.google_services.tag_manager.enabled=false in your configuration -->';
        }

        $gtmCode = <<<EOT
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=rz_google_tag_manager_code" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script type="text/javascript">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','rz_google_tag_manager_code');
</script>
<!-- End Google Tag Manager -->
EOT;

        return str_replace('rz_google_tag_manager_code', $gtmSettings['gtm_id'], $gtmCode);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'rz_google_service_analytics';
    }
}