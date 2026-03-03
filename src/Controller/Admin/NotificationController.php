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
                // pr($response); die;
                $this->Flash->success(__("Notifications has been saved."));
                return $this->redirect(["action" => "index"]);
            }
            //For Vendor End

            //For Admin Start
            $newpack = $this->Notifications->newEntity();
            $savepack = $this->Notifications->patchEntity($newpack, $this->request->data);
            $results = $this->Notifications->save($savepack);

            if ($results) {
                // $firebase = new \Firebase();
                // $push = new \Push(
                //     $this->request->data["title"],
                //     $this->request->data["message"]
                // );
                $user = $this->Users->find("all")->contain(['Devices'])->where(["Users.status" => 1, "Users.role_id" => 3])->order(['Users.id' => 'desc'])->toarray();

                foreach ($user as $value) {
                    //     $udata["notification_counter"] = $value["notification_counter"] + 1;
                    //     $usavepack = $this->Users->patchEntity($value, $udata);
                    //     $uresults = $this->Users->save($usavepack);
                    //     $tokens[] = trim($value['device']["token"]);

                    $this->sendNotification($value['id'], $results['title'], $results['message']);
            
                }

                // $pushNotification = $push->getPush();
                // $response = $firebase->send($tokens, $pushNotification);
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

    // This is for send notification by firebase on 26-09-2024(Rajesh kumar)
    public function sendNotification($userId, $title = null, $message = null)
    {
            
        $serviceAccountFile = WWW_ROOT . 'gaouribrand-78d71-330c9abf21e8.json';

        $accessToken = $this->getGoogleAccessToken($serviceAccountFile);
        // pr($accessToken); die;
        $url = 'https://fcm.googleapis.com/v1/projects/gaouribrand-78d71/messages:send';

        $this->loadModel('Users');
        $this->loadModel('Notifications');
        $user = $this->Users->find('all')->where(['id' => $userId])->first();
        // $token = $user['token'];
        $token = $user['token'];
        // pr($token); die;

        // save notifications
        $user->notification_counter = $user->notification_counter + 1;
        $this->Users->save($user);


        $message = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $message,
                ],
                'data' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                ],
            ],
        ];

        $jsonMessage = json_encode($message);

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonMessage);

        $response = curl_exec($ch);

        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);

        echo $response;
    }




    private function getGoogleAccessToken($serviceAccountFile)
    {
        $tokenUri = 'https://oauth2.googleapis.com/token';
        $serviceAccount = json_decode(file_get_contents($serviceAccountFile), true);

        function base64url_encode($data)
        {
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
        }

        $jwtHeader = base64url_encode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT',
        ]));

        $jwtClaimSet = base64url_encode(json_encode([
            'iss'   => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
            'aud'   => $tokenUri,
            'exp'   => time() + 3600,
            'iat'   => time(),
        ]));

        openssl_sign(
            $jwtHeader . '.' . $jwtClaimSet,
            $signature,
            $serviceAccount['private_key'],
            OPENSSL_ALGO_SHA256
        );

        $jwt = $jwtHeader . '.' . $jwtClaimSet . '.' . base64url_encode($signature);

        $postFields = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ];

        $ch = curl_init($tokenUri);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => http_build_query($postFields),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1_2,
        ]);

        $result = curl_exec($ch);

        if ($result === false) {
            die('cURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($result, true);
        // pr($response); die;

        if (!isset($response['access_token'])) {
            die('OAuth Error: ' . $result);
        }

        return $response['access_token'];
    }

}
