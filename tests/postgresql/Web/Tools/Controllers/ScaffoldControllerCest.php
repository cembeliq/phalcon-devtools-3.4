<?php
declare(strict_types=1);

namespace Phalcon\DevTools\Tests\Acceptance\Web\Tools\Controllers;

use MySQLTester;

final class ScaffoldControllerCest
{
    /**
     * @covers \Phalcon\Devtools\Web\Tools\Controllers\ScaffoldController::generateAction
     *
     * @param MySQLTester $I
     */
    public function testEnterGenerateAction(MySQLTester $I): void
    {
        $I->amOnPage('/webtools.php/scaffold/generate');
        $I->see('Scaffold');
        $I->see('Generate code from template');
    }

    public function testGenerateAction(MySQLTester $I): void
    {
        $namespace = 'Test\WebTools';

        /**
         * Generate Models
         */
        $I->amOnPage('/webtools.php/models/generate');

        $modelsDir = $I->grabValueFrom('#modelsDir');
        remove_dir($modelsDir);

        $I->fillField('namespace', $namespace);
        $I->checkOption('#force');
        $I->click('input[type=submit]');

        /**
         * Generate rest of files
         */
        $I->amOnPage('/webtools.php/scaffold/generate');

        $I->fillField('modelsNamespace', $namespace);
        $I->checkOption('#force');
        $I->click('input[type=submit]');
        $I->see('Migrations');
        $I->see('All migrations that we managed to find');

        remove_dir($modelsDir);
    }
}
