<?php

namespace QuickBooks\DataService;

/**
 * This class processes the CDC request.
 */
class IntuitCDCResponse
{
	/**
	 * list of entities.
	 * @var array entities
	 */
    public $entities;

	/**
	 * IdsException in case of ResponseType is exception.
	 * @var array exceptions
	 */
    public $exceptions;

	/**
	 * Initializes a new instance of the IntuitBatchResponse class.
	 */
    public function __construct()
    {
        $this->entities = [];
        $this->exceptions = [];
    }

    /**
     * Gets the List of entity value with particular key
     * @var string key
     * @return mixed|null
     */
    public function getEntity($key)
    {
    	foreach($this->entities as $entityKey => $entityVal)
    	{
    		if ($entityKey==$key)
    			return $entityVal;
    	}
    	return null;
    }
}
