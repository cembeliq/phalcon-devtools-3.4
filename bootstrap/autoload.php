<?php

/**
 * This file is part of the Phalcon Developer Tools.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Phalcon\Loader;
use Phalcon\Version;

if (!extension_loaded('phalcon')) {
    throw new Exception(
        "Phalcon extension isn't installed, follow these instructions to install it: " .
        'https://docs.phalconphp.com/en/latest/installation'
    );
}

/**
 * @const DEVTOOLS_START_TIME The start time of the Devtools. Used for profiling.
 */
defined('DEVTOOLS_START_TIME') || define('DEVTOOLS_START_TIME', microtime(true));

/**
 * @const DEVTOOLS_START_MEMORY The memory usage at the start of the application. Used for profiling.
 */
defined('DEVTOOLS_START_MEMORY') || define('DEVTOOLS_START_MEMORY', memory_get_usage());

/**
 * @const PTOOLSPATH The path to the Phalcon Developers Tools.
 */
defined('PTOOLSPATH') || define('PTOOLSPATH', rtrim(trim(getenv('PTOOLSPATH'), '\"\'') ?: dirname(dirname(__FILE__)), '\\/'));

/**
 * Check for old versions
 */
if (rtrim(strtolower(realpath(PTOOLSPATH)), '\\/') !== rtrim(strtolower(realpath(dirname(dirname(__FILE__)))), '\\/')) {
    throw new Exception(
        sprintf(
            'The environment variable PTOOLSPATH is outdated! Current value: %s. New value: %s',
            PTOOLSPATH,
            dirname(dirname(__FILE__))
        )
    );
}

/**
 * @const DS The DIRECTORY_SEPARATOR shortcut.
 */
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

/**
 * @const TEMPLATE_PATH DevTools templates path.
 */
defined('TEMPLATE_PATH') || define('TEMPLATE_PATH', PTOOLSPATH . DS .'templates');

/**
 * @const ENV_PRODUCTION Application production stage.
 */
defined('ENV_PRODUCTION') || define('ENV_PRODUCTION', 'production');

/**
 * @const ENV_STAGING Application staging stage.
 */
defined('ENV_STAGING') || define('ENV_STAGING', 'staging');

/**
 * @const ENV_DEVELOPMENT Application development stage.
 */
defined('ENV_DEVELOPMENT') || define('ENV_DEVELOPMENT', 'development');

/**
 * @const ENV_TESTING Application test stage.
 */
defined('ENV_TESTING') || define('ENV_TESTING', 'testing');

/**
 * @const APPLICATION_ENV Current application stage.
 */
defined('APPLICATION_ENV') || define('APPLICATION_ENV', getenv('APP_ENV') ?: ENV_DEVELOPMENT);

/**
 * @const HOSTNAME The current hostname.
 */
defined('HOSTNAME') || define('HOSTNAME', explode('.', gethostname())[0]);

/**
 * @const ADMIN_LTE_VERSION The AdminLTE version.
 */
defined('ADMIN_LTE_VERSION') || define('ADMIN_LTE_VERSION', '2.3.6');

/** @const COMPATIBLE_VERSION The compatible Phalcon version. */
defined('COMPATIBLE_VERSION') || define('COMPATIBLE_VERSION', 3020040);

/**
 * Register Devtools classes.
 */
(new Loader)->registerDirs([
        PTOOLSPATH . DS . 'scripts' . DS
    ])
    ->registerNamespaces([
        'Phalcon'              => PTOOLSPATH . DS . 'scripts' . DS . 'Phalcon' . DS,
        'WebTools\Controllers' => PTOOLSPATH . DS . str_replace('/', DS, 'scripts/Phalcon/Web/Tools/Controllers') . DS,
    ])
    ->register();

/**
 * Register the Composer autoloader (if any)
 */
if (file_exists(PTOOLSPATH . DS .'vendor' . DS . 'autoload.php')) {
    require_once PTOOLSPATH . DS .'vendor' . DS . 'autoload.php';
}

/**
 * Register the custom loader (if any)
 */
if (file_exists('.phalcon' . DS . 'autoload.php')) {
    require_once '.phalcon' . DS . 'autoload.php';
}

if (Version::getId() < COMPATIBLE_VERSION) {
    throw new Exception(
        "Your Phalcon version isn't compatible with Developer Tools, " .
        'download the latest at: https://phalconphp.com/en/download/linux'
    );
}
