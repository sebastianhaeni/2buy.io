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

    function SuccessResponse()
    {
        super([
            'Success' => true
        ], StatusCodes::HTTP_ACCEPTED);
    }
}