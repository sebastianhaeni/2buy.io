<?php
namespace ShoppingList\Util;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Signifies the success of the operation to the user.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 *        
 */
class SuccessResponse extends JsonResponse
{

    function __construct()
    {
        parent::__construct(array(
            'Success' => true
        ), self::HTTP_ACCEPTED);
    }
}