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

include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

// include_once(ROOT . '/vendor' . DS . 'PHPExcel' . DS . 'Classes' . DS . 'PHPExcel.php');
// include_once(ROOT . '/vendor' . DS . 'PHPExcel' . DS . 'Classes' . DS . 'IOFactory.php');
include '../vendor/tecnickcom/tcpdf/tcpdf.php';

class CustomerController extends AppController
{

	//All Modal Load
	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Users');
		$this->loadModel('Products');
		$this->loadModel('Locations');
	}

	public function login()
	{
		$this->viewBuilder()->layout('login');
		return $this->redirect('/logins');
	}

	public function index()
	{
		$this->loadModel('Orders');

		$this->viewBuilder()->layout('admin');

		$locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
		$this->set(compact('locations'));
		

		$req_data = $this->request->session()->read('req_data');
		$this->set('users', $users_data);

		$user_data = $this->request->session()->read('Auth.User');
		if ($user_data['role_id'] == 2) {
			$usersTable = TableRegistry::getTableLocator()->get('Users');
			$query = $usersTable->find('all');
			$users = $query->select([
				'id' => 'Users.id',
				'name' => 'Users.name',
				'mobile' => 'Users.mobile',
				'referral_code' => 'Users.referral_code',
				'villagename' => 'Users.villagename',
				'animalCount' => 'Users.animalCount',
				'milkQuantity' => 'Users.milkQuantity',
				'referred_user_id' => 'Users.referred_user_id',
				'created' => 'Users.created',
				'user_id' => 'Users.id',
				'vendor_id' => 'Orders.vendor_id',
				'order_total' => $query->func()->sum('Orders.total_amount')
			])->join(['Orders' => ['table' => 'orders', 'type' => 'LEFT', 'conditions' => ['Orders.user_id = Users.id']]])->where(['Users.role_id' => 3, 'Orders.vendor_id' => $user_data['id']])->group('Users.id')->order(['order_total' => 'DESC']);
			$users_data = $this->paginate($users)->toArray();
		} else {
			$usersTable = TableRegistry::getTableLocator()->get('Users');
			$query = $usersTable->find('all');
			$users = $query->select([
				'id' => 'Users.id',
				'name' => 'Users.name',
				'mobile' => 'Users.mobile',
				'referral_code' => 'Users.referral_code',
				'villagename' => 'Users.villagename',
				'animalCount' => 'Users.animalCount',
				'milkQuantity' => 'Users.milkQuantity',
				'referred_user_id' => 'Users.referred_user_id',
				'created' => 'Users.created',
				'user_id' => 'Users.id',
				'order_total' => $query->func()->sum('Orders.total_amount')
			])->join(['Orders' => ['table' => 'orders', 'type' => 'LEFT', 'conditions' => ['Orders.user_id = Users.id']]])->where(['Users.role_id' => 3])->group('Users.id')->order(['order_total' => 'DESC']);
			$users_data = $this->paginate($users)->toArray();
		}
		$this->set('users', $users_data);
		// pr($results); die;
	}

	public function search()
	{
		$this->loadModel('Users');
		$req_datas = $_GET;
		$this->request->session()->write('req_data', $req_data);
		$this->request->session()->delete('req_data');
		$this->request->session()->write('req_data', $req_datas);
		$name = $req_datas['name'];
		$mobile = $req_datas['mobile'];
		$referral_code = $req_datas['referral_code'];
		$from_date = $req_datas['from_date'];
		$to_date = $req_datas['to_date'];
		$location = $req_datas['location'];
		$data = $this->Users->find('all')->where(['Users.role_id' => '3', 'Users.referral_code' => $referral_code])->order(['Users.id' => 'DESC'])->first();
		$user_data = $data['id'];
		$session = $this->request->session();
		$session->delete('cond');
		$cond = [];
		if (isset($name) && $name != '') {
			$cond['Users.name LIKE'] = '%' . trim($name) . '%';
		}
		if (isset($location) && $location != '') {
			$cond['Users.location_id'] = $location;
		}

		if (isset($mobile) && $mobile != '') {
			$cond['Users.mobile LIKE'] = '%' . trim($mobile) . '%';
		}

		if (isset($user_data) && $user_data != '') {
			$cond['Users.referred_user_id '] = trim($user_data);
		}

		if (isset($from_date) && $from_date != '') {
			$cond['DATE(Users.created) >='] = $from_date;
		}

		if (isset($to_date) && $to_date != '') {
			$cond['DATE(Users.created) <='] = $to_date;
		}
		$this->request->session()->write('cond', $cond);

		$user_data = $this->request->session()->read('Auth.User');
		if ($user_data['role_id'] == 2) {
			$usersTable = TableRegistry::getTableLocator()->get('Users');
			$query = $usersTable->find('all');
			$users = $query->select([
				'id' => 'Users.id',
				'name' => 'Users.name',
				'mobile' => 'Users.mobile',
				'referral_code' => 'Users.referral_code',
				'villagename' => 'Users.villagename',
				'animalCount' => 'Users.animalCount',
				'milkQuantity' => 'Users.milkQuantity',
				'referred_user_id' => 'Users.referred_user_id',
				'created' => 'Users.created',
				'user_id' => 'Users.id',
				'vendor_id' => 'Orders.vendor_id',
				'order_total' => $query->func()->sum('Orders.total_amount')
			])->join(['Orders' => ['table' => 'orders', 'type' => 'LEFT', 'conditions' => ['Orders.user_id = Users.id']]])->where(['Users.role_id' => 3, 'Orders.vendor_id' => $user_data['id'], $cond])->group('Users.id')->order(['order_total' => 'DESC']);
			$users_data = $this->paginate($users)->toArray();
		} else {
			$usersTable = TableRegistry::getTableLocator()->get('Users');
			$query = $usersTable->find('all');
			$users = $query->select([
				'id' => 'Users.id',
				'name' => 'Users.name',
				'location_id' => 'Users.location_id',
				'mobile' => 'Users.mobile',
				'referral_code' => 'Users.referral_code',
				'villagename' => 'Users.villagename',
				'animalCount' => 'Users.animalCount',
				'milkQuantity' => 'Users.milkQuantity',
				'referred_user_id' => 'Users.referred_user_id',
				'created' => 'Users.created',
				'user_id' => 'Users.id',
				'order_total' => $query->func()->sum('Orders.total_amount')
			])->join(['Orders' => ['table' => 'orders', 'type' => 'LEFT', 'conditions' => ['Orders.user_id = Users.id']]])->where(['Users.role_id' => 3, $cond])->group('Users.id')->order(['order_total' => 'DESC']);
			$users_data = $this->paginate($users)->toArray();
			// pr($users_data);exit;
		}
		$this->set('users', $users_data);
	}

	public function status($id, $status)
	{
		$this->loadModel('Users');
		if (isset($id) && !empty($id)) {
			$product = $this->Users->get($id);
			$product->status = $status;
			if ($this->Users->save($product)) {
				if ($status == '1') {
					$this->Flash->success(__('Customer status has been Activeted.'));
				} else {
					$this->Flash->success(__('Customer status has been Deactiveted.'));
				}
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function customeredit($user_id = null)
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Users');
		$this->loadModel('Products');
		$this->loadModel('ProductAddons');
		$this->loadModel('ProductCommision');
		$this->loadModel('ProductImages');
		$this->loadModel('Locations');
		$this->loadModel('Servicearea');

		$locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
		$this->set(compact('locations'));

		$user = $this->Users->get($user_id);
		$this->set('vendor_data', $user);
		// pr($user);exit;
		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);exit;
			$location_exists = $this->Servicearea->find('all')->where(['Servicearea.location_id' => $this->request->data['location'], 'Servicearea.vendor_id IS NOT NULL'])->first();
			if ($location_exists) {
				$this->Flash->error(__('This Location is alreday assinged another vendor.'));
				return $this->redirect(['action' => 'customeredit/' . $user_id . '']);
			} else {
				// Get the model instance
				$serviceArea = $this->Servicearea;
				// Update the record
				$serviceArea->updateAll(
					['vendor_id' => $user_id],
					['location_id' => $this->request->getData('location')]
				);
			}

			$products = $this->Products->find('all')->where(['vendor_id' => 1])->toArray();
			// duplicate product copy code
			foreach ($products as $product_clone) {
				$newpack = $this->Products->newEntity();
				$data['vendor_id'] = $user_id;
				$data['main_product_id'] = $product_clone['id'];
				$data['name'] = $product_clone['name'];
				$data['brand_name'] = $product_clone['brand_name'];
				$data['measurement'] = $product_clone['measurement'];
				$data['hsn'] = $product_clone['hsn'];
				$data['tax_status'] = $product_clone['tax_status'];
				$data['description'] = $product_clone['description'];
				$data['status'] = $product_clone['status'];
				$savepack = $this->Products->patchEntity($newpack, $data);
				$results = $this->Products->save($savepack);
				// product add-on copy code
				if ($results) {
					$product_addons = $this->ProductAddons->find('all')->where(['product_id' => $product_clone['id']])->toarray();
					foreach ($product_addons as  $pro_add_on) {
						$options = $this->ProductAddons->newEntity();
						$prop_data['product_id'] = $results['id'];
						$prop_data['name'] = $pro_add_on['name'];
						$prop_data['price'] = $pro_add_on['price'];
						$option_arr = $this->ProductAddons->patchEntity($options, $prop_data);
						$savedata = $this->ProductAddons->save($option_arr);
					}
					if ($savedata) {
						$Product_Commision = $this->ProductCommision->find('all')->where(['product_id' => $product_clone['id']])->toarray();
						foreach ($Product_Commision as  $prod_comission) {
							$options = $this->ProductCommision->newEntity();
							$prop_data['product_id'] = $results['id'];
							$prop_data['user_id'] = 0;
							$prop_data['fixed'] = $prod_comission['fixed'];
							$prop_data['percentage'] = $prod_comission['percentage'];
							$option_arr = $this->ProductCommision->patchEntity($options, $prop_data);
							$savedata = $this->ProductCommision->save($option_arr);
						}
					}
				}
				$product_addon_image = $this->ProductImages->find('all')->where(['product_id' => $product_clone['id']])->toarray();
				foreach ($product_addon_image as $pro_image) {
					$newpack = $this->ProductImages->newEntity();
					$data['product_id'] = $results['id'];
					$data['image'] = $pro_image['image'];
					$savepack = $this->ProductImages->patchEntity($newpack, $data);
					$this->ProductImages->save($savepack);
				}
			}
			$password = $user['mobile'];
			$hasher = new DefaultPasswordHasher();
			$newpassword = $hasher->hash($password);
			$user->password = $newpassword;
			$user->role_id = 2;
			$user->name = $this->request->data['name'];
			$user->mobile = $this->request->data['mobile'];
			$user->email = $this->request->data['email'];
			$user->villagename = $this->request->data['villagename'];
			$user->animalCount = $this->request->data['animalCount'];

			if ($this->Users->save($user)) {
				$this->Flash->success(__('You are a Vendor'));
				return $this->redirect(['controller' => 'vendor', 'action' => 'index']);
			}
		}
	}

	//Export Customer Manager
	public function customerexcel()
	{
		$where = $this->request->session()->read('cond');
		if (isset($where)) {
			$data = $this->Users->find('all')->where(['role_id' => 3, $where])->order(['Users.id' => 'DESC'])->toarray();
			$this->set('data', $data);
			$this->request->session()->delete('cond');
		} else {
			$data = $this->Users->find('all')->where(['role_id' => 3])->order(['Users.id' => 'DESC'])->toarray();
			$this->set('data', $data);
		}
	}
	public function totalorder($id = null)
	{
		$session = $this->request->session();
		$session->delete('cond');
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Users');
		$this->loadmodel('Orders');
		$user = $this->request->session()->read('Auth.User');
		$order = $this->request->session()->read('Auth.Order');
		$data = $this->Orders->find('all')->where(['Orders.user_id' => $id])->toarray();
		$this->set('data', $data);
	}
}
