<?php

namespace Rz\GoogleAPIClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rz_google_api_client');
        $this->addServicesSection($rootNode);
        $this->addBlockSettings($rootNode);
        $this->addTwigSettings($rootNode);
        return $treeBuilder;
    }

    /**
     * Add the service section
     *
     * @param ArrayNodeDefinition $rootNode
     *
     */
    private function addServicesSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode->children()
                ->arrayNode('settings')
                    ->children()
                        ->arrayNode('google_services')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('analytics')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('enabled')->defaultValue(true)->end()
                                        ->scalarNode('tracking_id')->end()
                                        ->scalarNode('tracker_name')->defaultValue('__rz_gaTracker')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('tag_manager')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('enabled')->defaultValue(true)->end()
                                        ->scalarNode('gtm_id')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('client_api')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('enabled')->defaultValue(true)->end()
                                ->arrayNode('web_app')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('client_id')->end()
                                        ->scalarNode('client_secret')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('service')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('app_name')->end()
                                        ->scalarNode('client_id')->end()
                                        ->scalarNode('client_email')->end()
                                        ->scalarNode('certificate_fingerprint')->end()
                                        ->scalarNode('certificate_key')->end()
                                        ->scalarNode('certificate_p12')->end()
                                        ->scalarNode('certificate_password')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('public')
                                    ->children()
                                        ->scalarNode('app_name')->end()
                                        ->scalarNode('api_key')->end()
                                        ->scalarNode('site_name')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        ;
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addBlockSettings(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('blocks')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('admin_ga_site_traffic')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('Rz\\GoogleAPIClientBundle\\Block\\AdminGASiteTrafficBlockService')->end()
                                ->arrayNode('templates')
                                    ->useAttributeAsKey('id')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('name')->defaultValue('default')->end()
                                            ->scalarNode('path')->defaultValue('RzGoogleAPIClientBundle:Block:admin_ga_site_traffic.html.twig')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addTwigSettings(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('twig')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('google_service_analytics')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('Rz\\GoogleAPIClientBundle\\Twig\\Extension\\GoogleServiceAnalyticsExtension')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
