<?php
namespace ShoppingList\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 * Provides a method to get a product name and an optional image for a EAN-13 barcode.
 *
 * @author Sebastian Häni <haeni.sebastian@gmail.com>
 */
class BarcodeController extends BaseController
{

    /**
     * Fetches product name and image url from another API with barcode.
     *
     * @param Request $request            
     * @param Application $app            
     * @return \ShoppingList\Controller\Response
     */
    public function get(Request $request, Application $app)
    {
        $barcode = $request->get('barcode');
        $url = "http://www.codecheck.info/product.search?q=" . $barcode;
        $html = self::getHttpContent($url);
        $data = array();
        
        $matches = array();
        preg_match('/<h1 id="t-[0-9]*">([a-zA-Z0-9- \n\t]*?)<\/h1>/', $html, $matches);
        
        if (count($matches) == 2) {
            $data['name'] = trim($matches[1]);
        }
        
        $matches = array();
        preg_match('/<span class="cc-image s1  hf"><div class="nf"><span class="h-spacer"><\/span><img id="i-[0-9]*" alt=".*?" src="([a-z0-9.\/]*)"/', $html, $matches);
        if (count($matches) == 2) {
            $data['image'] = "http://www.codecheck.info/" . $matches[1];
        }
        
        return $app->json($data);
    }

    /**
     * Fetches response from a HTTP/GET call.
     *
     * @param string $url            
     * @return content of url
     */
    private static function getHttpContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $tmp = curl_exec($ch);
        curl_close($ch);
        
        if ($tmp != false) {
            return $tmp;
        }
        
        return null;
    }
}
