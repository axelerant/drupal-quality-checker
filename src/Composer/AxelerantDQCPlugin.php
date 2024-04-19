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
     * @var bool
     */
    private $handledPackageEvent = false;

    /**
     * @var bool
     */
    private $configureScheduled = false;

    /**
     * @var bool
     */
    private $initScheduled = false;

    /**
     * @var bool
     */
    private $hasBeenRemoved = false;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;
        echo "AxelerantDQC: inside activate";
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
            PackageEvents::PRE_PACKAGE_INSTALL => 'detectGrumphpAction',
            PackageEvents::POST_PACKAGE_INSTALL => 'detectGrumphpAction',
            PackageEvents::PRE_PACKAGE_UPDATE => 'detectGrumphpAction',
            PackageEvents::PRE_PACKAGE_UNINSTALL => 'detectGrumphpAction',
            ScriptEvents::POST_INSTALL_CMD => 'runScheduledTasks',
            ScriptEvents::POST_UPDATE_CMD => 'runScheduledTasks',
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
        echo "AxelerantDQC: inside detectGrumphpAction";
    }

    public function runScheduledTasks(Event $event): void
    {
      echo "AxelerantDQC: inside runScheduledTasks";
    }

}