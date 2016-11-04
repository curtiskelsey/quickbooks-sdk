<?php

namespace QuickBooks\Exception;

/**
 * Manages all the exceptions thrown to the user.
 */
class IdsExceptionManager
{
    /**
     * Handles exception thrown to the user.
     * @param string errorMessage Error Message
     * @throws IdsException
     */
    public static function HandleExceptionMessage($errorMessage)
    {
        throw new IdsException($errorMessage);
    }

    /**
     * Handles Exception thrown to the user.
     * @param IdsException idsException Ids Exception
     */
    public static function HandleExceptionObject($idsException)
    {
        throw $idsException;
    }

    /**
     * Handles Exception thrown to the user.
     * @param null $errorMessage
     * @param null $errorCode
     * @param null $source
     * @param null $innerException
     * @throws IdsException
     * @internal param errorMessage $string Error Message
     * @internal param errorCode $string Error Code.
     * @internal param source $string Source of the exception.
     * @internal param innerException $IdsException Ids Exception
     */
    public static function HandleException($errorMessage = null,
                                           $errorCode = null,
                                           $source = null,
                                           $innerException = null)
    {
        $message = implode(", ", [$errorMessage, $errorCode, $source]);
        throw new IdsException($message);
    }

}
