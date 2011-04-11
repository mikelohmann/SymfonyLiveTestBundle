<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhmLabs\LiveTestBundle\Http;

$phpUnitDir = __DIR__.'/../Vendor/';
set_include_path(get_include_path().':'.$phpUnitDir);

require_once('PHPUnit/Autoload.php');

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class Client extends WebTestCase
{
	
	protected function createKernel(array $options = array())
	{
		$env = $this->getEnvironment( $options );
		$debug = $this->getDebugStatus( $options );
		
		return new \AppKernel(
            $env,
            $debug
        );
	}
	
	private function getDebugStatus(array $options)
	{
		if( isset($options['debug']) )
        {
        	$debug = (bool)$options['debug'];
        }
        else
        {
        	$debug = true;
        }
        
        return $debug;
	}
	
	private function getEnvironment(array $options)
	{
		if( isset($options['environment']) )
        {
        	$env = $options['environment'];
        }
        else
        {
        	$env = 'test';
        }
        
        return $env;
	}
}
