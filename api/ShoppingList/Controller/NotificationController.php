<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\Notification;

/**
 * Sends notifications via email.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class NotificationController extends BaseController
{

    /**
     * Sends all notifications out if the scheduled time has passed.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function update(Request $request, Application $app)
    {
        $transactions = Transaction::getScheduledClosedNotifications($app);
        
        foreach ($transactions as $transaction) {}
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }
}
