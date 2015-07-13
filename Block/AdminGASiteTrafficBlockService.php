<?php

namespace Rz\GoogleAPIClientBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\CoreBundle\Model\ManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Rz\GoogleAPIClientBundle\Services\ConfigManager;
use Rz\GoogleAPIClientBundle\Services\GoogleServiceAnalytics;

class AdminGASiteTrafficBlockService extends BaseBlockService
{
    protected $client;
    protected $templates;
    protected $configManager;
    protected $analyticsService;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param ConfigManager $configManager
     */
    public function __construct($name, EngineInterface $templating, GoogleServiceAnalytics $analyticsService)
    {
        $this->name       = $name;
        $this->templating = $templating;
        $this->analyticsService = $analyticsService;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $configManager = $this->analyticsService->getGClient()->getConfigManager();

        $client = $this->analyticsService->authenticate();
        $accessToken = json_decode($client->getAccessToken());

        $webApp = $configManager->getConfig('web_app');
        $clientId = $configManager->getConfigInConfigs('client_id', $webApp);

        $parameters = array(
            'context'   => $blockContext,
            'settings'  => $blockContext->getSettings(),
            'block'     => $blockContext->getBlock(),
            'clientId'  => $clientId,
            'access_token' => $accessToken->access_token
        );

        return $this->renderResponse($blockContext->getTemplate(), $parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('title', 'text', array('required' => false)),
                array('template', 'choice', array('choices' => $this->templates)),
                array('mode', 'choice', array(
                    'choices' => array(
                        'public' => 'public',
                        'admin'  => 'admin'
                    )
                )),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Admin Google Analytics';
    }

    /**
     * Define the default options for the block.
     *
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'title'      => 'Google Analytics - Site Traffic',
            'widgetCode' => null,
            'mode'       => 'admin',
            'template'   => 'RzGoogleAPIClientBundle:Block:admin_ga_site_traffic.html.twig'
        ));
    }

    /**
     * @return mixed
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * @param mixed $templates
     */
    public function setTemplates($templates)
    {
        $this->templates = $templates;
    }
}
