<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiscretionalAccess
 *
 * @author GupoBecm
 */
class DiscretionalAccess {

    public function __construct() {
        
    }

    public function getAccess() {

        if (!(ENVIRONMENT === "production")) {
            
        } else {
            $CI = & get_instance();
            if (!$CI->input->is_ajax_request()) {
               
                if (isset($_SESSION) AND !empty($_SESSION)) {
                    $this->evaluate($CI);
                } 
            }
        }
    }

    public function evaluate($CI) {

        $uri = $CI->uri->segment(1) . "/" . $CI->uri->segment(2);
        foreach ($_SESSION["route_manager"]["acceso"] as $key => $value) {
            $rutas[] = $value["controller"] . "/" . $value["method"];
        }
        if (!in_array($uri, $rutas)) {
            redirect(base_url() . "index.php/panel/index");
        }
    }

}
