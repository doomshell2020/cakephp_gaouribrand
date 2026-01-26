<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
require_once "Firebase.php";
require_once "Push.php";

class NotificationController extends AppController
{
    // for view or index page
    public function index()
    {
        $this->viewBuilder()->layout("admin");
        $this->loadModel("Notifications");
        $authUser = $this->request->session()->read("Auth.User");
        $notifications = $this->Notifications
            ->find("all")
            ->where(["Notifications.vendor_id" => $authUser["id"]])
            ->group(["rand_no"])
            ->order(["Notifications.id" => "Desc"]);
        $this->set("notifications", $this->paginate($notifications)->toarray());
    }

    public function add()
    {
        $this->viewBuilder()->layout("admin");
        $this->loadModel("Notifications");
        $this->loadModel("Users");
        $this->loadModel('Devices');
        if ($this->request->is(["post", "put"])) {
            $authUser = $this->request->session()->read("Auth.User");
            $this->request->data["vendor_id"] = $authUser["id"];
            $this->request->data["role_id"] = 3;
            $this->request->data["rand_no"] = rand(10000, 99999);
            //For Vendor Start
            if ($authUser["role_id"] == 2) {
                $usersTable = TableRegistry::getTableLocator()->get("Users");
                $query = $usersTable->find("all");
                $user = $query
                    ->select([
                        "id" => "Users.id",
                        "name" => "Users.name",
                    ])
                    ->distinct()
                    ->join([
                        "Orders" => [
                            "table" => "orders",
                            "type" => "LEFT",
                            "conditions" => ["Orders.user_id = Users.id"],
                        ],
                    ])
                    ->where([
                        "Orders.vendor_id" => $authUser["id"],
                        "Orders.user_id IS NOT NULL",
                    ])
                    ->toArray();
                foreach ($user as $value) {
                    $this->request->data["user_id"] = $value["id"];
                    $vendorCus = $this->Notifications->patchEntity(
                        $this->Notifications->newEntity(),
                        $this->request->data
                    );
                    $this->Notifications->save($vendorCus);
                    $firebase = new \Firebase();
                    $push = new \Push(
                        $this->request->data["title"],
                        $this->request->data["message"]
                    );
                    $udata["notification_counter"] =
                        $value["notification_counter"] + 1;
                    $usavepack = $this->Users->patchEntity($value, $udata);
                    $uresults = $this->Users->save($usavepack);
                    $tokens[] = trim($value["token"]);
                }
                $pushNotification = $push->getPush();
                $response = $firebase->send($tokens, $pushNotification);
                $this->Flash->success(__("Notifications has been saved."));
                return $this->redirect(["action" => "index"]);
            }
            //For Vendor End

            //For Admin Start
            $newpack = $this->Notifications->newEntity();
            $savepack = $this->Notifications->patchEntity( $newpack,$this->request->data);
            $results = $this->Notifications->save($savepack);

            if ($results) {
                $firebase = new \Firebase();
                $push = new \Push(
                    $this->request->data["title"],
                    $this->request->data["message"]
                );
                $user = $this->Users->find("all")->contain(['Devices'])->where(["Users.status" => 1, "Users.role_id" => 3])->order(['Users.id'=>'desc'])->toarray();

                foreach ($user as $value) {
                    $udata["notification_counter"] = $value["notification_counter"] + 1;
                    $usavepack = $this->Users->patchEntity($value, $udata);
                    $uresults = $this->Users->save($usavepack);
                    $tokens[] = trim($value['device']["token"]);
                }
              
                $pushNotification = $push->getPush();
                $response = $firebase->send($tokens, $pushNotification);
                // pr($response);die;
                //For Admin End
                $this->Flash->success(__("Notifications has been saved."));
                return $this->redirect(["action" => "index"]);
            } else {
                $this->Flash->error(__("Notifications not saved."));
                return $this->redirect(["action" => "index"]);
            }
        }
    }

    public function status($id, $status)
    {
        $this->loadModel("Notifications");
        if (isset($id) && !empty($id)) {
            $product = $this->Notifications->get($id);
            $product->status = $status;
            if ($this->Notifications->save($product)) {
                if ($status == "1") {
                    $this->Flash->success(
                        __("Notification status has been Activeted.")
                    );
                } else {
                    $this->Flash->success(
                        __("Notification status has been Deactiveted.")
                    );
                }
                return $this->redirect(["action" => "index"]);
            }
        }
    }

    public function delete($id)
    {
        $this->loadModel("Notifications");
        $catdelete = $this->Notifications->get($id);
        if ($catdelete) {
            $this->Notifications->deleteAll([
                "Notifications.rand_no" => $catdelete["rand_no"],
            ]);
            $this->Flash->success(
                __("Notification has been deleted successfully.")
            );
            return $this->redirect(["action" => "index"]);
        }
    }

}
