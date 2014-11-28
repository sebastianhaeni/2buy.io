<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use ShoppingList\Model\Community;
use ShoppingList\Util\CommunityChecker;

/**
 * Provides data to generate statistical diagrams.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class StatisticsController extends BaseController
{

    /**
     * Returns each community member with their purchase count.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getPurchaseData(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $this->json($checker->getCommunity()
            ->getPurchaseData($app));
    }

    /**
     * Returns each community member with their order count.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function getOrderData(Request $request, Application $app)
    {
        $checker = new CommunityChecker($request, $app);
        if (! $checker->isGood()) {
            return $checker->getResponse();
        }
        
        return $this->json($checker->getCommunity()
            ->getOrderData($app));
    }
}
