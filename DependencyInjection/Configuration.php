<?php

namespace SwooleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $tb = new TreeBuilder('swoole');

        $tb->getRootNode()
            ->children()
                ->arrayNode('server')
                    ->children()
                        ->scalarNode('host')->defaultValue('localhost')->end()
                        ->scalarNode('port')->defaultValue('8080')->end()
                        ->arrayNode('config')->scalarPrototype()->end()
                    ->end()
                ->end()
            ->end();

        return $tb;
    }
}


?>