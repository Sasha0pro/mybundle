<?php

namespace PassGeneratorBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PassGeneratorExtension extends Extension
{

    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__).'/config')
        );
        $loader->load('services.yaml');

        $configuration = $this->getConfiguration($configs, $container);

        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('pgb.password_generator');

        $definition->setArgument('$length', $config['passwordLength']);
    }

    public function getAlias(): string
    {
        return 'password_generator';
    }
}