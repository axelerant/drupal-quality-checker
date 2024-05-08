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
        echo "AxelerantDQC: inside activate" . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(Composer $composer, IOInterface $io): void
    {
      echo "AxelerantDQC: inside de-activate" . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(Composer $composer, IOInterface $io): void
    {
      echo "AxelerantDQC: inside uninstall" . PHP_EOL;
    }

    /**
     * Attach package installation events:.
     *
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => ['scriptEventAction', 10],
            ScriptEvents::POST_UPDATE_CMD => ['scriptEventAction', 10],
        ];
    }

    /**
     * Attach script installation events.
     *
     * {@inheritdoc}
     */
    public function scriptEventAction(Event $event): void
    {
        echo "AxelerantDQC: inside scriptEventAction - " . $event->getName() . '-' . $event->getComposer()->getInstallationManager()->getInstallPath($this->composer->getPackage())  . PHP_EOL;
        $this->copyFilesToProject();
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
        $this->io->write('Config file copied successfully!');
    }

}
