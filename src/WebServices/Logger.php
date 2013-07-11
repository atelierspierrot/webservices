<?php
/**
 * WebServices - PHP package
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/webservices>
 */
namespace WebServices;

use Library\Logger as BaseLogger;

/**
 * Write some log infos in log files
 *
 * For compliance, this class implements the [PSR Logger Interface](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).
 *
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class Logger extends BaseLogger
{

    public static function getOptions()
    {
        return self::$config;
    }

}

// Endfile