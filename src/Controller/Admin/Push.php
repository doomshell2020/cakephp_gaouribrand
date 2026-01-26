<?php 

class Push {
    //notification title
    private $title;

    //notification message 
    private $body;
    
  


    //initializing values in this constructor
    function __construct($title, $body) {
         $this->title = $title;
         $this->body = $body; 
       


    }
    
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['title'] = $this->title;
        $res['body'] = $this->body;
        $res['sound'] = 'default';

        return $res;
    }
 
}


?>
