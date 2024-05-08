<?php

declare(strict_types=1);

namespace AxelerantDQC\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

/**
 * @psalm-suppress MissingConstructor
 */
class AxelerantDQCPlugin implements PluginInterface, EventSubscriberInterface
{
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
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(Composer $composer, IOInterface $io): void
    {

    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(Composer $composer, IOInterface $io): void
    {

    }

    /**
     * Attach package installation events. Priority of 10 is added to tigger it before GrumPHP plugin.
     *
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => ['copyFilesToProjectRoot', 10],
            ScriptEvents::POST_UPDATE_CMD => ['copyFilesToProjectRoot', 10],
        ];
    }

    /**
     * Copies files from plugin to the project root where it's installed.
     */
    public function copyFilesToProjectRoot(Event $event): void
    {
        // Determine the destination directory in the project
        $destination = getcwd();

        // Copy each file to the project
        copy(__DIR__ . '/../../grumphp.yml.dist', $destination . '/grumphp.yml.dist');
        copy(__DIR__ . '/../../phpcs.xml.dist', $destination . '/phpcs.xml.dist');
        copy(__DIR__ . '/../../phpmd.xml.dist', $destination . '/phpmd.xml.dist');
        copy(__DIR__ . '/../../phpstan.neon.dist', $destination . '/phpstan.neon.dist');

        // Output message indicating the files are copied
        $this->io->write('Config files copied successfully!');
    }

}
