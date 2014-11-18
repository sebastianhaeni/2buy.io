<?php
namespace ShoppingList\Exception;

/**
 * Not implemented exception.
 * Thrown when somebody was too lazy to implement a functionality.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class NotImplementedException extends \Exception
{

    public function __construct()
    {
        parent::__construct('Not implemented');
    }
}