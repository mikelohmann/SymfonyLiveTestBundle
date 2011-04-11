<?php
namespace PhmLabs\LiveTestBundle\Page;


use Symfony\Component\Validator\Exception\UnexpectedTypeException;

use Symfony\Component\Validator\Constraints\Url;

use Symfony\Component\Validator\Constraints\UrlValidator;

use PhmLabs\LiveTestBundle\Http\Client;

class Profiler
{
	private $pageProfile;
	private $client;
	private $url;
	private $profileStorage;
	
	public function __construct( Profile $pageProfile, Client $client )
	{
		$this->pageProfile = $pageProfile;
		$this->client = $client->createClient();
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param String $url
	 */
	public function requestUrl( $url )
	{
		$url = base64_decode( $url );
		
		if( $this->isValidUrl( $url ) )
		{
			$this->url = $url;
		}
		else
		{
			throw new \Exception('The given URL: "'.$url.'" is invalid!');
		}
		
		$this->client->getContainer()->enterScope('request');
		$this->client->request('GET', $this->url);
	}
	
	public function getPageProfile()
	{
		$profiler = $this->client->getContainer()->get('profiler');
		$this->pageProfile->setProfile( unserialize(base64_decode($profiler->export())) );
		
		return $this->pageProfile;
	}
	
	
	private function isValidUrl( $url )
    {
    	$validator = new UrlValidator();
        return $validator->isValid($url, new Url());
    }
}