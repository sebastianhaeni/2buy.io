<?php
namespace ShoppingList\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Model\Bill;
use ShoppingList\Util\StatusCodes;
use ShoppingList\Model\BaseModel;
use ShoppingList\Util\CommunityChecker;

/**
 * Provides functions for /community/{id}/bill.
 *
 * @author David Wiedmer <dave@sidefyn.ch>
 */
class BillController extends BaseController
{

    /**
     * Returns all unclosed bills.
     *
     * @param Request $request
     * @param Application $app
     * @return \ShoppingList\Controller\Response
     */
    public function getActiveBills(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (!$checker->isGood()) {
            return $checker->getResponse();
        }

        return $this->json(Bill::getActiveBills($checker->getCommunity()
            ->getId(), $app));
    }

    /**
     * Returns all closed bills.
     *
     * @param Request $request
     * @param Application $app
     * @return \ShoppingList\Controller\Response
     */
    public function getHistory(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (!$checker->isGood()) {
            return $checker->getResponse();
        }

        return $this->json(Bill::getHistory($checker->getCommunity()
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
        if (!$checker->isGood()) {
            return $checker->getResponse();
        }

        if (!Bill::clearHistory($checker->getCommunity()->getId(), $app)) {
            return new Response('Error deleting database records', StatusCodes::HTTP_BAD_REQUEST);
        }

        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Creates a new bill.
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function insertBill(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (!$checker->isGood()) {
            return $checker->getResponse();
        }

        $price = $request->get('price');
        $files = $request->files->get('bill-scan');
        $path = __DIR__.'/../web/upload/';
        $filename = $files['FileUpload']->getClientOriginalName();
        $files['FileUpload']->move($path,$filename);

        $picturePath = $path. $filename;

        $bill = new Bill(null, $price, $picturePath, $checker->getCommunity()->getId(), $app['auth']->getUser()->getId(), BaseModel::getCurrentTimeStamp(), null, null, null);

        if (!$bill->save($app)) {
            return new Response('Error saving new bill', StatusCodes::HTTP_BAD_REQUEST);
        }

        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Marks a bill as accepted and thus closed.
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accept(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (!$checker->isGood()) {
            return $checker->getResponse();
        }

        $bill = Bill::getById($request->get('idBill'), $app);

        if ($bill == null) {
            return new Response('Error finding bill', StatusCodes::HTTP_BAD_REQUEST);
        }

        $bill->setAccepted(true);
        $bill->setClosedBy($app['auth']->getUser($request)
            ->getId());
        $bill->setClosedDate(BaseModel::getCurrentTimeStamp());

        if (!$bill->save($app)) {
            return new Response('Error saving bill', StatusCodes::HTTP_BAD_REQUEST);
        }

        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Marks a bill as declined and thus closed.
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function decline(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (!$checker->isGood()) {
            return $checker->getResponse();
        }

        $bill = Bill::getById($request->get('idBill'), $app);

        if ($bill == null) {
            return new Response('Error finding bill', StatusCodes::HTTP_BAD_REQUEST);
        }

        $bill->setAccepted(false);
        $bill->setClosedBy($app['auth']->getUser($request)
            ->getId());
        $bill->setClosedDate(BaseModel::getCurrentTimeStamp());

        if (!$bill->save($app)) {
            return new Response('Error saving bill', StatusCodes::HTTP_BAD_REQUEST);
        }

        return new Response('Success', StatusCodes::HTTP_OK);
    }

    /**
     * Marks a closed bill as unclosed.
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function undo(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (!$checker->isGood()) {
            return $checker->getResponse();
        }

        $bill = Bill::getById($request->get('idBill'), $app);

        if ($bill == null) {
            return new Response('Error finding bill', StatusCodes::HTTP_BAD_REQUEST);
        }

        $bill->setClosedBy(null);
        $bill->setClosedDate(null);
        $bill->setAccepted(null);

        if (!$bill->save($app)) {
            return new Response('Error saving bill', StatusCodes::HTTP_BAD_REQUEST);
        }

        return new Response('Success', StatusCodes::HTTP_OK);
    }
}
