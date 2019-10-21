<?php

/**
 * This file is part of the Phalcon Developer Tools.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Phalcon\Commands\Builtin\Serve;
use Phalcon\Commands\CommandsListener;
use Phalcon\Script;
use Phalcon\Events\Manager as EventsManager;

class ServeTest extends \Codeception\Test\Unit
{
    /**
     * @var Serve
     */
    protected $command;

    public function _before()
    {
        $eventsManager = new EventsManager();
        $eventsManager->attach('command', new CommandsListener());
        $script = new Script($eventsManager);
        $this->command = new Serve($script, $eventsManager);
        //$this->command->activateTestMode();
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testDefaultValuesWithNoParameters()
    {
        $_SERVER['argv'] = ['','', null];
        $this->command->parseParameters();
        $this->command->prepareOptions();

        $this->assertEquals('0.0.0.0', $this->command->getHostname());
        $this->assertEquals('8000', $this->command->getPort());
        $this->assertEquals('.htrouter.php', $this->command->getBasePath());
        $this->assertEquals('public', $this->command->getDocumentRoot());
        $this->assertEmpty($this->command->getConfigPath());
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testGeneratedCommandWithNoParameters()
    {
        $_SERVER['argv'] = ['',''];
        $this->command->parseParameters();
        $command = $this->command->shellCommand();
        $this->assertStringContainsString(PHP_BINARY . ' -S 0.0.0.0:8000 -t .htrouter.php -t public', $command);
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * hostname is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testDefaultValuesWithHostnameOnly()
    {
        $_SERVER['argv'] = ['', '', 'localhost'];
        $this->command->parseParameters();
        $this->command->prepareOptions();

        $this->assertEquals('localhost', $this->command->getHostname());
        $this->assertEquals('8000', $this->command->getPort());
        $this->assertEquals('.htrouter.php', $this->command->getBasePath());
        $this->assertEquals('public', $this->command->getDocumentRoot());
        $this->assertEmpty($this->command->getConfigPath());
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * hostname is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testGeneratedCommandWithHostnameOnly()
    {
        $_SERVER['argv'] = ['', '', 'localhost'];
        $this->command->parseParameters();
        $command = $this->command->shellCommand();
        $this->assertStringContainsString(PHP_BINARY . ' -S localhost:8000 -t .htrouter.php -t public', $command);
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * port is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testDefaultValuesWithPortOnly()
    {
        $_SERVER['argv'] = ['', '', null, 1111];
        $this->command->parseParameters();
        $this->command->prepareOptions();
        $this->assertEquals('0.0.0.0', $this->command->getHostname());
        $this->assertEquals('1111', $this->command->getPort());
        $this->assertEquals('.htrouter.php', $this->command->getBasePath());
        $this->assertEquals('public', $this->command->getDocumentRoot());
        $this->assertEmpty($this->command->getConfigPath());
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * port is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testGeneratedCommandWithPortOnly()
    {
        $_SERVER['argv'] = ['', '', null, 1111];
        $this->command->parseParameters();
        $command = $this->command->shellCommand();
        $this->assertStringContainsString(PHP_BINARY . ' -S 0.0.0.0:1111 -t .htrouter.php -t public', $command);
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * basepath is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testDefaultValuesWithBasepathOnly()
    {
        $_SERVER['argv'] = ['', '', null, null, '/root/bin.php'];
        $this->command->parseParameters();
        $this->command->prepareOptions();
        $this->assertEquals('0.0.0.0', $this->command->getHostname());
        $this->assertEquals('8000', $this->command->getPort());
        $this->assertEquals('/root/bin.php', $this->command->getBasePath());
        $this->assertEquals('public', $this->command->getDocumentRoot());
        $this->assertEmpty($this->command->getConfigPath());
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * basepath is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testGeneratedCommandWithBasepathOnly()
    {
        $_SERVER['argv'] = ['', '', null, null, '/root/bin.php'];
        $this->command->parseParameters();
        $command = $this->command->shellCommand();
        $this->assertStringContainsString(PHP_BINARY . ' -S 0.0.0.0:8000 -t /root/bin.php -t public', $command);
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * rootpath is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testDefaultValuesWithDocumentRootOnly()
    {
        $_SERVER['argv'] = ['', '', null, null, null, 'not_too_public'];
        $this->command->parseParameters();
        $this->command->prepareOptions();
        $this->assertEquals('0.0.0.0', $this->command->getHostname());
        $this->assertEquals('8000', $this->command->getPort());
        $this->assertEquals('.htrouter.php', $this->command->getBasePath());
        $this->assertEquals('not_too_public', $this->command->getDocumentRoot());
        $this->assertEmpty($this->command->getConfigPath());
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * rootpath is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testGeneratedCommandWithDocumentRootOnly()
    {
        $_SERVER['argv'] = ['', '', null, null, null, 'not_too_public'];
        $this->command->parseParameters();
        $command = $this->command->shellCommand();
        $this->assertStringContainsString(PHP_BINARY . ' -S 0.0.0.0:8000 -t .htrouter.php -t not_too_public', $command);
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * config is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testDefaultValuesWithConfigOnly()
    {
        $_SERVER['argv'] = ['', '', null, null, null, '--config=awesome.ini'];
        $this->command->parseParameters();
        $this->command->prepareOptions();
        $this->assertEquals('0.0.0.0', $this->command->getHostname());
        $this->assertEquals('8000', $this->command->getPort());
        $this->assertEquals('.htrouter.php', $this->command->getBasePath());
        $this->assertEquals('public', $this->command->getDocumentRoot());
        $this->assertEquals('-c awesome.ini', $this->command->getConfigPath());
    }

    /**
     * Verify that if no arguments are passed via the command line
     * this will provide a valid default configuration when only the
     * config is provided
     *
     * @author Paul Scarrone <paul@savvysoftworks.com>
     */
    public function testGeneratedCommandWithConfigOnly()
    {
        $_SERVER['argv'] = ['', '', null, null, null, '--config=awesome.ini'];
        $this->command->parseParameters();
        $command = $this->command->shellCommand();
        $this->assertStringContainsString(PHP_BINARY . ' -S 0.0.0.0:8000 -t .htrouter.php -t public -c awesome.ini', $command);
    }
}
