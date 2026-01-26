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
use \Datetime;

class DashboardsController extends AppController
{

	public function login()
	{
		$this->viewBuilder()->layout('login');
		return $this->redirect('/logins');
	}

	public function index()
	{
		$this->loadModel('Products');
		$this->loadModel('Users');
		$this->loadModel('Orders');
		$this->viewBuilder()->layout('admin');

		$user_data = $this->request->session()->read('Auth.User');
		if ($user_data['role_id'] == 2) {

			//Get vendor id base product count
			$total_product = $this->Products->find('all')->where(['vendor_id' => $user_data['id']])->count();

			//Get vendor id base Orders count
			$order = $this->Orders->find('all')->where(['vendor_id' => $user_data['id']])->count();

			//Get vendor id base show last added 3 products
			$products = $this->Products->find('all')->where(['vendor_id' => $user_data['id']])->order(['Products.id' => 'DESC'])->limit('3')->toarray();

			//Get vendor id base user data count
			$usersTable = TableRegistry::getTableLocator()->get('Users');
			$user_id = $user_data['id']; 
			$query = $usersTable->find()
				->matching('Orders', function ($q) use ($user_id) {
					return $q->where(['Orders.vendor_id' => $user_id]);
				})->group(['Users.id'])->count();
			$total_customer = $query;
			
			//Get vendor id base user details data
			$usersTable = TableRegistry::getTableLocator()->get('Users');
			$user_id = $user_data['id']; 
			$query = $usersTable->find()
				->matching('Orders', function ($q) use ($user_id) {
					return $q->where(['Orders.vendor_id' => $user_id]);
				})
				->group(['Users.id'])
				->order(['Users.id' => 'DESC']) 
				->limit(3); 
			$users = $query->toArray();
		
		} else {
			//for admin show total products count
			$total_product = $this->Products->find('all')->where(['vendor_id' =>1])->count();

			//for admin show total orders count
			$order = $this->Orders->find('all')->count();

			//for admin show last added 3 products.
			$products = $this->Products->find('all')->order(['Products.id' => 'DESC'])->limit('3')->toarray();

			//for admin show total customer count 
			$total_customer = $this->Users->find('all')->where(['role_id' => 3])->order(['Users.id' => 'DESC'])->count();

			//for admin show last 3 new customers.
			$users = $this->Users->find('all')->where(['role_id' => 3])->order(['Users.id' => 'DESC'])->limit('3')->toarray();
		
		}	

		//all query data set
		$this->set('Products', $products);
		$this->set('order', $order);
		$this->set('total_product', $total_product);
		$this->set('total_customer', $total_customer);
		$this->set('users', $users);


		//only use in admin side
		$total_vendor = $this->Users->find('all')->where(['role_id NOT IN' => [1, 3, 4]])->order(['Users.id' => 'DESC'])->count();
		$this->set('total_vendor', $total_vendor);

		// $customer = $this->Users->find('all')->count();
		// $this->set('users', $customer);

	
	}

	public function status($id, $status)
	{
		$this->loadModel('Products');
		if (isset($id) && !empty($id)) {
			$product = $this->Products->get($id);
			$product->status = $status;
			if ($this->Products->save($product)) {
				if ($status == '1') {
					$this->Flash->success(__('Product status has been Activeted.'));
				} else {
					$this->Flash->success(__('Product status has been Deactiveted.'));
				}
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function edit($id)
	{
		$this->loadModel('Products');
		$this->viewBuilder()->layout('admin');
		$Products = $this->Products->get($id);
		$this->set('Products', $Products);
		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die; 
			$savepack = $this->Products->patchEntity($Products, $this->request->data);
			$results = $this->Products->save($savepack);
			if ($results) {
				$this->Flash->success(__('Products has been updated.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('Products not Updated.'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function add()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Products');
		$this->loadModel('ProductImages');
		$this->loadModel('ProductAddons');
		$newpack = $this->Products->newEntity();
		//pr($newpack); die;
		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
			// pr($this->request->data['image']); die;


			$savepack = $this->Products->patchEntity($newpack, $this->request->data);
			$results = $this->Products->save($savepack);
			if ($results) {
				// fetching multiple images and saving it to product_images
				foreach ($this->request->data['image'] as $value) {
					$k = $value;
					$galls = $this->move_images($k, 'images/product_images/');
					$value = $galls[0];
					unlink('compress/' . $galls[0]);
					$data['image'] = $galls[0];
					$data['product_id'] = $results['id'];
					$newpack = $this->ProductImages->newEntity();
					//pr(); die;
					$savepack = $this->ProductImages->patchEntity($newpack, $data);
					$result = $this->ProductImages->save($savepack);
				}
				$packaging_count = count($this->request->data['current']['packaging']);
				if ($this->request->data['current']['packaging'][0]) {
					for ($i = 0; $i < $packaging_count; $i++) {
						$prop_data['product_id'] = $results['id'];
						$prop_data['name'] = $this->request->data['current']['packaging'][$i];
						$prop_data['price'] = $this->request->data['current']['price'][$i];
						//pr($prop_bookanartist_data); 
						if ($this->request->data['current']['hid'][$i] > 0) {
							$options = $this->ProductAddons->get($this->request->data['current']['hid'][$i]);
							$option_arr = $this->ProductAddons->patchEntity($options, $prop_data);
							$savedata = $this->ProductAddons->save($option_arr);
						} else {
							$options = $this->ProductAddons->newEntity();
							$option_arr = $this->ProductAddons->patchEntity($options, $prop_data);
							$savedata = $this->ProductAddons->save($option_arr);
						}
					}
				}
				$this->Flash->success(__('Product has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('Product not saved.'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}
	public function delete($id)
	{
		$this->loadModel('Products');
		$catdelete = $this->Products->get($id);
		if ($catdelete) {
			$this->Products->deleteAll(['Products.id' => $id]);
			$this->Products->delete($catdelete);

			$this->Flash->success(__('Products has been deleted successfully.'));
			return $this->redirect(['action' => 'index']);
		}
	}


	public function user_status($id,$status){

		$this->loadModel('Users');
		if(isset($id) && !empty($id)){
		  $product = $this->Users->get($id);
		  $product->status = $status;
		  if ($this->Users->save($product)) {
			if($status=='1'){
			  $this->Flash->success(__('User status has been Activeted.'));
			}else{
			  $this->Flash->success(__('User status has been Deactiveted.'));
			}
			return $this->redirect(['action' => 'index']);  
		  }
		}
	  }

}


