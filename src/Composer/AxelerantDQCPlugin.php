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
     * Copies files from plugin to the project where it's installed.
     */
    public function copyFilesToProjectRoot(Event $event): void
    {
        $destination = $this->locateProjectRoot();
        if ($destination === FALSE) {
            $this->io->writeError('<fg=red>Copying configuration file failed. Unable to determine project root dir. Please copy configuration files manually.</fg=red>');
            return;
        }
        $pluginDirectory = realpath(__DIR__ . '/../../');

        // Copy each file to the project root.
        copy($pluginDirectory . '/grumphp.yml.dist', $destination . '/grumphp.yml.dist');
        copy($pluginDirectory . '/phpcs.xml.dist', $destination . '/phpcs.xml.dist');
        copy($pluginDirectory . '/phpmd.xml.dist', $destination . '/phpmd.xml.dist');
        copy($pluginDirectory . '/phpstan.neon.dist', $destination . '/phpstan.neon.dist');

        // Output message indicating the files are copied with warning if exists.
        if (file_exists($destination . '/grumphp.yml.dist')) {
            $this->io->write('<fg=yellow>Configuration files are overwritten. Please watchout for any changes!</fg=yellow>');
        }
        else {
            $this->io->write('<fg=green>Configuration files are copies successfully.</fg=green>');
        }
    }

    /**
     * Locate Project root path.
     */
    private function locateProjectRoot(): string|bool {
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
    private function buildPath(string $baseDir, string $path): string
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
    private function guessPath(array $paths, string $filename): string|bool
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
