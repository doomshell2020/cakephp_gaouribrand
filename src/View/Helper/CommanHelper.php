<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;


class CommanHelper extends Helper
{
    public function initialize(array $config)
    {
    }
    public function sitesettings($id)
    {
        $articles = TableRegistry::get('Sitesettings');
        return $articles->find('all')->where(['id' => $id])->first();
    }


    public function gst($gst_id)
    {
        $articles = TableRegistry::get('Gsts');
        return $articles->find('all')->where(['Gsts.id' => $gst_id])->first();
    }

    public function product($product_id)
    {
        $articles = TableRegistry::get('Products');
        return $articles->find('all')->where(['Products.id' => $product_id])->first();
    }

    public function categories()
    {
        $articles = TableRegistry::get('Categories');
        return $articles->find('all')->where(['Categories.status' => 1])->order(['Categories.name' => 'ASC'])->toarray();
    }

    public function user()
    {
        $articles = TableRegistry::get('Users');
        return $articles->find('all')->where(['Users.id' => 1])->first();
    }

    public function gettotalOrders($user_id = null, $vendor_id = null)
    {
        if ($vendor_id) {
            $articles = TableRegistry::get('Orders');
            return $articles->find('all')->where(['Orders.user_id' => $user_id, 'vendor_id' => $vendor_id])->count();
        } else {
            $articles = TableRegistry::get('Orders');
            return $articles->find('all')->where(['Orders.user_id' => $user_id])->count();
        }
    }

    public function gettotalOrderssum($user_id = null, $vendor_id = null)
    {
        $articles = TableRegistry::get('Orders');
        if ($articles != "" && $vendor_id) {
            return $articles->find('all')->select(['sum' => 'SUM(Orders.total_amount)'])->where(['Orders.user_id' => $user_id, 'vendor_id' => $vendor_id])->first();
        } else {
            return $articles->find('all')->select(['sum' => 'SUM(Orders.total_amount)'])->where(['Orders.user_id' => $user_id])->first();
        }
    }
    public function gettotalsales($prou_id = null)
    {

        $articles = TableRegistry::get('OrderDetails');
        $orders = $articles->OrderDetails->find('all')->select(['sum' => 'SUM(OrderDetails.total_price)'])->where(['OrderDetails.product_id IN' => array_keys($vendorProdIds)])->first();

        return $orders['sum'];
    }

    public function getreferredby($id)
    {
        $articles = TableRegistry::get('Users');
        return $articles->find('all')->where(['Users.id' => $id])->first();
    }

    public function getlocationname($vendor_id = null)
    {

        $articles = TableRegistry::get('Servicearea');
        $loaction_id = $articles->find('all')->where(['vendor_id' => $vendor_id])->first();
        $articles = TableRegistry::get('Locations');
        return $articles->find('all')->where(['id' => $loaction_id['location_id']])->first();
    }


    public function get_location_list($vendor_id = null)
    {

        $articles = TableRegistry::get('Servicearea');
        $loaction_id = $articles->find('all')->where(['vendor_id' => $vendor_id])->first();
        $articles = TableRegistry::get('Locations');
        return $articles->find('list', ['keyField' => 'id', 'valueField' => 'id'])->where(['id' => $loaction_id['location_id']])->toarray();
    }

    public function get_location_name($loaction_id = null)
    {

        $articles = TableRegistry::get('Locations');
        return $articles->find('all')->where(['id' => $loaction_id])->first();
    }

    public function get_vendor_name($user_id = null)
    {

        $articles = TableRegistry::get('Users');
        return $articles->find('all')->where(['id' => $user_id])->first();
    }

    public function get_user_details($user_id = null)
    {

        $articles = TableRegistry::get('Users');
        return $articles->find('all')->where(['id' => $user_id])->first();
    }

    // public function get_products_locations($user_id = null)
    // {

    //     $articles = TableRegistry::get('Users');
    //     return $articles->find('all')->where(['id' => $user_id])->first();
    // }

}
