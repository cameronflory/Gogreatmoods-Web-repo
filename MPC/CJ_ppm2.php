<?php
// code modified from source: https://cms.paypal.com/cms_content/US/en_US/files/developer/nvp_MassPay_php.txt
// documentation: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/howto_api_masspay
// sample code: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/library_code

// eMail subject to receivers
$EmailSubject = ' GreatMoods Fundraising Sent You A Payment!';

/** MassPay NVP example.
 *
 *  Pay one or more recipients. 
*/

// For testing environment: use 'sandbox' option. Otherwise, use 'live'.
// Go to www.x.com (PayPal Integration center) for more information.
$environment = 'live'; // or 'beta-sandbox' or 'live'.

/**
 * Send HTTP POST Request
 *
 * @param string The API method name
 * @param string The POST Message fields in &name=value pair format
 * @return array Parsed HTTP Response body
 */
function PPHttpPost($methodName_, $nvpStr_)
{
 global $environment;

 // Set up your API credentials, PayPal end point, and API version.
 // How to obtain API credentials:
 // https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_NVPAPIBasics#id084E30I30RO
   $API_UserName = urlencode('bob_api1.greatmoods.com');
   $API_Password = urlencode('V79ULNHSKDMVTNT6');
   $API_Signature = urlencode('AHFzJcU15w4NLRhb5aA00X.SEVmNAHygwXDsoZsBUNn36mYgXNkviFkl');
 $API_Endpoint = "https://api-3t.paypal.com/nvp";
 if("sandbox" === $environment || "beta-sandbox" === $environment)
 {
  $API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
 }
 $version = urlencode('51.0');

 // Set the curl parameters.
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
 curl_setopt($ch, CURLOPT_VERBOSE, 1);

 // Turn off the server and peer verification (TrustManager Concept).
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_POST, 1);

 // Set the API operation, version, and API signature in the request.

 $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

 // Set the request as a POST FIELD for curl.
 curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq."&".$nvpStr_);

 // Get response from the server.
 $httpResponse = curl_exec($ch);

 if( !$httpResponse)
 {
  echo $methodName_ . ' failed: ' . curl_error($ch) . '(' . curl_errno($ch) .')';
 }

 // Extract the response details.
 $httpResponseAr = explode("&", $httpResponse);

 $httpParsedResponseAr = array();
 foreach ($httpResponseAr as $i => $value)
 {
  $tmpAr = explode("=", $value);
  if(sizeof($tmpAr) > 1)
  {
   $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
  }
 }

 if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr))
 {
  exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
 }
print_r($httpParsedResponseAr);

 return $httpParsedResponseAr;
}

// Set request-specific fields.
$emailSubject = urlencode($vEmailSubject);
$receiverType = urlencode('EmailAddress');
$currency = urlencode('USD'); // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')

// Receivers
// Use '0' for a single receiver. In order to add new ones: (0, 1, 2, 3...)
// Here you can modify to obtain array data from database.
 include '../includes/connection.inc.php';
 $link = connectTo();
 //$today = date('Y-m-d');
 //$today = "2016-November-22";
 $receivers = array();
 $query = "SELECT * FROM IPNdata WHERE paidOut= 0";
 $result = mysqli_query($link, $query)or die ("couldn't execute query.".mysqli_error($link));
 $notPaid = mysqli_num_rows($result);
 
 
     
     //$sql = "SELECT * FROM IPNdata WHERE paidOut = 0 Limit 250";
     //$sqlResult = mysqli_query($link, $sql)or die ("couldn't execute sql.".mysqli_error($link));
 
  while($row = mysqli_fetch_assoc($result))
  { 
    $memberID = $row['groupID'];
	$amount1 = $row['Amount'];
	$orderNum = $row['order_id'];
	$rep_id = $row['repID'];
	$setup = 0;
	
	//get the parent id of member who sold basket
	$query2 = "SELECT * FROM Dealers WHERE loginid='$memberID'";
	$result2 = mysqli_query($link, $query2) or die ("couldn't execute query 2.".mysqli_error($link));
	$row2 = mysqli_fetch_assoc($result2);
	$groupppe = $row2['PaypalEmail'];
	$rep = $row2['setuppersonid'];
	$groupAmount = $amount1 * 0.35;
	$repAmount = $amount1 * 0.06;
	
	//get rep details
	$query3 = "SELECT * FROM user_info WHERE userInfoID='$rep'";
	$result3 = mysqli_query($link, $query3)or die ("couldn't execute query 3.".mysqli_error($link));
	$row3 = mysqli_fetch_assoc($result3);
	$scid = $row3['salesPerson'];
	$repPayMail = $row3['userPaypal'];
	
	//get sales coordinator
	$query4 = "SELECT * FROM user_info WHERE userInfoID='$scid'";
	$result4 = mysqli_query($link, $query4)or die ("couldn't execute query 4.".mysqli_error($link));
	$row4 = mysqli_fetch_assoc($result4);
	$scPayMail = $row4['userPaypal'];
	$scAmount = $amount1 * 0.01;
	$vpID = $row4['salesPerson'];
	
	//get VP details
	$query5 = "SELECT * FROM user_info WHERE userInfoID ='$vpID'";
	$result5 = mysqli_query($link,$query5)or die ("couldn't execute query 5.".mysqli_error($link));
	$row5 = mysqli_fetch_assoc($result5);
	$vpAmount = $amount1 * 0.005;
	$vpPayMail = $row5['userPaypal'];
	
	
	
	
	//pay the vp
	array_push($receivers, array(
    'receiverEmail' => $vpPayMail, 
    'amount' => $vpAmount,
    'uniqueID' => 2121, // 13 chars max
    'note' => " Creatmoods Fundraising Comission") // I recommend use of space at beginning of string.
    );
	
	//pay the sales coordinator
	array_push($receivers, array(
    'receiverEmail' => $scPayMail, 
    'amount' => $scAmount,
    'uniqueID' => 2122, // 13 chars max
    'note' => " Creatmoods Fundraising Comission") // I recommend use of space at beginning of string.
    );
	
	
	//pay the rep
	array_push($receivers, array(
	'receiverEmail' => $repPayMail, 
    'amount' => $repAmount,
    'uniqueID' => 3242524, // 13 chars max
    'note' => " Creatmoods Fundraising Comission") // I recommend use of space at beginning of string.
    );
	//pay the group
	array_push($receivers, array(
	'receiverEmail' => $groupppe, 
    'amount' => $groupAmount,
    'uniqueID' => 1242, // 13 chars max
    'note' => " Creatmoods Fundraising Comission") // I recommend use of space at beginning of string.
    );

/*	$receivers = array(
  0 => array(
    'receiverEmail' => "clbj35@yahoo.com", 
    'amount' => "0.01",
    'uniqueID' => "id_001", // 13 chars max
    'note' => " pagamento de comissão Fashiontuts"), // I recommend use of space at beginning of string.
  1 => array(
    'receiverEmail' => "clbj35@yahoo.com",
    'amount' => "0.02",
    'uniqueID' => "id_002", // 13 chars max, available in 'My Account/Overview/Transaction details' when the transaction is made 
    'note' => " pagamento de comissão fashiontuts"  // space again at beginning.
  )
);
*/ 
  }//end while loop


$receiversLenght = count($receivers);

// Add request-specific fields to the request string.
$nvpStr="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";

$receiversArray = array();

for($i = 0; $i < $receiversLenght; $i++)
{
 $receiversArray[$i] = $receivers[$i];
}

foreach($receiversArray as $i => $receiverData)
{
 $receiverEmail = urlencode($receiverData['receiverEmail']);
 $amount = urlencode($receiverData['amount']);
 $uniqueID = urlencode($receiverData['uniqueID']);
 $note = urlencode($receiverData['note']);
 $nvpStr .= "&L_EMAIL$i=$receiverEmail&L_Amt$i=$amount&L_UNIQUEID$i=$uniqueID&L_NOTE$i=$note";
}

$fp = fopen('file.csv', 'w');

foreach ($receivers as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
print_r($receivers);
echo count($receivers);
/*
// Execute the API operation; see the PPHttpPost function above.
$httpParsedResponseAr = PPHttpPost('MassPay', $nvpStr);

if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
{
 echo 'MassPay Completed Successfully: ' . $httpParsedResponseAr;
}
else
{
 echo '\nMassPay failed: ';
 print_r($httpParsedResponseAr);
}
*/
?>