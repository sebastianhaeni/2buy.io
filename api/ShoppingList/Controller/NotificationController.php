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
        $notifications = Notification::getScheduledNotifications($app);
        
        foreach ($notifications as $notification) {
            // TODO send notification
            // if (! $notification->delete($app)) {
            // return new Response('Error', StatusCodes::HTTP_INTERNAL_SERVER_ERROR);
            // }
        }
        return new Response('Success', StatusCodes::HTTP_OK);
    }
}
