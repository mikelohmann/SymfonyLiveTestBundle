<?php 

namespace PhmLabs\LiveTestBundle\Entity;

/**
 * @orm:Entity
 */
class Test
{
	/**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:Column(type="string", lenght="255")
     */
    protected $name;

}