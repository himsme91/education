<?php 	
drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');
$display = ($_GET['display'] != '') ? $_GET['display'] : 'all';
//Capture BP from URL and log user in for transaction
//TODO -- Add time hash for added security
if($_GET['BP'] || $_GET['bp']){
	if($_GET['BP']){
		$bp = $_GET['BP'];
	}
	if($_GET['bp']){
		$bp = $_GET['bp'];
	}
	global $user;
	if($user->uid){
		//if user is logged in, verify that the user bp and the url bp match
		$person = content_profile_load('person', $user->uid);
		if($person->field_per_id[0]['value'] != $bp){
			//redirect to /account
			drupal_set_message('Access to url denied.');
			header("Location: /account");
			exit();
		}
	} else {
		//log the user in
		$email = db_result(db_query("SELECT field_per_email_url FROM {content_type_person} WHERE field_per_id_value = '%s'",  $bp));
		if($email != ''){
			if(usgbc_sap_auth_login_in_drupal($email)){
				$user = user_load(array('mail' => $email));
			}
			else{
				form_set_error('','User does not exist');
				header("Location: /account");
				exit();
			}
		}
	}
}
global $user;

$rows = array();
$receptions = array();

$context = array(
		'revision' => 'themed-original',
		'type' => 'amount',
);

if($display != ''){
	if($display == 'all'){
		//DONOT filter -- else orders outside drupal do not show up
		//$whereclause = "AND nd.type IN ('workshp','donation','resource','chapter','usgbc_membership')";
	} else {
		$whereclause = "AND nd.type like '".$display."'";
	}
} else {
	//$whereclause = "AND nd.type IN ('workshp','donation','resource','chapter','usgbc_membership')";
}
$returnedsapresults = false;
$keys = $_GET['keys'];


if($keys){
	if($keys != ''){
		//Make it 10 digit
		$searchbybp = str_pad($keys, 10, '0',STR_PAD_LEFT);
		$saporderid = str_pad($keys, 10, '0',STR_PAD_LEFT);
		$searchbyorderid = str_pad($keys, 10, '0',STR_PAD_LEFT);
		$whereclause = "o.purchasedBP = '%s' OR o.order_id = '%s'";
			
		if(substr($keys,0,3)!='SAP'){
			$searchbyorderid = 'SAP'.$searchbyorderid;
		}

		$query = "SELECT o.order_id, o.created, os.title, SUM(op.qty) AS products, o.order_total AS total ,
				NULL as data , o.purchasedBP, o.order_status
				FROM {insight.stg_usgbc_uc_orders_SAP} AS o LEFT JOIN {uc_order_statuses} AS os ON o.order_status = os.order_status_id
				LEFT JOIN {insight.stg_usgbc_uc_order_products_SAP} AS op ON o.order_id = op.order_id
				LEFT JOIN {node} as nd ON op.nid = nd.nid
				LEFT JOIN insight.projects p on p.id = o.purchasedBP
				WHERE (".$whereclause.")
						GROUP BY o.order_id, o.created, os.title, o.order_total	ORDER BY o.created DESC";
		$result = db_query($query, $searchbybp, $searchbyorderid);
			
		if($result->num_rows <= 0){

			//Search using order list BAPI in SAP
			$values['ordernumber'] = $saporderid;
			$sapresult = get_order_list_sap_integration($values);
			$link = '<a class="more-link small-link block-link-src" href="/account/purchases/orderdetails?orderid='.$saporderid.'">Details</a>';
			//	print_r($sapresult->SalesOrders->item[0]);
			if(is_array($sapresult->SalesOrders->item)){
				foreach($sapresult->SalesOrders->item as $item){
					$ordertotal += $item->NetValue;
				}
				if($sapresult->SalesOrders->item[0]){
					$returnedsapresults = true;
					//	watchdog('orderstatus', $sapresult->SalesOrders->item->DocStatus);
					if(strtoupper($sapresult->SalesOrders->item[0]->DocStatus) == 'OPEN' || strtoupper($sapresult->SalesOrders->item[0]->DocStatus) == 'NOT CLEARED'){
						$orderstatus = 'processing';
					}
					$saporder = array(
							'orderid' => $saporderid,
							'saporderid' => $saporderid,
							'price' => uc_currency_format($ordertotal),
							'orderdate' => format_date(strtotime($sapresult->SalesOrders->item[0]->DocDate), 'custom', variable_get('uc_date_format_default', 'M j, Y')),
							'orderdetails' => $link,
							'products' => '',
							'title' => $sapresult->SalesOrders->item[0]->ShortText,
							'order_status' => $orderstatus
					);
				}
			}else{
				if($sapresult->SalesOrders->item){
					$returnedsapresults = true;
					//		 watchdog('orderstatus', $sapresult->SalesOrders->item->DocStatus);
					if(strtoupper($sapresult->SalesOrders->item->DocStatus) == 'OPEN' || strtoupper($sapresult->SalesOrders->item->DocStatus) == 'NOT CLEARED'){
						$orderstatus = 'processing';
					}
					$saporder = array(
							'orderid' => $saporderid,
							'saporderid' => $saporderid,
							'price' => uc_currency_format($sapresult->SalesOrders->item->NetValue),
							'orderdate' => format_date(strtotime($sapresult->SalesOrders->item->DocDate), 'custom', variable_get('uc_date_format_default', 'M j, Y')),
							'orderdetails' => $link,
							'products' => '',
							'title' => $sapresult->SalesOrders->item->ShortText,
							'order_status' => $orderstatus
					);
				}
			}
			/*			echo '<pre>';
				print_r($saporder);
			echo '</pre>';*/
		}
		//			$result = db_query("call drupal.usp_order_search('%s', %d,0,0);", $keys, $keys);
	}
} else {
	//print_r($whereclause);
	
	$result = pager_query(" ( SELECT * FROM
			(	SELECT o.order_id, o.created, os.title, SUM(op.qty) AS products, o.order_total AS total , o.data , o.order_status
			FROM {uc_orders} AS o LEFT JOIN {uc_order_statuses} AS os ON o.order_status = os.order_status_id
			LEFT JOIN {uc_order_products} AS op ON o.order_id = op.order_id
			LEFT JOIN {node} as nd ON op.nid = nd.nid
			WHERE o.uid = %d ".$whereclause." AND o.order_status IN ". uc_order_status_list('general', TRUE) ."
			GROUP BY o.order_id, o.created, os.title, o.order_total) AS a )
			UNION ALL (SELECT * FROM

			(	SELECT o.order_id, o.created, os.title, SUM(op.qty) AS products, o.order_total AS total , NULL as data , o.order_status
			FROM {usgbc_uc_orders_SAP} AS o LEFT JOIN {uc_order_statuses} AS os ON o.order_status = os.order_status_id
			LEFT JOIN {usgbc_uc_order_products_SAP} AS op ON o.order_id = op.order_id
			LEFT JOIN {node} as nd ON op.nid = nd.nid
			WHERE o.uid = %d ".$whereclause." AND o.order_status IN ". uc_order_status_list('general', TRUE) ."
			GROUP BY o.order_id, o.created, os.title, o.order_total) AS b )
			ORDER BY created DESC ",

			30, 0,
			"SELECT COUNT(*) FROM

			(SELECT o.order_id FROM {uc_orders} o
			LEFT JOIN {uc_order_products} AS op ON o.order_id = op.order_id
			LEFT JOIN {node} as nd ON op.nid = nd.nid
			WHERE o.uid = %d ".$whereclause." AND order_status NOT IN ". uc_order_status_list('specific', TRUE) .
			"	 UNION
			SELECT o.order_id FROM {usgbc_uc_orders_SAP} o
			LEFT JOIN {usgbc_uc_order_products_SAP} AS op ON o.order_id = op.order_id
			LEFT JOIN {node} as nd ON op.nid = nd.nid
			WHERE o.uid = %d ".$whereclause." AND order_status NOT IN ". uc_order_status_list('specific', TRUE) . " ) AS a"

			,$user->uid, $user->uid);
}
//echo "<div>line break</div></br>";
//print_r($result);
//echo "<div>line break</div></br>";

if($returnedsapresults == false){
	while ($order = db_fetch_object($result)) {
		//print_r( $order);
		$context['subject'] = array('order' => $order);

		/* $class = array(
		 'attributes' => array(
		 		'class' => 'more-link small-link block-link-src'
		 ),
		);*/

		//$link = l('Details', 'user/'. $user->uid .'/order/'. $order->order_id, $class);

		//if (user_access('view all orders')) {
		//  $link .= '<span class="order-admin-icons">'. uc_order_actions($order, TRUE) .'</span>';
		//}
		$link = '<a class="more-link small-link block-link-src" href="/account/purchases/orderdetails?orderid='.$order->order_id.'">Details</a>';

		$data = unserialize($order->data);
		if($data['attributes']['sapordernumber']){
			$sap_orderid = $data['attributes']['sapordernumber'];
		} else {
			$sap_orderid = $order->order_id;
		}
			
		$rows[] = array(
				'orderid' => $order->order_id,
				'saporderid' => $sap_orderid,
				'price' => uc_price($order->total, $context),
				'orderdate' => format_date($order->created, 'custom', variable_get('uc_date_format_default', 'M j, Y')),
				'orderdetails' => $link,
				'products' => $order->products,
				'order_status' => $order->order_status
		);

	}//end while
	
	$receipt_result = db_query("SELECT received FROM {uc_payment_receipts} WHERE uid = %d", $user->uid);
	//assemble all of the paid dates corresponding to each order, this is only stored in the uc sql table
	while($receipt_info = db_fetch_object($receipt_result)){
		$receptions[] = $receipt_info;
	}//end while
} else {
	$rows[] = $saporder;
}
//print_r($rows);
//  $output = '<h1>Order history</h1>';
$output .= '<div class="ag-header">';
$output .= '<div class="ag-sort"><p>Type</p><div id="items-sort-selector" class="ag-sort-container">';
$output .= '<select>';
if($display == 'all')
	$output .= '<option value="display=all" selected="selected">All</option>';
else
	$output .= '<option value="display=all">All</option>';
if($display == 'workshp')
	$output .= '<option value="display=workshp" selected="selected">Courses</option>';
else
	$output .= '<option value="display=workshp">Courses</option>';
if($display == 'donation')
	$output .= '<option value="display=donation" selected="selected">Donations</option>';
else
	$output .= '<option value="display=donation">Donations</option>';

if($display == 'publication')
	$output .= '<option value="display=publication" selected="selected">Store purchases</option>';
else
	$output .= '<option value="display=publication">Store purchases</option>';
$output .= '</select>';
$output .= '</div></div>';
$output .= '<ul class="ag-pagination" id="home_recommend_slider-nav">';
$output .= theme('pager', NULL, 5, 0);
$output .= '</ul></div>';

$output .= '<div id="order-history-aggregator" class="ag-body">';




$row = 0;
//print_r($receptions);
$receptions = array_reverse($receptions);
foreach ($rows as $file) {

	$output .= '<div class="ag-item block-link"  title="Details">';

	$output .= '<div class="order-history-item-details"><h2>'.$file['orderdate'].'</h2>';
	$output .= '<dl><dt>Order #</dt>';
	$output .= '<dd>'.str_replace('SAP', '', $file['saporderid']) .' </dd>';
	$output .= '<dt>Total</dt>';
	$output .= '<dd>'.$file['price'].'</dd>';
	if($receptions[$row]){
		$output .= '<dt>Paid on</dt>';
		$output .= '<dd>' . date("m/d/Y",$receptions[$row]->received) . '</dd>';
	}
	$output .= '<dt>Status</dt>';
	$output .= '<dd style="text-transform: capitalize;">'.$file['order_status'].'</dd></dl>';
	$output .= '</div><!-- order-history-item-details -->';
	
	//print_r($file);
	//print_r("</br></br>");

	$output .= '<div class="order-history-item-summary" style="width:250px;">';
	$output .= '<ul class="linelist">';

	if($returnedsapresults == false){
		if(substr($file['orderid'],0,3) == 'SAP')
		{
			// add products from SAP tables
			$result = db_query("SELECT title, nid FROM usgbc_uc_order_products_SAP WHERE order_id ='%s'", $file['orderid']);

			$rows1 = array();
			while ($row1 = db_fetch_object($result)) $rows1[] = $row1;
			foreach ($rows1 as $row1) {
				$ismembership = false;
				$node = node_load($row1->nid);
				if ($node->type == 'chapter'){
					$output .= '<li>Chapter membership for '.$row1->title.'</li>';
				}
				elseif ($node->type == 'usgbc_membership' || instr($row1->title,'USGBC Membership') || instr($row1->title,'USGBC New Membership')){
					$output .= '<li>USGBC National Membership</li>';
					$ismembership = true;
				}
				else{
					$output .= '<li>'.$row1->title.'</li>';
				}
			}

		}
		else
		{

			$result = db_query("SELECT title, nid FROM uc_order_products WHERE order_id =%d", $file['orderid']);

			$rows1 = array();
			while ($row1 = db_fetch_object($result)) $rows1[] = $row1;
			foreach ($rows1 as $row1) {
				$ismembership = false;
				$node = node_load($row1->nid);
				if ($node->type == 'chapter'){
					$output .= '<li>Chapter membership for '.$row1->title.'</li>';
				}
				elseif ($node->type == 'usgbc_membership' || instr($row1->title,'USGBC Membership') || instr($row1->title,'USGBC New Membership')){
					$output .= '<li>USGBC National Membership</li>';
					$ismembership = true;
				}
				else{
					$output .= '<li>'.$row1->title.'</li>';
				}
			}

		}
	}
	else {
		$output .= '<li>'.$file['title'].'</li>';
	}

	$output .= '</ul>';
	if($file['order_status'] == 'processing' || $file['order_status'] == 'pending'){
		$output .= '<h6>Pending payment</h6>';
	}
	$output .= $file['orderdetails'];
	$output .= '</div><!-- order-history-item-summary -->';
	if($file['order_status'] == 'processing' || $file['order_status'] == 'pending'){
		$output .= '<div style="float:right;padding:15px;">';
		if($ismembership == true){

			/*  if($returnedsapresults == false){
			 $query = "Select nid from drupal.content_field_order_id where field_order_id_value =%d";
			$orgnid = db_result(db_query($query), $file['orderid']);
			}else {
			$orgnid = db_result(db_query("Select nid from drupal.content_type_organization where field_org_saporderid_value='%s'"), str_replace('SAP', '', $file['orderid']));
			}*/
			$orgnid = '';
			$orgnid = db_result(db_query("Select nid from drupal.content_type_organization where field_org_saporderid_value='%s'", str_replace('SAP', '', $file['orderid'])));
			if($orgnid == ''){
				$query = "Select nid from drupal.content_field_order_id where field_order_id_value =%d";
				$orgnid = db_result(db_query($query, $file['orderid']));
			}

			//	var_dump($file['orderid']);
			if($orgnid <> ''){
				$output .= '<a class="small-alt-button" href="/join-center/member/renew/'.$orgnid;
			}else {
				$output .= '<a class="small-alt-button" href="/join-center/order/changepayment?orderid=';
				$output .= $file['orderid'];
			}

		}else {
			$output .= '<a class="small-alt-button" href="/join-center/order/changepayment?orderid=';
			$output .= $file['orderid'];
		}
	 $output .= '">Pay Now</a></div>';
	}

	$output .= '</div>';


	$row++;
}

if ($row == 0) {
	$output .= '<p><em class="no-match">There are currently no purchases from this account</em></p>';
}

$output .= '</div>';
?>

<h1>Order history</h1>
<p>
	<em>Search any order by order ID, project ID or organization ID</em>
</p>
<div id="events-search" class="mini-search">
	<div class="mini-search-container">
		<?php print drupal_render($form["searchdata"]);?>
		<?php print drupal_render($form["search_order"]);?>
	</div>
</div>

<?php print $output; ?>


<div id="norender" class="hidden">
	<?php print drupal_render($form); ?>
</div>
