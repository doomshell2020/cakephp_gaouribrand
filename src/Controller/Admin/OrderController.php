<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;

include_once(ROOT . '/vendor' . DS . 'PHPExcel' . DS . 'Classes' . DS . 'PHPExcel.php');
include_once(ROOT . '/vendor' . DS . 'PHPExcel' . DS . 'Classes' . DS . 'IOFactory.php');
// include '../vendor/tecnickcom/tcpdf/tcpdf.php';


include '../vendor/tecnickcom/tcpdf/tcpdf.php';

class OrderController extends AppController
{
    public function login()
    {
        $this->viewBuilder()->layout('login');
        return $this->redirect('/logins');
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['generatedinvoice']);
    }

    public function index($id = null)
    {
        $this->loadModel('Orders');
        $this->loadModel('Users');
        $this->loadModel('userAddresses');
        $this->loadModel('OrderDetails');
        $this->loadModel('Locations');
        $this->viewBuilder()->layout('admin');
        $userId = $this->Auth->user('id');

        $vendor_data = $this->request->session()->read('Auth.User');
        if (empty($id) && $vendor_data['role_id'] == 2) {
            $orders = $this->Orders->find('all')->where(['Orders.payment_status !=' => "rejected", 'Orders.vendor_id' => $vendor_data['id']])->order(['Orders.id' => 'DESC']);
        } else if ($vendor_data['role_id'] == 2 && (!empty($vendor_data['id']))) {
            $orders = $this->Orders->find('all')->contain(['Users', 'OrderDetails'])->where(['Orders.payment_status !=' => "rejected", 'Orders.user_id' => $id, 'vendor_id' => $vendor_data['id']])->order(['Orders.id' => 'DESC']);
        } elseif ($id) {
            $orders = $this->Orders->find('all')->contain(['Users', 'OrderDetails'])->where(['Orders.payment_status !=' => "rejected", 'Orders.user_id' => $id])->order(['Orders.id' => 'DESC']);
        } else {
            $orders = $this->Orders->find('all')->contain(['Users', 'OrderDetails'])->where(['Orders.payment_status !=' => "rejected"])->order(['Orders.id' => 'DESC']);
        }
        $this->paginate($orders)->toarray();
        $this->set('orders', $orders);

        $locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
        $this->set(compact('locations'));
    }

    public function statusupdate()
    {
        $this->loadModel('Orders');
        $this->loadModel('Notifications');
        $this->loadModel('Users');
        $status = $this->request->data['status'];
        $id = $this->request->data['id'];
        if (isset($id) && !empty($id)) {
            $product = $this->Orders->get($id);
            if ($product['order_status'] != "Delivered") {
                $product->order_status = $status;
                if ($this->Orders->save($product)) {

                    require_once 'Firebase.php';
                    require_once 'Push.php';
                    // for user notification
                    $newpack = $this->Notifications->newEntity();
                    $data['user_id'] = $product['user_id'];
                    $data['title'] = "Order Status";
                    $data['message'] = 'your order #' . $product['id'] . ' has been ' . $status;
                    $push = new \Push(
                        $data['title'],
                        $data['message']
                    );
                    $savepack = $this->Notifications->patchEntity($newpack, $data);
                    // pr($savepack); die;
                    $results = $this->Notifications->save($savepack);

                    $mPushNotification = $push->getPush();
                    //creating firebase class object

                    $user = $this->Users->find('all')->where(['Users.id' => $product['user_id']])->first();
                    $udata['notification_counter'] = $user['notification_counter'] + 1;
                    $usavepack = $this->Users->patchEntity($user, $udata);
                    $uresult = $this->Users->save($usavepack);

                    $this->Flash->success(__('Order status has been ' . $status));
                    echo json_encode(1);
                    die;

                    $firebase = new \Firebase();
                    $token = $user['token'];
                    $res = $firebase->send($token, $mPushNotification);
                    // pr($res); die;
                }
            } else {
                echo json_encode(1);
                die;
            }
        } else {
            echo json_encode(1);
            die;
        }
        die;
    }

    // Search Orders
    public function search()
    {
        $this->loadModel('Orders');
        $this->loadModel('Users');
        $this->loadModel('States');
        $this->loadModel('OrderDetails');
        // pr($this->request->data); die;
        $session = $this->request->session();
        $session->delete('cond');
        $name = $this->request->data['name'];
        $mobile = $this->request->data['mobile'];
        $state_id = $this->request->data['state_id'];
        $from_date = $this->request->data['from_date'];
        $to_date = $this->request->data['to_date'];
        $location = $this->request->data['location'];
        $order_Id_from = $this->request->data['order_id_from'];
        $order_id_to = $this->request->data['order_id_to'];


        $cond = [];
        if (isset($name) && $name != '') {
            $cond['Users.name LIKE'] = '%' . trim($name) . '%';
        }
        if (isset($mobile) && $mobile != '') {
            $cond['Users.mobile LIKE'] = '%' . trim($mobile) . '%';
        }

        if (isset($from_date) && $from_date != '') {
            $cond['DATE(Orders.order_date) >='] = $from_date;
        }
        if (isset($to_date) && $to_date != '') {
            $cond['DATE(Orders.order_date) <='] = $to_date;
        }
        if (isset($location) && $location != '') {
            $cond['Orders.location_id'] = $location;
        }

        if (isset($order_Id_from) && $order_Id_from != '') {
            $cond['Orders.id >='] = $order_Id_from;
        }

        if (isset($order_id_to) && $order_id_to != '') {
            $cond['Orders.id <='] = $order_id_to;
        }

        $vendor_data = $this->request->session()->read('Auth.User');
        if ($vendor_data['role_id'] == 2) {
            $cond['Orders.vendor_id'] = $vendor_data['id'];
            $orders = $this->Orders->find('all')->contain(['Users', 'OrderDetails'])->where($cond)->order(['Orders.id' => 'DESC'])->toarray();
        } else {
            $orders = $this->Orders->find('all')->contain(['Users', 'OrderDetails'])->where($cond)->order(['Orders.id' => 'DESC'])->toarray();
        }
        $this->set('orders', $orders);
        $this->request->session()->write('cond', $cond);
    }


    public function orderdetail($order_id)
    {
        $this->loadModel('Orders');
        $this->loadModel('Users');
        $this->loadModel('OrderDetails');
        $this->viewBuilder()->layout('admin');
        $orders = $this->OrderDetails->find('all')->contain(['Users'])->where(['OrderDetails.order_id' => $order_id])->order(['OrderDetails.id' => 'DESC'])->toarray();
        // pr($orders); die;
        $this->set('orders', $orders);
    }

    // invoice generate in pdf view
    public function generatedinvoice($invoice_number = null)
    {
        //pr($invoice_number); die;
        //$this->response->type('pdf');
        $this->loadModel('Orders');
        $this->loadModel('Users');
        $this->loadModel('States');
        $this->loadModel('OrderDetails');

        $order = $this->Orders->find('all')->contain(['Users', 'States', 'OrderDetails'])->where(['Orders.id' => $invoice_number])->order(['Orders.id' => 'DESC'])->first();
        // pr($order); die;
        $this->set('order', $order);
    }
    // all Orders Pdf Generate
    public function orders_pdf()
    {
        $this->loadModel('Orders');
        $this->loadModel('Users');
        $this->loadModel('States');
        $this->loadModel('OrderDetails');
        $where = $this->request->session()->read('cond');
        $vendor_data = $this->request->session()->read('Auth.User');

        // $endDate = Time::now(); // Current date and time
        // $startDate = date("Y-m-d",strtotime($endDate->subDays(30))); // Subtract 30 days
        // echo $startDate; die;

        $cond['DATE(Orders.order_date) <='] = date('Y-m-d');
        $cond['DATE(Orders.order_date) >='] = date("Y-m-d", strtotime(Time::now()->subDays(30)));

        // pr($where); die;
        if (isset($where)) {
            $orders = $this->Orders->find('all')
                ->contain(['Users', 'OrderDetails'])
                ->where([
                    $where,
                    $cond
                ])
                ->order(['Orders.delivery_date' => 'desc'])
                ->toArray();
            $this->request->session()->delete('cond');
        } elseif ($vendor_data['role_id'] == 2) {
            $orders = $this->Orders->find('all')
                ->contain(['Users', 'OrderDetails'])
                ->where([
                    $where,
                    'Orders.vendor_id' => $vendor_data['id'],
                    $cond
                ])
                ->order(['Orders.delivery_date' => 'desc'])
                ->toArray();
            $this->request->session()->delete('cond');
        } else {
            $orders = $this->Orders->find('all')
                ->contain(['Users', 'OrderDetails'])
                ->where([
                    $cond
                ])
                ->order(['Orders.delivery_date' => 'desc'])
                ->toArray();
        }

        $this->set('orders', $orders);
    }


    //Order pdf generate by id
    public function pdf($id)
    {
        $this->loadModel('Orders');
        $this->loadModel('Users');
        $this->loadModel('OrderDetails');
        // $orders = $this->OrderDetails->find('all')->contain(['Users','Orders'])->where(['OrderDetails.order_id' => $id])->toarray();
        $order = $this->Orders->find('all')->contain(['Users', 'OrderDetails'])->where(['Orders.id' => $id])->order(['Orders.id' => 'DESC'])->first();
        // pr($order);die;
        $this->set('orders', $order);
    }

    public function orders_excel()
    {
        $this->autoRender = true; // because Excel is separate CTP file

        $this->loadModel('Orders');
        $this->loadModel('Users');
        $this->loadModel('OrderDetails');

        $session = $this->request->session();
        $vendor = $session->read('Auth.User');
        $where = $session->read('cond');

        $query = $this->Orders->find()
            ->contain(['Users', 'OrderDetails'])
            ->order(['Orders.id' => 'DESC'])
            ->enableHydration(false)
            ->bufferResults(false); 

        if ($where) {
            $query->where($where);
            $session->delete('cond');
        }

        if ($vendor['role_id'] == 2) {
            $query->where(['Orders.vendor_id' => $vendor['id']]);
        }

        $chunkSize = 500;

        $orders = $this->chunkGenerator($query, $chunkSize);

        $this->set('orders', $orders);
    }


    public function chunkGenerator($query, $chunkSize)
    {
        $offset = 0;

        while (true) {
            $rows = $query->limit($chunkSize)->offset($offset)->toArray();

            if (empty($rows)) {
                break;
            }

            foreach ($rows as $r) {
                yield $r; 
            }

            $offset += $chunkSize;
        }
    }


    public function add()
    {
        $this->viewBuilder()->setLayout('admin');
        $this->loadModel('Locations');
        $this->loadModel('Users');
        $this->loadModel('Orders');
        $this->loadModel('UserAddresses');
        $this->loadModel('OrderDetails');

        $vendors = $this->Users->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Users.role_id' => 2])->toArray();
        $locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        $this->set(compact('locations', 'vendors'));

        if ($this->request->is(['post'], ['put'])) {
            // pr($this->request->data);die;
            $mobile = $this->request->data['mobile'];
            $users = $this->Users->find('all')->where(['Users.mobile' => $mobile])->first();

            if (empty($users)) {
                $conts = $this->Users->newEntity();
                $data['name'] = $this->request->data['name'];
                $data['mobile'] = $this->request->data['mobile'];
                $data['role_id'] = '3';
                $data['address'] = $this->request->data['address'];
                $data['villagename'] = $this->request->data['villagename'];
                $data['location_id'] = $this->request->data['location'];
                $data['animalCount'] = 1;
                $data['milkQuantity'] = '1';
                $userdetail = $this->Users->patchEntity($conts, $data);
                $result1 = $this->Users->save($userdetail);

                $user_id = $result1->id;
                $con = $this->UserAddresses->newEntity();

                $name =  $this->request->data['name'];
                $address = $this->request->data['address'];
                $address_type = 'Home';
                $is_permanent = 'Y';
                $conn = ConnectionManager::get('default');

                $ds = "INSERT INTO gaouribrand.user_addresses ( name,user_id, address, address_type, is_permanent)
                   VALUES ('" . $name . "','" . $user_id . "','" . $address . "','Home','Y')";
                $result1 = $conn->execute($ds);
            } else {
                $user_id = $users['id'];
            }

            $cont = $this->Orders->newEntity();
            $data1['user_id'] = $user_id;
            $data1['vendor_id'] = $this->request->data['vendor'];
            $data1['total_amount'] = $this->request->data['total'];
            $data1['sub_total'] = $this->request->data['total'];
            $data1['discount'] = $this->request->data['discount'];
            $data1['billng_address'] = $this->request->data['address'];
            $data1['location_id'] = $this->request->data['location'];
            $data1['delivery_date'] = date('Y-m-d', strtotime(' +1 day'));
            if ($data1['location_id'] == 1) {
                $data1['locality'] = 'परसरामपुरा';
            } elseif ($data1['location_id'] == 2) {
                $data1['locality'] = 'झुंझुनूं';
            } else {
                $data1['locality'] = 'जयपुर';
            }
            $data1['address_type'] = 'Home';
            $data1['slot_id'] = 1;
            $data1['payment_mode'] = 'COD';
            $orderdetail = $this->Orders->patchEntity($cont, $data1);

            if ($result = $this->Orders->save($orderdetail)) {
                foreach ($this->request->data['product_id'] as $key => $value) {
                    $cnt = $this->OrderDetails->newEntity();
                    if ($this->request->data['quantity'][$key] > 0) {
                        $productPrice = $this->request->data['price'][$key] / $this->request->data['quantity'][$key];
                    } else {
                        $productPrice = 0;
                    }
                    $valu['user_id'] = $user_id;
                    $valu['order_id'] = $result['id'];
                    $valu['product_id'] = $value;
                    $valu['quantity'] = $this->request->data['quantity'][$key];
                    $valu['product_price'] = $productPrice;
                    $valu['total_price'] = $this->request->data['price'][$key];
                    $valu['weight'] = $this->request->data['unit'][$key];

                    $orderdetail1 = $this->OrderDetails->patchEntity($cnt, $valu);
                    $result1 = $this->OrderDetails->save($orderdetail1);
                }
            }
            $this->Flash->success(__('Order added successfully.'));
            return $this->redirect(['action' => 'index']);
        }
    }


    // to check mobile no 
    public function checkmobileno()
    {
        $this->autoRender = false;
        $mobile = $this->request->data['mobile'];
        $this->loadModel('Users');
        $this->loadModel('Servicearea');
        $checkuser = $this->Users->find('all')->where(['Users.mobile' => $mobile])->first();
        $findVendor = $this->Servicearea->find('all')->where(['Servicearea.location_id' => $checkuser['location_id']])->order(['Servicearea.id' => 'DESC'])->first();
        $response = [];
        if ($checkuser != '' && !empty($checkuser)) {
            $response['name'] = $checkuser['name'];
            $response['address'] = $checkuser['address'];
            $response['villagename'] = $checkuser['villagename'];
            $response['location_id'] = $checkuser['location_id'];
            $response['vendor_id'] = $findVendor['vendor_id'];
        } else {
            $response = null;
        }
        echo json_encode($response);
        return;
    }

    // get vendor products
    public function getvendorproducts()
    {
        $this->autoRender = false;
        $vendor_id = $this->request->data['vendor_id'];
        $this->loadModel('Products');
        $products = $this->Products->find('all')->where(['Products.vendor_id' => $vendor_id, 'status' => 'Y'])->toArray();

        $response = [];
        if ($products != '' && !empty($products)) {
            foreach ($products as $value) {
                $output = [];
                $output['id'] = $value['id'];
                if ($value['brand_name'] == '' || $value['brand_name'] == '--') {
                    $output['name'] = $value['name'];
                } else {
                    $output['name'] = $value['name'] . '(' . $value['brand_name'] . ')';
                }
                array_push($response, $output);
            }
        };
        echo json_encode($response);
        return;
    }

    public function getproduct_details()
    {
        $this->autoRender = false;
        $product_id = $this->request->data['product_id'];
        $this->loadModel('ProductAddons');
        $products = $this->ProductAddons->find('all')->where(['ProductAddons.product_id' => $product_id])->toArray();
        $response = [];
        if ($products != '' && !empty($products)) {
            $response['price'] = $products[0]['price'];
            $unitVal = [];
            foreach ($products as $value) {
                $unitVal[] = $value['name'];
            }
            $response['unit'] = $unitVal;
        }
        echo json_encode($response);
    }


    public function getproductprice()
    {
        $this->autoRender = false;
        $this->loadModel('ProductAddons');
        $product_id = $this->request->getData('product_id');
        $unitQty = $this->request->getData('unitQty');
        $ProductAddons = $this->ProductAddons->find('all')->where(['ProductAddons.product_id' => $product_id, 'ProductAddons.name' => $unitQty])->first();
        $response = $ProductAddons->price;
        echo json_encode($response);
        return;
    }
}
