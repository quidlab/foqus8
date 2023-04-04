<?php
	//include connection file 
	session_start(); 
	//include "inc/main.php"; 
	include_once('../lib/db.php');
	// initilize all variable
	//$params['start']='1';
	//$params['length']='10';
	//$params = $totalRecords = $data = array(); //$columns=
	$params =  $data = array();
	$params = $_REQUEST;
	//$params['start']='1';
	//$params['length']='10';
	//$params['search']['value']=[];
	$where = $sqlTot = $sqlRec = "";

	// check search value exist
	if( !empty($params['search']['value']) ) {   
		$where .=" WHERE ";
		$where .=" ( i_holder LIKE '".$params['search']['value']."%' )";
		$where .="or  ( e_mail LIKE '".$params['search']['value']."%' )";
		$where .="or  ( n_first LIKE N'".$params['search']['value']."%' )";
		$where .="or  ( n_last LIKE N'".$params['search']['value']."%' )";
		
	}

	// getting total number records without any search
	//$sql = "WITH CTE AS (SELECT ID, username, password, i_holder, i_title, n_title, n_first, n_last, Phone, e_mail,ApprovedForOnline, Email_sent, ROW_NUMBER(),proxy,proxy_name,proxy_type OVER(ORDER BY username DESC) AS ABC from EGM) SELECT ID, username, password, i_holder, i_title, n_title, n_first, n_last, Phone, e_mail,ApprovedForOnline, Email_sent,proxy,proxy_name,proxy_type  from CTE ";    //fetch table
	$sql = "WITH CTE AS (SELECT ID, username, password, i_holder, i_title, n_title, n_first, n_last, m_Phone, e_mail,ApprovedForOnline, Email_sent,proxy_name,proxy,proxytype, ROW_NUMBER() OVER(ORDER BY username DESC) AS ABC from EGM) SELECT ID, username, password, i_holder, i_title, n_title, n_first, n_last, m_Phone, e_mail,ApprovedForOnline, Email_sent,proxy_name,proxy,proxytype  from CTE ";    //fetch table
	$sqlTot .= $sql;
	$sqlRec .= $sql;
	//concatenate search sql if value exist
	if(isset($where) && $where != '') {
		$sqlTot .= $where;
		$sqlRec .= $where;
	}
	else {
		$sqlRec	.=" Where ABC BETWEEN ". ($params['start'] + 1 )." AND ".($params['start']+$params['length'])."";
		//$sqlRec	.=" Where ABC BETWEEN ".$params['start']."+1 AND ".$params['limit']."";
	}

	//$sqlRec	=" Where ABC BETWEEN ".$params['start']."+1 AND ".$params['start']."+10";

	$sqlRec .=" ORDER BY username DESC ";
	//echo $sqlRec;
	$params2 = array();

	//$totalRecords = $FoQusdatabase ->Select($sqlRec,$params2);

	$queryRecords = $FoQusdatabase ->Select($sqlRec);
	$totalRecords=count($queryRecords);
	
//$totalRecords=count($queryRecords);
//echo $totalRecords;
//print_r('$queryRecords');
//print_r($queryRecords);
	//iterate on results row and create new index array of data
	//$row=array();
	foreach( $queryRecords as $row) { 
		//$data[] = $row;
		$row = array_values($row);
		if($row[10]=='Y'){
			$loginApproved ='<span data-loginid="'.$row[0].'" data-status="'.$row[10].'" class="onlineStatus badge badge-primary">Approved</span>';
		}
		else{
			$loginApproved ='<span data-loginid="'.$row[0].'" data-status="'.$row[10].'" class="onlineStatus badge badge-warning">Pending</span>';
		}
		if($row[11]=='Y'){
			$emailSent ='<span class="badge badge-primary">Approved</span>';
		}
		else{
			$emailSent ='<span class="badge badge-warning">Pending</span>';
		}
		if($row[9]!=''){
			$action='<i class="fas fa-user-edit" data-toggle="modal" data-target="#myModal" aria-hidden="true" data-title="'. $row[5].'" data-egmid="'.$row[0].'" data-first="'.$row[6].'" data-last="'.$row[7].'" data-email="'.$row[9].'" data-phone="'.$row[8].'" data-pass="'.$row[2].'" data-proxy_name="'.$row[12].'" data-proxy="'.$row[13].'" data-proxytype="'.$row[14].'"></i>
			&nbsp;
			<i title="Sending Email" class="fa fa-paper-plane emailSent" aria-hidden="true" data-emailid="'.$row[1].'"></i>';
		}
		else{
			$action='<i class="fas fa-user-edit" data-toggle="modal" data-target="#myModal" aria-hidden="true" data-title="'. $row[5].'" data-egmid="'.$row[0].'" data-first="'.$row[6].'" data-last="'.$row[7].'" data-email="'.$row[9].'" data-phone="'.$row[8].'" data-pass="'.$row[2].'" data-proxy_name="'.$row[12].'" data-proxy="'.$row[13].'" data-proxytype="'.$row[14].'"></i>';
		}
		$subdata =array();
		$subdata[]=$row[1];
		//$subdata[]=$row[2];
		if ($row[2]){$subdata[]="********";} else {$subdata[]=$row[2]; }
		//$subdata[]="********";
		$subdata[]=$row[3];
		$subdata[]=$loginApproved;
		$subdata[]=$emailSent;
		$subdata[]=$action;
		$data[]=$subdata;
	}	

	$json_data = array(
			"draw"            => intval($params['draw']),   
			"start" 		  => intval($params['start']),
			"length" 		  => intval($params['length']),
			"recordsTotal"    => intval($totalRecords),  
			"recordsFiltered" => intval($totalRecords),
			"data"            => $data   // total data array
			);

	echo json_encode($json_data);  // send data as json format
	
?>