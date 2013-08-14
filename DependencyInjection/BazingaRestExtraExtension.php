<?php

/**
 * This file is part of the RestExtraBundle package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Bazinga\Bundle\RestExtraBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class BazingaRestExtraExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!empty($config['link_request_listener'])) {
            $loader->load('link_request_listener.xml');
        }

        if (!empty($config['version_listener']) && true === $config['version_listener']['enabled']) {
            $loader->load('version_listener.xml');

            $container->getDefinition('bazinga_rest_extra.event_listener.version')
                ->replaceArgument(1, $config['version_listener']['attribute_name'])
                ->replaceArgument(2, $config['version_listener']['parameter_name'])
                ->replaceArgument(3, $config['version_listener']['default_version'])
                ;
        }
    }
}
