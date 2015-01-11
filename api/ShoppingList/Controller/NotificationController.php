<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\Transaction;
use ShoppingList\Model\Product;
use ShoppingList\Model\User;
use ShoppingList\Model\CommunityHasUser;

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
        if ($this->sendNotifications($this->getChangeList($app), $app, $request)) {
            return new Response('Success', StatusCodes::HTTP_OK);
        }
        return new Response('Error', StatusCodes::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Sends email to all the users.
     *
     * @param array $changeList            
     * @param Application $app            
     * @return boolean
     */
    private function sendNotifications($changeList, Application $app, Request $request)
    {
        foreach ($changeList as $communityId => $list) {
            $users = CommunityHasUser::getByCommunityId($communityId, $app);
            
            foreach ($users as $user) {
                
                if (! $user->getReceiveNotifications()) {
                    continue;
                }
                
                foreach ($list as $key => $category) {
                    foreach ($category as $item) {
                        if (isset($item['triggeredBy']) && $item['triggeredBy'] == $app['auth']->getUser($request)->getId()) {
                            unset($list[$key]);
                        }
                    }
                }
                
                $body = $app['twig']->render('email/community-update.html', [
                    $list,
                    'config' => $app['config']
                ]);
                
                $message = \Swift_Message::newInstance()->setSubject('2buy.io')
                    ->setFrom(array(
                    'noreply@2buy.io'
                ))
                    ->setTo(User::getById($user->getUserId(), $app)->getEmail())
                    ->setBody($body, 'text/html');
                
                $app['mailer']->send($message);
            }
            
            foreach ($list as $category) {
                foreach ($category as $item) {
                    $transaction = Transaction::getById($item['id'], $app);
                    $transaction->setNotified(true);
                    if (! $transaction->save($app)) {
                        return false;
                    }
                }
            }
        }
        
        return true;
    }

    /**
     * Creates a change list of whats happened in all the communities.
     *
     * @param Application $app            
     * @return Ambigous <multitype:, multitype:NULL >
     */
    private function getChangeList(Application $app)
    {
        $changeList = [];
        
        $transactions = Transaction::getScheduledClosedNotifications($app);
        foreach ($transactions as $transaction) {
            $product = Product::getById($transaction->getProductId(), $app);
            $changeList[$product->getCommunityId()][$transaction->getCancelled() ? 'cancelled' : 'bought'][] = [
                'id' => $transaction->getId(),
                'amount' => $transaction->getAmount(),
                'name' => $product->getName(),
                'triggeredBy' => $transaction->getCancelled() ? $transaction->getCancelledBy() : $transaction->getBoughtBy()
            ];
        }
        
        $transactions = Transaction::getScheduledAddedNotifications($app);
        foreach ($transactions as $transaction) {
            $product = Product::getById($transaction->getProductId(), $app);
            $changeList[$product->getCommunityId()]['added'][] = [
                'id' => $transaction->getId(),
                'amount' => $transaction->getAmount(),
                'name' => $product->getName(),
                'triggeredBy' => $transaction->getReportedBy()
            ];
        }
        
        $transactions = Transaction::getScheduledEditedNotifications($app);
        foreach ($transactions as $transaction) {
            $product = Product::getById($transaction->getProductId(), $app);
            $changeList[$product->getCommunityId()]['edited'][] = [
                'id' => $transaction->getId(),
                'amount' => $transaction->getAmount(),
                'name' => $product->getName(),
                'triggeredBy' => $transaction->getEditedBy()
            ];
        }
        
        return $changeList;
    }
}
