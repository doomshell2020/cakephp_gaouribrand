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

class FaqController extends AppController
{

	public function login()
	{
		$this->viewBuilder()->layout('login');
		return $this->redirect('/logins');
	}

	public function index()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('faq_cat');
		$faq_cat = $this->faq_cat->find('all')->order(['faq_cat.id']);
		$this->set('faq_cat', $this->paginate($faq_cat)->toarray());
	}

	public function add()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('faq_cat');
		$newpack = $this->faq_cat->newEntity();
		//pr($newpack); die;
		if ($this->request->is(['post', 'put'])) {
			$savepack = $this->faq_cat->patchEntity($newpack, $this->request->data);
			$results = $this->faq_cat->save($savepack);
			if ($results) {
				$this->Flash->success(__('FAQ has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('FAQ not saved.'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function question()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('FaqCatQuestion');
		$this->loadModel('Faq');
		$faq_cat_question = $this->FaqCatQuestion->find('all')->contain(['Faq'])->order(['FaqCatQuestion.id' => 'DESC']);
		$this->set('faq_cat_question', $this->paginate($faq_cat_question)->toarray());
		$ques = $this->Faq->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toarray();
		// pr($ques);die;
		$this->set('ques', $ques);
	}

	public function question_add()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('FaqCatQuestion');
		$this->loadModel('faq_cat');
		$newpack = $this->FaqCatQuestion->newEntity();

		$faq_cat = $this->faq_cat->find('list')->order(['faq_cat.id'])->toarray();
		$this->set('faq_cat', $faq_cat);

		//pr($newpack); die;
		if ($this->request->is(['post', 'put'])) {

			$savepack = $this->FaqCatQuestion->patchEntity($newpack, $this->request->data);
			$results = $this->FaqCatQuestion->save($savepack);
			//pr($results); die;
			if ($results) {
				$this->Flash->success(__('FAQ has been saved.'));
				return $this->redirect(['action' => 'question']);
			} else {
				$this->Flash->error(__('FAQ not saved.'));
				return $this->redirect(['action' => 'question']);
			}
		}
	}

	public function question_status($id, $question_status)
	{
		//echo $question_status; die; 
		$this->loadModel('FaqCatQuestion');
		if (isset($id) && !empty($id)) {
			$products = $this->FaqCatQuestion->get($id);
			$products->status = $question_status;
			//pr($products); die;
			if ($this->FaqCatQuestion->save($products)) {
				if ($question_status == 'Y') {
					$this->Flash->success(__('FAQ Question status has been Activeted.'));
				} else {
					$this->Flash->success(__('FAQ Question status has been Deactiveted.'));
				}
				return $this->redirect(['action' => 'question']);
			}
		}
	}

	public function status($id, $status)
	{

		$this->loadModel('faq_cat');
		if (isset($id) && !empty($id)) {
			$product = $this->faq_cat->get($id);
			$product->status = $status;
			if ($this->faq_cat->save($product)) {
				if ($status == '1') {
					$this->Flash->success(__('FAQ status has been Activeted.'));
				} else {
					$this->Flash->success(__('FAQ status has been Deactiveted.'));
				}
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function question_delete($id)
	{
		$this->loadModel('FaqCatQuestion');
		$delete = $this->FaqCatQuestion->get($id);
		if ($delete) {

			$this->FaqCatQuestion->deleteAll(['FaqCatQuestion.id' => $id]);
			$this->FaqCatQuestion->delete($delete);

			$this->Flash->success(__('FAQ Question has been deleted successfully.'));
			return $this->redirect(['action' => 'question']);
		}
	}

	public function delete($id)
	{
		$this->loadModel('faq_cat');
		$catdelete = $this->faq_cat->get($id);
		if ($catdelete) {

			$this->faq_cat->deleteAll(['faq_cat.id' => $id]);
			$this->faq_cat->delete($catdelete);

			$this->Flash->success(__('FAQ has been deleted successfully.'));
			return $this->redirect(['action' => 'index']);
		}
	}

	public function question_edit($id)
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('FaqCatQuestion');
		$this->viewBuilder()->layout('admin');
		$this->loadModel('faq_cat');

		$faq_cat_question = $this->FaqCatQuestion->get($id);
		$faq_cat = $this->faq_cat->find('list')->order(['faq_cat.id'])->toarray();
		$this->set('faq_cat', $faq_cat);
		$this->set('FaqCatQuestion', $faq_cat_question);
		if ($this->request->is(['post', 'put'])) {
		
			$savepack = $this->FaqCatQuestion->patchEntity($faq_cat_question, $this->request->data);
		
			$results = $this->FaqCatQuestion->save($savepack);
				if ($results) {
					$this->Flash->success(__('FAQ Question has been updated.'));
					return $this->redirect(['action' => 'question']);
				} else {
					$this->Flash->error(__('FAQ Question not Updated.'));
					return $this->redirect(['action' => 'index']);
				}
	
		}
	}

	public function edit($id)
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('faq_cat');

		$faq_cat = $this->faq_cat->get($id);
		$this->set('faq_cat', $faq_cat);
		if ($this->request->is(['post', 'put'])) {
			$savepack = $this->faq_cat->patchEntity($faq_cat, $this->request->data);
			$results = $this->faq_cat->save($savepack);
			if ($results) {
				$this->Flash->success(__('FAQ has been updated.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('FAQ not Updated.'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	public function search()
	{
		// pr('hfgh');die;
	//	$this->viewBuilder()->layout('admin');
		$this->loadModel('FaqCatQuestion');
		$this->loadModel('Faq');
		$category = $this->request->data['category'];
		$cond = [];
		if (isset($category) && $category != '') {
			$cond['FaqCatQuestion.faq_cat_id'] = $category;
		}
		$faq_cat_question = $this->FaqCatQuestion->find()->where([$cond])->contain(['Faq'])->order(['FaqCatQuestion.created' => 'desc']);
		$this->set('faq_cat_question', $this->paginate($faq_cat_question)->toarray());
	}
}
