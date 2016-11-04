<?php

namespace QuickBooks\DataService;

/**
 * type of batch response
 */
class ResponseType
{
    /**
     * batch response has single entity
     */
    const Entity = 1;

    /**
     * batch response has more than one enitity.
     */
    const Query = 2;

    /**
     * batch response has exception.
     */
    const Exception = 3;
}
