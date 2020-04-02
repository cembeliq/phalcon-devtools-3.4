<?php
declare(strict_types=1);

namespace Phalcon\DevTools\Tests\Acceptance\Web\Tools\Controllers;

use MySQLTester;

final class ControllersControllerCest
{
    /**
     * @covers \Phalcon\Devtools\Web\Tools\Controllers\ControllersController::indexAction
     *
     * @param MySQLTester $I
     */
    public function testIndexAction(MySQLTester $I): void
    {
        $I->amOnPage('/webtools.php/controllers/list');
        $I->see('Controllers List');
        $I->see('All controllers that we managed to find');
    }

    /**
     * @covers \Phalcon\Devtools\Web\Tools\Controllers\ControllersController::generateAction
     *
     * @param MySQLTester $I
     */
    public function testGenerateAction(MySQLTester $I): void
    {
        $I->amOnPage('/webtools.php/controllers/generate');
        $I->see('Controllers');
        $I->see('Generate Controller');
    }

    /**
     * @covers \Phalcon\Devtools\Web\Tools\Controllers\ControllersController::generateAction
     *
     * @param MySQLTester $I
     */
    public function testSubmitGenerateAction(MySQLTester $I): void
    {
        $controllerName = 'TestControllerName';
        $withPrefixControllerName = $controllerName . 'Controller';

        $I->amOnPage('/webtools.php/controllers/generate');
        $I->fillField('name', $controllerName);
        $I->fillField('namespace', 'Test\WebTools');
        $I->click('.form-horizontal input[type=submit]');
        $I->see('All controllers that we managed to find');
        $I->see($withPrefixControllerName);
        $I->see('Controller "' . $withPrefixControllerName . '" was created successfully');
    }

    /**
     * @covers \Phalcon\Devtools\Web\Tools\Controllers\ControllersController::editAction
     *
     * @param MySQLTester $I
     */
    public function testEditAction(MySQLTester $I): void
    {
        $controllerName = 'TestControllerName';
        $newCode = '<?php echo "test";';

        /**
         * Generate Controller
         */
        $I->amOnPage('/webtools.php/controllers/generate');
        $I->fillField('name', $controllerName);
        $I->fillField('namespace', 'Test\WebTools');
        $I->click('.form-horizontal input[type=submit]');
        $I->see('All controllers that we managed to find');
        $I->see($controllerName . 'Controller');

        /**
         * Enter to edit Controller Page
         */
        $I->click("//a[contains(@href, \"$controllerName\")]");
        $I->see($controllerName . 'Controller.php');
        $I->see('class ' . $controllerName . 'Controller extends');

        /**
         * Edit contents of Controller
         */
        $I->fillField('code', $newCode);
        $I->click('form input[type=submit]');
        $I->see('The controller "' . $controllerName . 'Controller" was saved successfully.');

        /**
         * Check if contents was saved
         */
        $I->click("//a[contains(@href, \"$controllerName\")]");
        $I->see($controllerName . 'Controller.php');
        $I->see($newCode);
    }
}
