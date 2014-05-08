<?php

namespace Netgusto\DynamicSubdomainBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('netgusto_dynamic_subdomain');

        $rootNode
            ->children()
                ->scalarNode('base_host')
                    ->isRequired()
                    ->info('The domain base host, where all subdomains are attached')
                    ->example('netgusto.com')
                ->end()
                ->scalarNode('parameter_name')
                    ->info('The name of the parameter that will be set on the current Request')
                    ->treatNullLike('subdomain')
                    ->defaultValue('subdomain')
                ->end()
                ->scalarNode('entity')
                    ->isRequired()
                    ->info('The class or Doctrine alias of the entity mapped to subdomains')
                    ->example('Acme\DemoBundle\Entity\MySite')
                ->end()
                ->scalarNode('property')
                    ->info('The name of the property storing the subdomain name in your entity')
                    ->treatNullLike('subdomain')
                    ->defaultValue('subdomain')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
