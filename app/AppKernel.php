<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),

            // THIRD PARTY
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Bmatzner\FontAwesomeBundle\BmatznerFontAwesomeBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Sentry\SentryBundle\SentryBundle(),
            new Oneup\FlysystemBundle\OneupFlysystemBundle(),
            new Facile\PaginatorBundle\FacilePaginatorBundle(),
            new Facile\MongoDbBundle\FacileMongoDbBundle(),

            // APP BUNDLES
            new AppBundle\AppBundle(),
            new UserBundle\UserBundle(),
            new TelegramBundle\TelegramBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Liip\FunctionalTestBundle\LiipFunctionalTestBundle();
            $bundles[] = new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        if (in_array($this->getEnvironment(), ['dev', 'build'], true)) {
            $bundles[] = new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
