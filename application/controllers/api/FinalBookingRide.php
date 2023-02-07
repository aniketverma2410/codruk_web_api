<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class FinalBookingRide extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
	    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->readyForWork();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		   // $array = json_decode('{"codrukApp":{"userId":"","driverId":"51","pickupAddress":"","pickupLat":"24.470901","pickupLong":"39.612236","dropoffAddress":"","dropoffLat":"24.470901","dropoffLong":"39.612236","dropoffName":"\u0634\u0627\u0643\u0631 \u0627\u0644\u062d\u0631\u0628\u064a","dropoffNumber":"","loaderCount":"0","insuranceType":"","payAt":"","payType":"1","deliveFare":"","loaderCharge":"0","insuranceCharge":"0","delayCharge":"0","tax":"0","totalCharge":"0","pickupSubAddress":"","dropoffSubAddress":"","vehicle_id":"","km":"0","snapshot":""}}',true);
		}  
	//	$this->readyForWork($array);
    }
    public function readyForWork()
    {
      $requestData = getRequestJson();
      $check_request_keys = array('userId','pickupAddress','pickupLat','pickupLong','dropoffAddress','dropoffLat','dropoffLong','dropoffName','dropoffNumber','loaderCount','insuranceType','payAt','payType','deliveFare','loaderCharge','insuranceCharge','delayCharge','tax','totalCharge','pickupSubAddress','dropoffSubAddress','vehicle_id','km','snapshot');

      $resultJson    =  validateJson($requestData, $check_request_keys);
      if($resultJson == OK)
      {         
        $this->ApiModel->generateRide($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
