<?php
declare(strict_types=1);

/**
 * This file is part of the Phalcon Developer Tools.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace WebTools\Controllers;

use Phalcon\Mvc\Controller\Base;

/**
 * \WebTools\Controllers\IndexController
 *
 * @package WebTools\Controllers
 */
class IndexController extends Base
{
    /**
     * Initialize controller
     */
    public function initialize()
    {
        parent::initialize();

        $this->view->setVar('page_title', 'Dashboard');
    }

    /**
     * @Get("/", name="dashboard")
     */
    public function indexAction()
    {
        $this->view->setVars(
            [
                'page_subtitle' => 'Control panel',
            ]
        );
    }
}
