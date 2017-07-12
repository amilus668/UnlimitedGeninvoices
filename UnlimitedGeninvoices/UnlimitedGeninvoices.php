<?php
if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

function UnlimitedGeninvoices_config() {
    $configarray = array(
    "name" => "UnlimitedGeninvoices",
    "description" => "提前续费订单创建系统",
    "version" => "1.0",
    "author" => "Zzm317",
    "language" => "english",
    "fields" => array());
    return $configarray;
}

function UnlimitedGeninvoices_activate() {
    return array('status'=>'success','description'=>'插件激活成功。');
}

function UnlimitedGeninvoices_deactivate() {
    return array('status'=>'success','description'=>'插件停用成功。');
}

function getServiceAvailable($id,$userid){
	$result = select_query('tblhosting', 'id', array( 'id' => $id, 'userid' => $userid ));
	$data = mysql_fetch_array($result);
	if($data){
		return true;
	}
	return false;
}

function ShowService($id,$userid){
	$result = select_query('tblhosting', '*', array( 'id' => $id, 'userid' => $userid ));
	$data = mysql_fetch_array($result);
	if($data){
		$name = select_query('tblproducts', 'name', array('id'=>$data['packageid']));
		$name = mysql_fetch_array($name);
		$datas = array(
			"id" => $data['id'],
			"name" => $name['name'],
			"amount" => $data['amount'],
			"duedate" => $data['nextduedate']
		);
		return $datas;
	}
	return false;
}

function makedataarray($time=6){
	$array = array();
	for ($x=1; $x <= $time; $x++) {
		$array[$x] = $x; 
	}
	return $array;
}

function UnlimitedGeninvoices_clientarea($vars) {
	$type = 1;
	if($_POST['BillingTimes'] and isset($_GET['id'])) {
		for ($x=0; $x < $_POST['BillingTimes']; $x++) {
			$command = "geninvoices";
			$adminuser = "";
			$values["clientid"] = $_SESSION['uid'];
			$values["serviceids"] = array($_GET['id'] => $_GET['id']);
			$values["noemails"]= true;
			$results = localAPI($command,$values,$adminuser);
			if($results['result'] == 'success') {
				$geninvoicelatestinvoiceid = $results['latestinvoiceid'];
				if ($geninvoicelatestinvoiceid == "0") {
					$errorreturn = "您所选择的服务目前无法创建续费账单.可能是因为余额不足或存在未支付账单";
					break;
				}
			}
		}
		$successreturn = "已成功为您续费".$x."个周期";
	}
	
	if(isset($_GET['id'])){
		if(getServiceAvailable($_GET['id'],$_SESSION['uid'])){
			$product = ShowService($_GET['id'],$_SESSION['uid']);
			$type = 2;
		}else{
			$errorreturn = "该产品不属于你";
			$type = 3;
		}
	}
	
	$command = "getclientsproducts";
	$adminuser = "";
	$values["clientid"] = $_SESSION['uid'];
	$results = localAPI($command,$values,$adminuser);
	foreach($results['products']['product'] as $producedetails) {
		if ($producedetails['status'] == "Active") {
		$serviceid = $producedetails['id'];
		$servicename = $producedetails['name'];
		$servicedomain = $producedetails['domain'];
		$serviceregdate = $producedetails['regdate'];
		$servicenextduedate = $producedetails['nextduedate'];
		$servicerecurringamount = $producedetails['recurringamount'];
		$productlist .= "<li><a href='".$_SERVER['REQUEST_URI']."&id=$serviceid'> 
			<i class=\"fa fa-list-alt\"></i>
			 ID:$serviceid $servicename($servicenextduedate)-$servicerecurringamount
			</a></li>";
		}
	}
	
	$dataarray = makedataarray(3); 
    return array(
        'pagetitle' => '创建续费账单',
        'breadcrumb' => array('index.php?m=Geninvoices'=>'Geninvoices'),
        'templatefile' => 'clienthome',
        'requirelogin' => true,
        'vars' => array(
			'successreturn' => $successreturn,
            'errorreturn' => $errorreturn,
            'productlist' => $productlist,
			'product' => $product,
			'dataarray' => $dataarray,
			'type' => $type
        ),
    );


}