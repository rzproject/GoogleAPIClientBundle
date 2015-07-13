<?php

namespace Rz\GoogleAPIClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzGoogleAPIClientExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('block.xml');
        $loader->load('twig.xml');
        $this->configureSettings($config, $container);
        $this->configureBlocks($config['blocks'], $container);
        $this->configureTwig($config['twig'], $container);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureSettings($config, ContainerBuilder $container)
    {
        #Public API Access
        $container->setParameter('rz_google_api_client.settings', $config['settings']);

        if (!empty($config['settings'])) {
            $definition = $container->getDefinition('rz_google_api_client.config_manager');
            foreach ($config['settings'] as $name => $configuration) {
                    $definition->addMethodCall('setConfig', array($name, $configuration));
            }
        }
    }


    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureBlocks($config, ContainerBuilder $container)
    {
        #google_service_analytics
        $container->setParameter('rz_google_api_client.twig_extension.admin_ga_site_traffic.class', $config['admin_ga_site_traffic']['class']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureTwig($config, ContainerBuilder $container)
    {
        #google_service_analytics
        $container->setParameter('rz_google_api_client.twig_extension.google_service_analytics.class', $config['google_service_analytics']['class']);
    }

}
