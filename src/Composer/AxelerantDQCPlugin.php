<?php

declare(strict_types=1);

namespace AxelerantDQC\Composer;

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\DependencyResolver\Operation\OperationInterface;
use Composer\DependencyResolver\Operation\UninstallOperation;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

/**
 * @psalm-suppress MissingConstructor
 */
class AxelerantDQCPlugin implements PluginInterface, EventSubscriberInterface
{
    private const PACKAGE_NAME = 'phpro/grumphp';
    private const APP_NAME = 'grumphp';
    private const COMMAND_CONFIGURE = 'configure';
    private const COMMAND_INIT = 'git:init';
    private const COMMAND_DEINIT = 'git:deinit';

    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var IOInterface
     */
    private $io;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;
        echo "AxelerantDQC: inside activate";
        $this->copyFilesToProject();
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(Composer $composer, IOInterface $io): void
    {
      echo "AxelerantDQC: inside de-activate";
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(Composer $composer, IOInterface $io): void
    {
      echo "AxelerantDQC: inside uninstall";
    }

    /**
     * Attach package installation events:.
     *
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            PackageEvents::PRE_PACKAGE_INSTALL => ['detectGrumphpAction', 10],
            PackageEvents::POST_PACKAGE_INSTALL => ['detectGrumphpAction', 10],
            PackageEvents::PRE_PACKAGE_UPDATE => ['detectGrumphpAction', 10],
            PackageEvents::PRE_PACKAGE_UNINSTALL => ['detectGrumphpAction', 10],
            ScriptEvents::POST_INSTALL_CMD => ['detectGrumphpAction', 10],
            ScriptEvents::POST_UPDATE_CMD => ['detectGrumphpAction', 10],
        ];
    }

    /**
     * This method can be called by pre/post package events;
     * We make sure to only run it once. This way Grumphp won't execute multiple times.
     * The goal is to run it as fast as possible.
     * For first install, this should also happen on POST install (because otherwise the plugin doesn't exist yet)
     */
    public function detectGrumphpAction(PackageEvent $event): void
    {
        echo "AxelerantDQC: inside detectGrumphpAction - " . $event->getName();
    }

     /**
     * Copies files from plugin to the project where it's installed.
     */
    public function copyFilesToProject(): void
    {
        // Determine the destination directory in the project
        $destination = getcwd();

        // Copy each file to the project
        copy(__DIR__ . '/../../grumphp.yml.dist', $destination . '/grumphp.yml.dist');
        copy(__DIR__ . '/../../phpcs.xml.dist', $destination . '/phpcs.xml.dist');
        copy(__DIR__ . '/../../phpmd.xml.dist', $destination . '/phpmd.xml.dist');

        // Output message indicating the files are copied
        $this->io->write('Files copied to project.');
    }

}
