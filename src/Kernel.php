<?php

namespace App;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends BaseKernel
{
    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        // Ajoute ici tes propres définitions de services ou extensions
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->setParameter('container.dumper.inline_class_loader', true);
        $container->setParameter('container.dumper.inline_factories', true);

        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*.yaml', 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/*.yaml', 'glob');
        $loader->load($confDir.'/{services}.yaml', 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.'.yaml', 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/*.yaml', '/', 'glob');
        $routes->import($confDir.'/{routes}/'.$this->environment.'/*.yaml', '/', 'glob');
    }

    // Add this method to implement the abstract method from BaseKernel
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*.yaml', 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/*.yaml', 'glob');
        $loader->load($confDir.'/{services}.yaml', 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.'.yaml', 'glob');
    }
}
