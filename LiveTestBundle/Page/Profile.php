<?php
namespace PhmLabs\LiveTestBundle\Page;

use Symfony\Component\HttpKernel\Profiler\Profiler as SymfonyProfiler;

class Profile implements \Serializable
{
	private $rawData;

	public function __construct()
	{
		
		$this->profile = array();
	}

	public function getRawData()
	{
		return $this->rawData;
	}

	public function setProfile( array $profile )
	{
		$cleanedProfile = $this->removeEmptyValues( $profile );
		$this->rawData = $this->getDataFromProfile( $cleanedProfile );
	}
	
	public function serialize()
	{
		return serialize( $this->rawData );	
	}
	
	public function unserialize( $data )
	{
		$this->rawData = unserialize( $data );
	}
	
	private function getDataFromProfile( array $profile )
	{
		foreach( $profile as $profileDataCollectors )
		{
			foreach( $profileDataCollectors as $aProfileDataCollectorName => $aProfileDataCollector )
			{
				$collector = $aProfileDataCollector;
				$data[$aProfileDataCollectorName] = $this->getCollectorData( $collector );
			}

		}

		return $data;
	}

	private function getCollectorData( $collector )
	{
		$data = array();
		$reflector = new \ReflectionClass( $collector );

		if($reflector->hasProperty( 'data' ))
		{
			$reflectorProperty = $reflector->getProperty( 'data' );
			$reflectorProperty->setAccessible( true );
			$data = $reflectorProperty->getValue( $collector );
		}


		return $data;
	}

	private function removeEmptyValues(array $profile)
	{
		$tmpContainer = array();

		foreach ( $profile as $value)
		{
			if(is_array($value))
			{
				$tmpContainer[] = $value;
			}
		}

		return $tmpContainer;
	}

	public function getDatabaseConnectionNumber()
	{
		$databaseDataContainer = $this->getDataForKey( 'db' );
		return $this->getDataForKey( 'connectionnumber', $databaseDataContainer );
	}

	public function getMemoryUsage()
	{
		$memoryDataContainer = $this->getDataForKey( 'memory' );
		return $this->getDataForKey( 'memory', $memoryDataContainer );
	}

	public function getProcessingTime()
	{
		$timerDataContainer = $this->getDataForKey( 'timer' );
		return $this->getDataForKey( 'time', $timerDataContainer );
	}

	public function getExceptions()
	{
		return $this->getDataForKey( 'exception' );
	}

	public function getErrorCount()
	{
		$loggerDataContainer = $this->getDataForKey( 'logger' );
		return $this->getDataForKey( 'error_count', $loggerDataContainer );
	}

	private function getDataForKey( $key, $search = false )
	{
		if(false == $search)
		{
			$search = $this->rawData;
		}

		if( array_key_exists( $key, $search ) )
		{
			return $this->$search[$key];
		}
		else
		{
			return 0;
		}
	}
}

