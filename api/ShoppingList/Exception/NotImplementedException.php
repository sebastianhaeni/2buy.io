<?php
namespace ShoppingList\Exception;

/**
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