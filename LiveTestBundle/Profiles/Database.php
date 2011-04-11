<?php
namespace PhmLabs\LiveTestBundle\Profiles;


class Database implements ProfileInterface
{
	private $profile;
	
	public function __construct()
	{
		$this->profile = array();
	}
	
	public function setProfile( $profile )
	{
		$this->profile = $profile;
	}
	
	public function getDatabaseConnectionNumber()
	{
		foreach ( $this->profile as $key => $value)
		{
			echo $key."\n";
			
			echo "\n\n";
		}
	}
}