<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

class CouponsController extends AppController
{

    public function beforeFilter(Event $event)
    {
    }

    // for view or index page
    public function index()
    {
        //$this->loadModel('Categories');
        $this->viewBuilder()->layout('admin');
        $user = $this->Auth->user();
        // pr($user);exit;
        if ($user['role_id'] == 2) {
            $coupancode = $this->Coupons->find('all')->where(['vendor_id' => $user['id']])->order(['valid_to' => 'DESC']);
        } else {
            $coupancode = $this->Coupons->find('all')->order(['valid_to' => 'DESC']);
        }

        $this->set('coupancode', $this->paginate($coupancode)->toarray());
    }

    // coupon add
    public function add()
    {
        $user = $this->Auth->user();
        $this->viewBuilder()->layout('admin');
        $applicableTo = ['all' => 'All'];

        $this->set(compact('applicableTo'));

        if ($this->request->is(['post'])) {
            try {
                extract($this->request->data);
                $data = $this->Coupons->newEntity();
                // pr($this->request->data);exit;
                $data['vendor_id'] =  $this->request->session()->read('Auth.User.id');
                $data['code'] = $code;
                $data['applicable_to'] = 'all';
                $data['applicable_type'] = $applicable_type;
                $data['minimum_order_value'] = $minimum_order_value;
                $data['maximum_discount'] =  ($applicable_type=='amount')? $discount_amount : $maximum_discount;
                $data['discount_rate'] = $discount_rate;
                $data['valid_from'] = date('Y-m-d', strtotime($valid_from));
                $data['valid_to'] = date('Y-m-d', strtotime($valid_to));
                $data['description'] = $description;
                // pr($data);exit;
                if ($coupon = $this->Coupons->save($data)) {
                    if ($data['applicable_to'] == 'category') {
                        $categories = $this->Categories->find()->where(['id IN' => $categories])->toarray();
                        $this->Coupons->Categories->link($coupon, $categories);
                    } else if ($data['applicable_to'] == 'product') {
                        $products = $this->Products->find()->where(['id IN' => $products])->toarray();
                        $this->Coupons->Products->link($coupon, $products);
                    }
                    $this->Flash->success(__('Coupan-code  has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    pr($data);
                    die;
                    $this->Flash->error(__('Coupan-code not save'));
                    return $this->redirect(['action' => 'index']);
                }
            } catch (\PDOException $e) {
                pr($e);
                die;
            }
        }
    }

    //edit coupon
    public function edit($id = null)
    {
        // pr($id);
        $this->viewBuilder()->layout('admin');
        $user = $this->Auth->user();
        $editCoupon = $this->Coupons->find()->where(['id' => $id])->first();

        $applicableTo = ['all' => 'All'];

        $this->set(compact('categories', 'products', 'applicableTo', 'selctedcategories', 'selctedproducts', 'id', 'editCoupon'));
        if ($this->request->is(['post', 'put'])) {
            //    echo $applicable_type; die;

            try {
                extract($this->request->data);

                $data = $this->Coupons->find()->where(['id' => $id])->first();
                if ($user['role_id'] == 2) {
                    $data['vendor_id'] = $this->request->session()->read('Auth.User.id');
                } else {
                    $data['vendor_id'] = 0;
                }

                $data['code'] = $code;
                $data['applicable_to'] = 'all';
                $data['applicable_type'] = $this->request->data['applicable_type'];
                $data['discount_type'] = $discount_type;
                $data['minimum_order_value'] = $this->request->data['minimum_order_value'];
                $data['maximum_discount'] = $this->request->data['maximum_discount'];
                $data['discount_rate'] = $this->request->data['discount_rate'];
                $data['maxdiscount_rate'] = $maxdiscount_rate;
                $data['valid_from'] = date('Y-m-d', strtotime($valid_from));
                $data['valid_to'] = date('Y-m-d', strtotime($valid_to));
                $data['max_redeem_type'] = $max_redeem_type;
                $data['max_redeem_rate'] = $max_redeem_rate;
                $data['description'] = $description;
                $data['cashback_expiry_date'] = !empty($cashback_expiry_date) ? date('Y-m-d H:i:s', strtotime($cashback_expiry_date)) : null;
                if ($coupon = $this->Coupons->save($data)) {
                    $this->Flash->success(__('Coupan Updated Successfully !'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    //pr($data);die;
                    $this->Flash->error(__('Coupan-code not save'));
                    return $this->redirect(['action' => 'index']);
                }
            } catch (\PDOException $e) {
                pr($e);
                die;
            }
        }
    }

    //delete coupon
    public function delete($id = null)
    {
        $this->loadModel('Coupancode');
        $prod_data = $this->Coupancode->get($id);
        if ($prod_data) {
            $this->Coupancode->delete($prod_data);
            $this->Flash->success(__('Coupancode has been deleted successfully.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Coupancode has not been deleted'));
            return $this->redirect(['action' => 'index']);
        }
    }

    //status coupon 
    public function status($id, $status)
    {

        if (isset($id) && !empty($id)) {

            $product = $this->Coupons->get($id);
            $product->status = $status;
            if ($this->Coupons->save($product)) {
                $this->Flash->success(__('Coupon status has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    //search coupon 
    public function search()
    {
        $query = $this->request->data;
        $copancodes = trim($query['coupan_code']);
        $cond = [];
        $session = $this->request->session();
        $session->delete('cond');

        if (!empty($copancodes)) {
            $cond['Coupons.code LIKE'] = "%" . $copancodes . "%";
        }
        $session = $this->request->session();
        $session->write('cond', $cond);
        $coupancode = $this->Coupons->find('all')->contain(['Categories', 'Products'])->where($cond)->toarray();
        $this->set('coupancode', $coupancode);
    }

    // is authorized coupon check
    public function isAuthorized($user)
    {
        if (isset($user['role_id']) && ($user['role_id'] == 1)) {
            return true;
        }
        return false;
    }
}
