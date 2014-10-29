<?php

namespace LOCKSSOMatic\PluginBundle\DependencyInjection;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class LOCKSSOMaticPluginExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // load all the plugins as services here.
        
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Plugins/'));

        // find the plugin.yml files in __DIR__ ../Plugins/*/plugin.yml
        // and load them.
        $directory = new RecursiveDirectoryIterator(__DIR__ . '/../Plugins');
        $flattened = new RecursiveIteratorIterator($directory);
        $ymlFiles = new RegexIterator($flattened, '/plugin\.yml$/');
        
        foreach($ymlFiles as $yml) {
            $loader->load($yml->getPath() . '/' . $yml->getFileName());
        }
        
    }
    
}
