<?php

namespace SwooleBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SwooleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('swoole.server.host', $config['server']['host'] ?? 'localhost');
        $container->setParameter('swoole.server.port', $config['server']['port'] ?? '8080');
        $container->setParameter('swoole.server.config', $config['server']['config'] ?? []);
    }

    public function getAlias(): string
    {
        return 'swoole';
    }
}

?>