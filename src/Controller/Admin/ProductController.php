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
use Cake\Collection\Collection;


class ProductController extends AppController
{

	public function login()
	{
		$this->viewBuilder()->layout('login');
		return $this->redirect('/logins');
	}


	public function index()
	{
		$this->loadModel('Products');
		$this->loadModel('OrderDetails');
		$this->loadModel('Users');
		$this->loadModel('Locations');
	    $this->loadModel('Servicearea');
		$this->viewBuilder()->layout('admin');

		$locations = $this->Locations->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
		$this->set(compact('locations'));

		$user_data = $this->request->session()->read('Auth.User');
		if ($user_data['role_id'] == 2) {
			$products = $this->Products->find('all')->contain(['Users', 'OrderDetails' => 'Orders'])->where(['Products.vendor_id' => $user_data['id']])->toArray();
		} else {
			$products = $this->Products->find('all')->contain(['Users', 'OrderDetails' => 'Orders'])->where(['Products.vendor_id' => 1])->toArray();
		}

		$val = array();
		foreach ($products as $key =>  $value) {

			if ($user_data['role_id'] == 1) {
				$vendorProdIds = $this->Products->find('list', [
					'fields' => ['id'], // Select only the 'id' field
				])->where(['main_product_id' => $value['id']])->toArray();

				$orders = $this->OrderDetails->find('all')->contain(['Orders'])->select(['sum' => 'SUM(OrderDetails.total_price)'])->where(['OrderDetails.product_id IN' => array_keys($vendorProdIds)])->first();
			
				$vendorIds = $this->Products->find('list', [
					'keyField' => 'id', // Select only the 'id' field
					'valueField' => 'vendor_id',
				])->where(['main_product_id' => $value['id']])->toArray();
			}else{
				$vendorProdIds = $this->Products->find('list', [
					'fields' => ['id'], // Select only the 'id' field
				])->where(['id' => $value['id']])->toArray();

				$orders = $this->OrderDetails->find('all')->contain(['Orders'])->select(['sum' => 'SUM(OrderDetails.total_price)'])->where(['OrderDetails.product_id IN' => array_keys($vendorProdIds)])->first();
			
				$vendorIds = $this->Products->find('list', [
					'keyField' => 'id', // Select only the 'id' field
					'valueField' => 'vendor_id',
				])->where(['id' => $value['id']])->toArray();
			}

			$locationIds = $this->Servicearea->find('list', [
				'keyField' => 'id', // Select only the 'id' field
				'valueField' => 'location_id',
			])->where(['Servicearea.vendor_id IN' => array_values($vendorIds)])->group('vendor_id')->toArray();

			$locationNames = $this->Locations->find()
				->select(['name']) // Select only the 'name' field
				->where(['Locations.id IN' => array_values($locationIds)])
				->toArray();
			$collection = new Collection($locationNames);
			$commaSeparatedNames = $collection->combine('name', 'name')->toList();
			$commaSeparatedNames = implode(', ', $commaSeparatedNames);
			
			$val[$key]['id'] = $value['id'];
			$val[$key]['name'] = $value['name'];
			$val[$key]['brand_name'] = $value['brand_name'];
			$val[$key]['measurement'] = $value['measurement'];
			$val[$key]['hsn'] = $value['hsn'];
			$val[$key]['locality'] = $commaSeparatedNames;
			$val[$key]['sum'] = $orders['sum'];
			$val[$key]['created'] = $value['created'];
			$val[$key]['status'] = $value['status'];
		}
		// Sort the $val array in descending order based on 'sum'
		usort($val, function ($a, $b) {
			return $b['sum'] - $a['sum'];
		});
		$this->set('Products', $val);
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
		$this->loadModel('ProductImages');
		$this->loadModel('ProductAddons');
		$this->viewBuilder()->layout('admin');

		$Products = $this->Products->find()->where(['Products.id' => $id])->contain(['ProductImages'])->first();
		$this->set('Products', $Products);
		$product_addons = $this->ProductAddons->find('all')->where(['product_id' => $id])->toarray();
		$this->set('product_addons', $product_addons);
		if ($this->request->is(['post', 'put'])) {
         
			$savepack = $this->Products->patchEntity($Products, $this->request->data);
			$results = $this->Products->save($savepack);
			if ($this->request->data['image'][0]['tmp_name'] != '') {
				foreach ($this->request->data['image'] as $value) {
					$k = $value;
					$galls = $this->move_images($k, 'images/product_images/');
					$value = $galls[0];
					unlink('compress/' . $galls[0]);
					$data['image'] = $galls[0];
					$data['product_id'] = $results['id'];
					$newpack = $this->ProductImages->newEntity();
					$savepack = $this->ProductImages->patchEntity($newpack, $data);
					$result = $this->ProductImages->save($savepack);
				}
			}

			if ($results) {

				//update vendors product data START
				$authUSer = $this->request->session()->read('Auth.User');
				if ($authUSer['id'] == 1 && $authUSer['role_id'] == 1) {
					$Products = $this->Products->find()->where(['Products.main_product_id' => $id])->toarray();
					if ($this->request->is(['post', 'put'])) {
						foreach ($Products as $Product) {
							$this->request->data['name'] = $this->request->data['name'];
							$this->request->data['brand_name'] = $this->request->data['brand_name'];
							$this->request->data['measurement'] = $this->request->data['measurement'];
							$this->request->data['hsn'] = $this->request->data['hsn'];
							$this->request->data['description'] = $this->request->data['description'];
							$savepack = $this->Products->patchEntity($Product, $this->request->data);
							$this->Products->save($savepack);
							// pr($this->request->data['image']);exit;

							//To Product Images
							$product_images = $this->ProductImages->find('all')->where(['product_id' => $id])->toarray();
							foreach ($product_images as $pro_image) {
								$newpack = $this->ProductImages->newEntity();
								$data['product_id'] = $Product['id'];
								$data['image'] = $pro_image['image'];
								$savepack = $this->ProductImages->patchEntity($newpack, $data);
								$this->ProductImages->save($savepack);
							}


						}
					}
				}
				//End


				$this->ProductAddons->deleteAll(['ProductAddons.product_id' => $id]);
				$packaging_count = count($this->request->data['current']['packaging']);
				// pr($packaging_count);exit;
				if ($this->request->data['current']['packaging'][0]) {
					for ($i = 0; $i < $packaging_count; $i++) {
	
						// if($authUSer['id'] == 1){
						// //Update vendors products pricing if the vendor does not change the pricing
						// $mainProductId = $results['id'];
						// $vendorProdIds = $this->Products->find('list', [
						// 	'fields' => ['id'], // Select only the 'id' field
						// ])->where(['main_product_id' => $mainProductId])->toArray();

						// $vendorProAddons = $this->ProductAddons->find('all', [
						// 	'conditions' => [
						// 		'ProductAddons.product_id IN' => array_keys($vendorProdIds),
						// 		'ProductAddons.name' => $this->request->data['current']['packaging'][$i],
						// 		'ProductAddons.price' => $this->request->data['current']['price'][$i],
						// 	]
						// ])->toArray();
						// pr($vendorProAddons); die;
			
						// foreach($vendorProAddons as $updateAddons){
						// 	$updateAddonsData['name'] = $this->request->data['current']['price'][$i];
						// 	$savepack1 = $this->ProductAddons->patchEntity($updateAddons, $updateAddonsData);
						// 	$this->ProductAddons->save($savepack1);
						// }
				
						
						// }

						$prop_data['product_id'] = $results['id'];
						$prop_data['name'] = $this->request->data['current']['packaging'][$i];
						$prop_data['price'] = $this->request->data['current']['price'][$i];
						$options = $this->ProductAddons->newEntity();

						$option_arr = $this->ProductAddons->patchEntity($options, $prop_data);
						// pr($option_arr);
						$this->ProductAddons->save($option_arr);
					} //exit;
				}
				$this->Flash->success(__('Product Image has been updated.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('gallary Of Featured Image has not been Updated.'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}
	//Delete Product Images
	public function deleteimg($id)
	{
		$this->loadModel('ProductImages');
		$this->loadModel('Products');

		$deleteimages = $this->ProductImages->get($id);
		if ($deleteimages) {
			unlink('images/product_images/' . $deleteimages['image']);

			//to delete all vendor images also Start
			$this->ProductImages->deleteAll(['ProductImages.image' => $deleteimages['image']]);
	
			$this->Flash->success(__('Image has been deleted successfully.'));
			$this->redirect($this->referer());
		}
	}


	public function add()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Products');
		$this->loadModel('ProductImages');
		$this->loadModel('ProductAddons');
		$this->loadModel('Users');
		$newpack = $this->Products->newEntity();
		//pr($newpack); die;
		if ($this->request->is(['post', 'put'])) {

			$this->request->data['main_product_id'] = 0;
			$this->request->data['vendor_id'] = $this->request->session()->read('Auth.User.id');
			// pr($this->request->data);die;
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
					for ($i = 0; $i < $packaging_count; $i++) { //echo $results['id']; die;

						if ($this->request->data['current']['packaging'][$i] && $this->request->data['current']['price'][$i]) {
							$prop_data['product_id'] = $results['id'];
							$prop_data['name'] = $this->request->data['current']['packaging'][$i];
							$prop_data['price'] = $this->request->data['current']['price'][$i];

							$options = $this->ProductAddons->newEntity();
							$option_arr = $this->ProductAddons->patchEntity($options, $prop_data);
							$savedata = $this->ProductAddons->save($option_arr);
						}
					}
				}
				//Assign this product to vendor START
				$all_vendors =  $this->Users->find('all')->where(['role_id' => 2])->toArray();
				foreach ($all_vendors as  $vendor) {
					$new_product = $this->Products->find('all')->where(['id' => $results['id']])->first();
					$newpack = $this->Products->newEntity();
					$v_pro_data['vendor_id'] = $vendor['id'];
					$v_pro_data['main_product_id'] = $new_product['id'];
					$v_pro_data['name'] = $new_product['name'];
					$v_pro_data['brand_name'] = $new_product['brand_name'];
					$v_pro_data['measurement'] = $new_product['measurement'];
					$v_pro_data['hsn'] = $new_product['hsn'];
					$v_pro_data['tax_status'] = $new_product['tax_status'];
					$v_pro_data['description'] = $new_product['description'];
					$v_pro_data['status'] = $new_product['status'];
					$v_pro_savepack = $this->Products->patchEntity($newpack, $v_pro_data);
					$v_pro_results = $this->Products->save($v_pro_savepack);

					if ($v_pro_results) {
						//To Save Addons
						$product_addons = $this->ProductAddons->find('all')->where(['product_id' => $new_product['id']])->toarray();
						foreach ($product_addons as  $pro_add_on) {
							$options = $this->ProductAddons->newEntity();
							$prop_data['product_id'] = $v_pro_results['id'];
							$prop_data['name'] = $pro_add_on['name'];
							$prop_data['price'] = $pro_add_on['price'];
							$option_arr = $this->ProductAddons->patchEntity($options, $prop_data);
							$savedata = $this->ProductAddons->save($option_arr);
						}

						//To Product Images
						$product_images = $this->ProductImages->find('all')->where(['product_id' => $new_product['id']])->toarray();
						foreach ($product_images as $pro_image) {
							$newpack = $this->ProductImages->newEntity();
							$data['product_id'] = $v_pro_results['id'];
							$data['image'] = $pro_image['image'];
							$savepack = $this->ProductImages->patchEntity($newpack, $data);
							$this->ProductImages->save($savepack);
						}
					}
				}
				//Assign this product to vendor END


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

	// public function search()
	// {
	// 	$this->loadModel('Products');
	// 	$this->loadModel('OrderDetails');
	// 	$this->loadModel('Orders');
	// 	$name = $this->request->data['name'];
	// 	$location = $this->request->data['location'];
	// 	$cond = [];
	// 	if (isset($name) && $name != '') {
	// 		$cond['Products.name LIKE'] = '%' . trim($name) . '%';
	// 	}
	// 	// if (isset($location) && $location != '') {
	// 	// 	$cond['OrderDetails' => 'Orders.locality LIKE'] = '%' . trim($location) . '%';
	// 	// }
	// 	// $products = $this->OrderDetails->find('all')->contain(['Products', 'Orders'])->where([$cond])->order(['Products.id' => 'DESC'])->group(['OrderDetails.product_id'])->toarray();
	// 	// $this->set('Products', $products);
	// 	// $search = array();
	// 	// foreach ($products as $key => $values) {
	// 	// 	$orders = $this->OrderDetails->find('all')->contain(['Orders'])->select(['sum' => 'SUM(Orders.total_amount)'])->where(['OrderDetails.product_id' => $values['product']['id']])->first();
	// 	// 	$search[$key]['id'] = $values['product']['id'];
	// 	// 	$search[$key]['name'] = $values['product']['name'];
	// 	// 	$search[$key]['brand_name'] = $values['product']['brand_name'];
	// 	// 	$search[$key]['measurement'] = $values['product']['measurement'];
	// 	// 	$search[$key]['hsn'] = $values['product']['hsn'];
	// 	// 	$search[$key]['locality'] = $values['order']['locality'];
	// 	// 	$search[$key]['sum'] = $orders['sum'];
	// 	// 	$search[$key]['created'] = $values['product']['created'];
	// 	// 	$search[$key]['status'] = $values['product']['status'];
	// 	// }
	// 	// usort($search, function ($a, $b) {
	// 	// 	return $b['sum'] - $a['sum'];
	// 	// });
	// 	$user_id = $this->request->session()->read('Auth.User.id');
	// 	$products = $this->Products->find('all')->contain(['Users', 'OrderDetails' => 'Orders'])->where(['Products.vendor_id' => $user_id, $cond])->toArray();
	// 	$val = array();
	// 	foreach ($products as $key =>  $value) {

	// 		$orders = $this->OrderDetails->find('all')->contain(['Orders'])->select(['sum' => 'SUM(Orders.total_amount)'])->where(['OrderDetails.product_id' => $value['id']])->first();

	// 		$val[$key]['id'] = $value['id'];
	// 		$val[$key]['name'] = $value['name'];
	// 		$val[$key]['brand_name'] = $value['brand_name'];
	// 		$val[$key]['measurement'] = $value['measurement'];
	// 		$val[$key]['hsn'] = $value['hsn'];
	// 		$val[$key]['locality'] = $value['order_details'][0]['order']['locality'];
	// 		$val[$key]['sum'] = $orders['sum'];
	// 		$val[$key]['created'] = $value['created'];
	// 		$val[$key]['status'] = $value['status'];
	// 	}
	// 	// Sort the $val array in descending order based on 'sum'
	// 	usort($val, function ($a, $b) {
	// 		return $b['sum'] - $a['sum'];
	// 	});
	// 	$this->set('Products', $val);
	// }

	public function search()
	{
		$this->loadModel('Products');
		$this->loadModel('OrderDetails');
		$this->loadModel('Users');
		$this->loadModel('Locations');
	    $this->loadModel('Servicearea');
		// $this->viewBuilder()->layout('admin');

		$name = $this->request->data['name'];
		$location = $this->request->data['location'];
		$cond = [];
		if (isset($name) && $name != '') {
			$cond['Products.name LIKE'] = '%' . trim($name) . '%';
		}

		$user_data = $this->request->session()->read('Auth.User');
		if ($user_data['role_id'] == 2) {
			$products = $this->Products->find('all')->contain(['Users', 'OrderDetails' => 'Orders'])->where(['Products.vendor_id' => $user_data['id'], $cond])->toArray();
		} else {
			$products = $this->Products->find('all')->contain(['Users', 'OrderDetails' => 'Orders'])->where(['Products.vendor_id' => 1, $cond])->toArray();
		}

		$val = array();
		foreach ($products as $key =>  $value) {

			if ($user_data['role_id'] == 1) {
				$vendorProdIds = $this->Products->find('list', [
					'fields' => ['id'], // Select only the 'id' field
				])->where(['main_product_id' => $value['id']])->toArray();

				$orders = $this->OrderDetails->find('all')->contain(['Orders'])->select(['sum' => 'SUM(OrderDetails.total_price)'])->where(['OrderDetails.product_id IN' => array_keys($vendorProdIds)])->first();
			
				$vendorIds = $this->Products->find('list', [
					'keyField' => 'id', // Select only the 'id' field
					'valueField' => 'vendor_id',
				])->where(['main_product_id' => $value['id']])->toArray();
			}else{
				$vendorProdIds = $this->Products->find('list', [
					'fields' => ['id'], // Select only the 'id' field
				])->where(['id' => $value['id']])->toArray();

				$orders = $this->OrderDetails->find('all')->contain(['Orders'])->select(['sum' => 'SUM(OrderDetails.total_price)'])->where(['OrderDetails.product_id IN' => array_keys($vendorProdIds)])->first();
			
				$vendorIds = $this->Products->find('list', [
					'keyField' => 'id', // Select only the 'id' field
					'valueField' => 'vendor_id',
				])->where(['id' => $value['id']])->toArray();
			}

			$locationIds = $this->Servicearea->find('list', [
				'keyField' => 'id', // Select only the 'id' field
				'valueField' => 'location_id',
			])->where(['Servicearea.vendor_id IN' => array_values($vendorIds)])->group('vendor_id')->toArray();

			$locationNames = $this->Locations->find()
				->select(['name']) // Select only the 'name' field
				->where(['Locations.id IN' => array_values($locationIds)])
				->toArray();
			$collection = new Collection($locationNames);
			$commaSeparatedNames = $collection->combine('name', 'name')->toList();
			$commaSeparatedNames = implode(', ', $commaSeparatedNames);
			
			$val[$key]['id'] = $value['id'];
			$val[$key]['name'] = $value['name'];
			$val[$key]['brand_name'] = $value['brand_name'];
			$val[$key]['measurement'] = $value['measurement'];
			$val[$key]['hsn'] = $value['hsn'];
			$val[$key]['locality'] = $commaSeparatedNames;
			$val[$key]['sum'] = $orders['sum'];
			$val[$key]['created'] = $value['created'];
			$val[$key]['status'] = $value['status'];
		}
		// Sort the $val array in descending order based on 'sum'
		usort($val, function ($a, $b) {
			return $b['sum'] - $a['sum'];
		});
		$this->set('Products', $val);
	}





}
