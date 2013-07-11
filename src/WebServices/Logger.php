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

	/**
	 * Load the configuration infos
	 */
	private function init(array $user_options=array(), $logname = null)
	{
		if (defined('_LOGS')) $this->directory = _LOGS;
		$app_config = getContainer()->get('kernel')->getConfig('log', array(), true);
		$usr_config = getContainer()->get('kernel')->getConfig('log', array());
		$config = array_merge($app_config, $usr_config, $user_options);
		parent::init($config, $logname);
	}


	/**
	 * Get the log file path
	 *
	 * @param int $level The level of the current log info (default is 100)
	 * @return string The absolute path of the logfile to write in
	 */
	protected function getFilePath($level = 100)
	{
		return _ROOTDIR.rtrim($this->directory, '/').'/'.$this->getFileName($level)
			.( defined('_APP_MODE') && _APP_MODE!='prod' ? '_'._APP_MODE : '' )
			.'.'.trim($this->logfile_extension, '.');
	}

}

/*
class TestClass
{
    var $msg;
    function __construct( $str )
    {
        $this->msg = $str;
    }
    function __toString()
    {
        return $this->msg;
    }
}

// test of global logger
$logger = getContainer()->get('logger');
var_export($logger);

// write a simple log
$ok = getContainer()->get('logger')->log($logger::DEBUG, 'my message');
var_export($ok);

// write a log message with placeholders
$ok = getContainer()->get('logger')->log($logger::DEBUG, 'my message with placeholders : {one} and {two}', array(
    'one' => 'my value for first placeholder',
    'two' => new TestClass( 'my test class with a toString method' )
));
var_export($ok);

// write logs in a specific "test" file
$ok = getContainer()->get('logger')->log($logger::DEBUG, 'my message', array(), 'test');
var_export($ok);

// write many logs
for ($i=0; $i<1000; $i++)
{
    $ok = getContainer()->get('logger')->log( \App\Logger::DEBUG, '[from ?] a simple message qsmldkf jfqksmldkfjqmlskdf jmlqksjmdlfkj jKMlkjqmlsdkjf ' );
    $ok = getContainer()->get('logger')->log( \App\Logger::ERROR, 'a long message qsmldkf jfqksmldkfjqmlskdf jmlqksjmdlfkj jKMlkjqmlsdkjf ' );
    $ok = getContainer()->get('logger')->log( \App\Logger::INFO, 'a long message qsmldkf jfqksmldkfjqmlskdf jmlqksjmdlfkj jKMlkjqmlsdkjf ', $_GET, 'test' );
}

// write error logs
		try{
//			fopen(); // error
			if (2 != 4) // false
				throw new \App\Exception("Capture l'exception par défaut", 12);
		} catch(\App\Exception $e) {
			echo $e;
		}
*/

// Endfile