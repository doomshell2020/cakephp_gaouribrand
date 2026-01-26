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

class VendorController extends AppController
{

	public function login()
	{
		$this->viewBuilder()->layout('login');
		return $this->redirect('/logins');
	}

	public function index()
	{
		$this->loadModel('Users');
		$this->loadModel('Locations');
		$this->viewBuilder()->layout('admin');
		$locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
		$this->set(compact('locations'));
		$users = $this->Users->find('all')->where(['Users.role_id' => '2'])->order(['Users.id' => 'DESC'])->toarray();
		$this->set('users', $users);
	}


	public function search()
	{
		$this->loadModel('Users');
		$user = $this->request->session()->read('Auth.User');
		$name = $this->request->data['name'];
		$mobile = $this->request->data['mobile'];
		//pr($name); die;
		$cond = [];
		if (isset($name) && $name != '') {
			$cond['Users.name LIKE'] = '%' . trim($name) . '%';
		}

		if (isset($mobile) && $mobile != '') {
			$cond['Users.mobile LIKE'] = '%' . trim($mobile) . '%';
		}
		// pr($cond); die;

		$users = $this->Users->find('all')->where(['Users.role_id' => '3', $cond])->order(['Users.id' => 'DESC'])->toarray();
		$this->set('users', $users);
	}
	public function status($id, $status)
	{

		$this->loadModel('Users');
		if (isset($id) && !empty($id)) {
			$product = $this->Users->get($id);
			$product->status = $status;
			if ($this->Users->save($product)) {
				if ($status == '1') {
					$this->Flash->success(__('User status has been Activeted.'));
				} else {
					$this->Flash->success(__('User status has been Deactiveted.'));
				}
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function commision($id)
	{
		$this->loadModel('Products');
		$this->loadModel('ProductCommision');
		$this->viewBuilder()->layout('admin');

		$products = $this->Products->find('all')->contain(['ProductCommision'])->order(['Products.id' => 'DESC'])->toarray();
		//pr($products); die;
		$this->set('Products', $products);
	}


	public function update_all_commision()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('ProductCommision');

		//fetching Multi data from array
		$commision_count = count($this->request->data['commision']['product_id']);
		if ($this->request->data['commision']['product_id'][0]) {
			for ($i = 0; $i < $commision_count; $i++) {
				//fetching Single data from array

				if ($this->request->data['commision']['fixed'][$i] != 0 && $this->request->data['commision']['percentage'][$i]) {
					$prop_data['product_id'] = $this->request->data['commision']['product_id'][$i];
					$prop_data['user_id'] = 0;
					$prop_data['fixed'] = $this->request->data['commision']['fixed'][$i];
					$prop_data['percentage'] = $this->request->data['commision']['percentage'][$i];

					$is_edit = $this->ProductCommision->find('all')->where(['product_id' => $this->request->data['commision']['product_id'][$i]])->first();
					//pr($is_edit); die;
					if ($is_edit) {
						$option_arr = $this->ProductCommision->patchEntity($is_edit, $prop_data);
						$savedata = $this->ProductCommision->save($option_arr);
					} else {
						$options = $this->ProductCommision->newEntity();
						$option_arr = $this->ProductCommision->patchEntity($options, $prop_data);
						$savedata = $this->ProductCommision->save($option_arr);
					}
				}
			}

			$this->Flash->success(__('commision has been updated.'));
			return $this->redirect(['action' => 'index']);
		}
	}
	// for vendor edit
	public function vendoredit($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('Products');
		$this->loadModel('ProductAddons');
		$this->loadModel('ProductCommision');
		$this->loadModel('ProductImages');
		$this->loadModel('Locations');
		$this->loadModel('Servicearea');

		$this->viewBuilder()->layout('admin');
		$users_data = $this->Users->get($id);
		$this->set('vendor_data', $users_data);
		$this->set('id', $id);
		$locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
		$this->set(compact('locations'));

		if ($this->request->is(['post', 'put'])) {

			$location_exists = $this->Servicearea->find('all')->where(['Servicearea.location_id' => $this->request->data['location'], 'Servicearea.vendor_id IS NOT NULL'])->first();
			if ($location_exists) {
				$this->Flash->error(__('This Location is alreday assinged another vendor.'));
				return $this->redirect(['action' => 'vendoredit/' . $id . '']);
			} else {
				// Get the model instance
				$serviceArea = $this->Servicearea;
				// Update the record
				$serviceArea->updateAll(
					['vendor_id' => $id], // New field values
					['location_id' => $this->request->getData('location')] // Conditions
				);
			}

			$savepack = $this->Users->patchEntity($users_data, $this->request->getData());
			$this->Users->save($savepack);
			$this->Flash->success(__('User Profile has been updated.'));
			return $this->redirect(['action' => 'index']);
		}
	}
}
