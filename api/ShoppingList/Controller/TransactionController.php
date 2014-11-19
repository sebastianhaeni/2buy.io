<?php
namespace ShoppingList\Controller;

use ShoppingList\Model\Community;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Model\Product;
use ShoppingList\Model\Transaction;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\BaseModel;
use ShoppingList\Model\CommunityHasUser;
use ShoppingList\Util\CommunityChecker;

/**
 * Provides functions for /community/{id}/transaction.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class TransactionController extends BaseController
{

    /**
     * Returns all unclosed transactions.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getActiveTransactions(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $this->json(Transaction::getActiveTransactions($checker->getCommunity()
            ->getId(), $app));
    }

    /**
     * Returns all closed transactions.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getHistory(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $this->json(Transaction::getHistory($checker->getCommunity()
            ->getId(), $app));
    }

    /**
     * Clears the history of the community.
     * Only an admin can do this.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function clearHistory(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app, true);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        if (! Transaction::clearHistory($checker->getCommunity()->getId(), $app)) {
            return new Response('Error deleting database records', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Creates a new transaction.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function insertTransaction(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $name = $request->get('name');
        $amount = $request->get('amount');
        
        $selectedProduct = null;
        
        foreach ($checker->getCommunity()->getProducts($app) as $product) {
            if ($product->getName() == $name) {
                $selectedProduct = $product;
            }
        }
        
        if ($selectedProduct == null) {
            $selectedProduct = new Product(null, $checker->getCommunity()->getId(), $name, $app['auth']->getUser()->getId(), false);
            
            if (! $selectedProduct->save($app)) {
                return new Response('Error saving new product', StatusCodes::HTTP_BAD_REQUEST);
            }
        }
        
        $transactions = Transaction::getActiveTransactions($checker->getCommunity()->getId(), $app, $selectedProduct->getId());
        
        if (count($transactions) == 0) {
            $transaction = new Transaction(null, $selectedProduct->getId(), $app['auth']->getUser()->getId(), BaseModel::getCurrentTimeStamp(), null, $amount, null, 0, null, null);
        } else {
            $transaction = $transactions[0];
            if ($transaction->getAmount() > $amount) {
                return new Response('Product already in list', StatusCodes::HTTP_OK);
            }
            
            $transaction->setAmount($amount);
        }
        
        if (! $transaction->save($app)) {
            return new Response('Error saving transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Marks a transaction as bought and thus closed.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function buy(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $transaction = Transaction::getById($request->get('idTransaction'), $app);
        
        if ($transaction == null) {
            return new Response('Error finding transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $transaction->setBoughtBy($app['auth']->getUser($request)
            ->getId());
        $transaction->setCloseDate(BaseModel::getCurrentTimeStamp());
        
        if (! $transaction->save($app)) {
            return new Response('Error saving transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Marks a transaction as canceled and thus closed.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cancel(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $transaction = Transaction::getById($request->get('idTransaction'), $app);
        
        if ($transaction == null) {
            return new Response('Error finding transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $transaction->setCancelledBy($app['auth']->getUser($request)
            ->getId());
        $transaction->setCancelled(true);
        $transaction->setCloseDate(BaseModel::getCurrentTimeStamp());
        
        if (! $transaction->save($app)) {
            return new Response('Error saving transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Marks a closed transaction as unclosed.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function undo(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $transaction = Transaction::getById($request->get('idTransaction'), $app);
        
        if ($transaction == null) {
            return new Response('Error finding transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $transaction->setCancelledBy(null);
        $transaction->setCancelled(false);
        $transaction->setBoughtBy(null);
        $transaction->setCloseDate(null);
        
        if (! $transaction->save($app)) {
            return new Response('Error saving transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     *
     * @param Request $request            
     * @param Application $app            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        $amount = $request->get('amount');
        
        if ($amount == null || $amount <= 0) {
            return new Response('Invalid amount value', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $transaction = Transaction::getById($request->get('idTransaction'), $app);
        
        if ($transaction == null) {
            return new Response('Error finding transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        $transaction->setEditedBy($app['auth']->getUser($request)
            ->getId());
        $transaction->setAmount($amount);
        
        if (! $transaction->save($app)) {
            return new Response('Error saving transaction', StatusCodes::HTTP_BAD_REQUEST);
        }
        
        return new Response('Success', StatusCodes::HTTP_OK);
    }
}
