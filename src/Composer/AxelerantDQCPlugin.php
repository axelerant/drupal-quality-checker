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
        echo "AxelerantDQC: inside scriptEventAction - " . $event->getName() . '-' . $this->composer->getConfig()->get('vendor-dir')  . PHP_EOL;
        $this->copyFilesToProject();
    }

    /**
     * Copies files from plugin to the project where it's installed.
     */
    public function copyFilesToProject(): void
    {
        // Determine the destination directory in the project
        $destination = $this->locateProjectRoot();
        if ($destination === FALSE) {
            $this->io->writeError('Copying configuration file failed. Unable to determine project root dir. Please copy configuration files manually.');
            return;
        }
        $pluginDirectory = realpath(__DIR__ . '/../../');

        // Copy each file to the project
        copy($pluginDirectory . '/grumphp.yml.dist', $destination . '/grumphp.yml.dist');
        copy($pluginDirectory . '/phpcs.xml.dist', $destination . '/phpcs.xml.dist');
        copy($pluginDirectory . '/phpmd.xml.dist', $destination . '/phpmd.xml.dist');

        // Output message indicating the files are copied
        $this->io->write('Config file copied successfully!');
    }

    /**
     * Locate Project root path
     */
    public function locateProjectRoot(): string|bool {

        $paths = [
            getcwd(),
            dirname($this->composer->getConfig()->get('bin-dir'), 2),
            dirname($this->composer->getConfig()->get('vendor-dir'), 1),
        ];
        return $this->guessPath($paths, 'composer.json');
    }

    /**
     * Build path
     *
     * @param string $baseDir
     * @param string $path
     * @return string
     */
    public function buildPath(string $baseDir, string $path): string
    {
        return $baseDir.DIRECTORY_SEPARATOR.$path;
    }

    /**
     * Guess path using filename.
     *
     * @param array $paths
     * @param string $filename
     * @return string|bool
     */
    public function guessPath(array $paths, string $filename): string|bool
    {
        $paths = array_filter($paths);

        foreach ($paths as $path) {
            if (!is_dir($path)) {
                continue;
            }

            $filePath = $this->buildPath($path, $filename);
            if (file_exists($filePath)) {
                return $path;
            }
        }
        return FALSE;
    }

}
