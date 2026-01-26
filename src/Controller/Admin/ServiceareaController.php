<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class ServiceareaController  extends AppController
{

  public function index(){ 
		$this->loadModel('Locations');	
		$this->loadModel('Servicearea');	
		$this->viewBuilder()->layout('admin');		 
		$locations = $this->Locations->find('all')->contain(['Servicearea'])->toarray();
		$this->set('locations', $locations);
	}

  public function servicearea($location_id){

    $this->viewBuilder()->layout('admin');
    $this->loadModel('Servicearea');
    $this->loadModel('Users');
    $this->loadModel('Locations');
    
    //setting up data according to ID
    $this->set('id',$location_id);

    $location = $this->Locations->find('all')->where(['id'=>$location_id])->first();
    //  pr($location['latitude']); die;
     $this->set('latitude',$location['latitude']);
     $this->set('longitude',$location['longitude']);
     $this->set('id',$location_id);

    }

    public function locatemape($location_id){
            $this->loadModel('Servicearea');
        $services_area = $this->Servicearea->find('all')->where(['location_id'=>$location_id])->order(['Servicearea.id'=>'ASC'])->toarray();
         foreach($services_area as $value){
         $servicearea_detail['lat'] =  $value['latitude'];
          $servicearea_detail['lng'] =  $value['longitude'];
          $data[] = $servicearea_detail;
              }
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();  
        }
    
    public function addservicearea($location_id)
    {
   
        $this->loadModel('Servicearea');
        $this->viewBuilder()->layout('admin');
        if ($this->request->is(['post', 'put'])) {

            $vendor_data = $this->Servicearea->find('all')->where(['location_id'=>$location_id])->first();

            $this->Servicearea->deleteAll(['location_id' => $location_id]);
            
            $explode_data = explode("+",$this->request->data['latlong']);
            array_pop($explode_data);
            foreach($explode_data as $value){
             $user_reg = $this->Servicearea->newEntity();
             $exp_value = explode(",",$value);
             $servicearea_data['location_id']= $location_id;
             $servicearea_data['vendor_id']= $vendor_data['vendor_id'];
             $servicearea_data['latitude']= $exp_value[0];
             $servicearea_data['longitude']= $exp_value[1];
             $servicearea_add = $this->Servicearea->patchEntity($user_reg,$servicearea_data);
             $results=$this->Servicearea->save($servicearea_add);   
            
            }       
        }

    die;
        }
    
}
