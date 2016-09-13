<?php

namespace Tooly\Tests\Scrip\Processor;

use Composer\IO\ConsoleIO;
use Tooly\Factory\ToolFactory;
use Tooly\Script\Configuration;
use Tooly\Script\Helper;
use Tooly\Script\Helper\Filesystem;
use Tooly\Script\Processor;

/**
 * @package Tooly\Tests\Scrip\Processor
 */
class SymlinkTest extends \PHPUnit_Framework_TestCase
{
    private $io;

    private $helper;

    private $configuration;

    public function setUp()
    {
        $this->io = $this
            ->getMockBuilder(ConsoleIO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->helper = $this
            ->getMockBuilder(Helper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configuration = $this
            ->getMockBuilder(Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCanCreateASymlink()
    {
        $this->configuration
            ->expects($this->once())
            ->method('getComposerBinDirectory')
            ->willReturn('vendor/bin');

        $filesystem = $this
            ->getMockBuilder(Filesystem::class)
            ->getMock();

        $filesystem
            ->expects($this->once())
            ->method('symlinkFile');

        $this->helper
            ->expects($this->once())
            ->method('getFilesystem')
            ->willReturn($filesystem);

        $tool = ToolFactory::createTool('tool', __DIR__, []);

        $processor = new Processor($this->io, $this->helper, $this->configuration);
        $processor->symlink($tool);
    }
}
