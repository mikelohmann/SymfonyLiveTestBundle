<?php

namespace PhmLabs\LiveTestBundle\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function getProfileForAction( $url )
    {
    	$profiler = $this->container->get('page_profiler');
    	$profiler->requestUrl( $url );
    	$profile = $profiler->getPageProfile();
    	var_dump($profile);
    	return new Response( serialize($profile) );
    }
    
    public function helpAction( )
    {
        return new Response('<html><body>help</body></html>');
    }
    
	public function testAction( )
    {
        
    }
    
}
