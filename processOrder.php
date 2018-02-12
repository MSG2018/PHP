<?php
/**
 * Created by PhpStorm.
 * User: Menia Gautier
 * Date: 2/7/16
 * Time: 5:54 PM
 */

session_start();

//include the SDK
require_once("src/isdk.php");


//setting form variables
$merchant_id = 10;

$errorfields = array ();


//Setting variables to posted form data
$health_mag_sub = (isset($_POST["health_mag_sub"])) ? validate_input($_POST["health_mag_sub"]) : '';
$health_mag_qty = (isset($_POST["health_mag_qty"])) ? validate_input($_POST["health_mag_qty"]) : '';
$health_mag_qty = (int)$health_mag_qty;
$real_estate_mag_qty = (isset($_POST["real_estate_mag_qty"])) ? validate_input($_POST["real_estate_mag_qty"]) : '';
$real_estate_mag_qty = (int)$real_estate_mag_qty;
$real_estate_mag_sub = (isset($_POST["real_estate_mag_sub"])) ? validate_input($_POST["real_estate_mag_sub"]) : '';
$real_estate_con = (isset($_POST["real_estate_con"])) ? validate_input($_POST["real_estate_con"]) : '';
$real_estate_tickets = (isset($_POST['real_estate_tickets'])) ? validate_input($_POST["real_estate_tickets"]) : '';
$wellness_seminar = (isset($_POST["wellness_seminar"])) ? validate_input($_POST["wellness_seminar"]) : '';
$wellness_tickets = (isset($_POST['wellness_tickets'])) ? validate_input($_POST["wellness_tickets"]) : '' ;
$wellness_tickets = (int)$wellness_tickets;
$real_estate_tickets = (int)$real_estate_tickets;
$phone = (isset($_POST["phone"])) ? validate_input($_POST["phone"]) : '';
$firstname = (isset($_POST["firstname"])) ? validate_input($_POST["firstname"]) : '';
$email = (isset($_POST["email"])) ? validate_input($_POST["email"]) : '';
$phone = (isset($_POST["phone"])) ? validate_input($_POST["phone"]) : '';
$lastname = (isset($_POST["lastname"])) ? validate_input($_POST["lastname"]) : '';
$streetaddr = (isset($_POST["streetaddr"])) ? validate_input($_POST["streetaddr"]) : '';
$city = (isset($_POST["city"])) ? validate_input($_POST["city"]) : '';
$zip = (isset($_POST["zip"])) ? validate_input($_POST["zip"]) : '';
$state = (isset($_POST["state"])) ? validate_input($_POST["state"]) : '';
$cc_exp_mo = (isset($_POST["cc_exp_mo"])) ? validate_input($_POST["cc_exp_mo"]) : '';
$cc_exp_yr = (isset($_POST["cc_exp_yr"])) ? validate_input($_POST["cc_exp_yr"]) : '';
$cc_ccv = (isset($_POST["cc_ccv"])) ? validate_input($_POST["cc_ccv"]) : '';
$cc_type = (isset($_POST["cc_type"])) ? validate_input($_POST["cc_type"]) : '';
$ccnumber = (isset($_POST["ccnumber"])) ? validate_input($_POST["ccnumber"]) : '';

$errorMessage = "";


//Checking required fields adding to errorfields array

($firstname == "") ? $errorfields[] = "Please enter your first name" : '';
($streetaddr == "") ? $errorfields[] = "Please enter your street address" : '';
($city == "") ? $errorfields[] = "Please enter your city name" : '';
($zip == "") ? $errorfields[] = "Please enter your first name" : '';
($ccnumber == "") ? $errorfields[] = "Please enter your credit card number" : '';
($cc_exp_yr == "") ? $errorfields[] = "Please enter card expiration year" : '';
($cc_exp_mo == "") ? $errorfields[] = "Please enter card expiration month" : '';
($cc_type == "") ? $errorfields[] = "Please enter your credit card type" : '';
($cc_ccv == "") ? $errorfields[] = "Please enter the credit card ccv code" : '';




//Checking phone number field

if (!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$phone)) {
//$phone is not valid
    $errorfields[] = "Please enter a valid phone number";
}
//checking email field
if (empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL) === false)) {
$errorfields[] = "Please enter your email address";
}

if (empty($real_estate_con ) && empty($wellness_seminar)) {
    $errorfields[] = "Please check one event";
}

//checks for valid whole number funtion does not work neg numbers passing through
$real_estate_tickets  = valid_number($real_estate_tickets);
$wellness_tickets = valid_number($wellness_tickets);

//checks if a ticket qty is entered
if (($real_estate_con ) &&  (empty($real_estate_tickets))) {
    $errorfields[] = "Please enter qty. for real estate conference.";
}
if (($wellness_seminar ) &&  (empty($wellness_tickets))) {
    $errorfields[] = "Please enter qty for wellness seminar.";
}

if (empty($real_estate_mag_sub ) && empty($health_mag_sub)) {
    $errorfields[] = "Please check a subscription";
}

//checks for qty. of subscription
if (($real_estate_mag_sub ) &&  (empty($real_estate_mag_qty))) {
    $errorfields[] = "Please enter a qty for real estate magazine.";
}
if (($health_mag_sub ) &&  (empty($health_mag_qty))) {
    $errorfields[] = "Please enter qty for health magazine.";
}



//set session variables

$_SESSION["phone"] = $phone;
$_SESSION["firstname"] = $firstname;
$_SESSION["lastname"] = $lastname;
$_SESSION["email"] = $email;
$_SESSION["streetaddr"] = $streetaddr;
$_SESSION["city"] = $city;
$_SESSION["zip"] = $zip;
$_SESSION["state"] = $state;
$_SESSION["errors"] = $errorfields;
$_SESSION["real_estate_con"] = $real_estate_con;
$_SESSION["real_estate_tickets"] = $real_estate_tickets;
$_SESSION["wellness_seminar"] = $wellness_seminar;
$_SESSION["wellness_tickets"] = $wellness_tickets;
$_SESSION["health_mag_sub"] = $health_mag_sub;
$_SESSION["health_mag_qty"] = $health_mag_qty;
$_SESSION["real_estate_mag_qty"] = $real_estate_mag_qty;
$_SESSION["real_estate_mag_sub"] = $real_estate_mag_sub;

  if (!empty($_SESSION["errors"])) {
 header("Location:createOrder.php");
  exit;
  }

//build our application object
$app = new iSDK;

//connect to the API
if ($app->cfgCon("jad", "3464980971db56ef980086c880e64bf6")) {

    //add contact record with dupe check on email
    $contact_data = array('Email' => $email,
        'FirstName' => $firstname,
        'LastName' => $lastname,
        'Phone1' => $phone,
        'StreetAddress1' => $streetaddr,
        'City' => $city,
        'State' => $state,
        'PostalCode' => $zip);
    $contact_id = $app->addWithDupCheck($contact_data, 'Email');

    //validate credit card
    $card = array('CardType' => $cc_type,
        'ContactId' => $contact_id,
        'CardNumber' => $ccnumber,
        'ExpirationMonth' => $cc_exp_mo,
        'ExpirationYear' => $cc_exp_yr,
        'CVV2' => $cc_ccv);
    $card_validation_result = $app->validateCard($card);


    if ($card_validation_result['Valid'] == 'false') {
        $_SESSION["errors"] = array('There was the following error with your credit card: <br/>' . $card_validation_result['Message']);
        header("Location:createOrder.php");
        exit;
    }


    // add credit card for contact
    $data = array('BillName' => $firstname . " " . $lastname,
        'ContactId' => $contact_id,
        'BillAddress1' => $streetaddr,
        'BillCity' => $city,
        'BillState' => $state,
        'BillZip' => $zip,
        'CVV2' => $cc_ccv,
        'CardNumber' => $ccnumber,
        'CardType' => $cc_type,
        'Email' => $email,
        'ExpirationMonth' => $cc_exp_mo,
        'ExpirationYear' => $cc_exp_yr,
        'FirstName' => $firstname,
        'LastName' => $lastname,
        'NameOnCard' => $firstname . " " . $lastname);

    $card_card_id = $app->dsAdd("CreditCard", $data);


    //Sets current date
    $currentDate = date("d-m-Y");
    $oDate = $app->infuDate($currentDate);


    // checks if order id already set if so skips and does not make another order
    if (!isset($_SESSION["orderid"])) {
        //Creates blank order
        $order_id = $app->blankOrder($contact_id, "New Order for Contact ", $oDate, 0, 0);
        echo "newOrder=" . $order_id . "<br/>";
        //Adds items to order
        if (!empty($real_estate_tickets)) {
            $result = $app->addOrderItem($order_id, 2049, 4, 75.00, $real_estate_tickets, "Real Estate Conference", "Real Estate Conference");
            echo "item added<br/>";
            //testing results of add order
        }
        if (!empty($wellness_tickets)) {
            var_dump($wellness_tickets);
            $result = $app->addOrderItem($order_id, 2047, 4, 150.00, $wellness_tickets, "Wellness seminar", "Wellness seminar");
            echo "item added<br/>";
        }


         //creates a subscription id and invoice id

        if (!empty($health_mag_qty)) {
            $subscriptionId = $app->addRecurringAdv($contact_id, true, 183, $health_mag_qty, 10.00, true, $merchant_id, $card_card_id, 0, 30);
            //creates invoice for all charges due on the subscription
            $invoiceID = $app->recurringInvoice($subscriptionId);
            //adds subscription to order
            $result = $app->addOrderItem($order_id,2051, 4, 10.00, $health_mag_qty,"Health magazine subscription", "Health magazine subsciption" );

        }

        if (!empty($real_estate_mag_qty)){
            $subscriptionId = $app->addRecurringAdv($contact_id, true, 185, $real_estate_mag_qty, 7.00, true, $merchant_id, $card_card_id,0, 30);
            //creates invoice for all charges due on the subscription
            $invoiceID = $app->recurringInvoice($subscriptionId);
            //adds subscription to order
            $result = $app->addOrderItem($order_id, 2053, 4, 7.00, $real_estate_mag_qty,"Real estate magazine subscription", " Real estate magazine subscription" );

        }


        //Adds order id to session from order
        $_SESSION["orderid"] = $order_id;
        $_SESSION["subscriptionId"] = $invoiceId;
        } else {
        //adds order id  and invoice id to session order was previously placed but declined
        $order_id = $_SESSION['orderid'];
        $invoiceId = $_SESSION['invoiceid'];
        }


    //Charge the invoice for new order with the latest credit card
    $result = $app->chargeInvoice($order_id, "Cutomer Paid", $card_card_id, $merchant_id, false);

    //Checks if the result is set and sends user to either thank you page or order page
    if (isset($result)) {
        $_SESSION["approval"] = $result;
        if ($result["Successful"] == false) {
            //redirect back to create the order
            header("Location:createOrder.php");
            exit();
        }   // Credit card authorized send to thank you page
        else {
            //Tag the contact record with shopped tag
            $tagId = 3455;
            $result = $app->grpAssign($contact_id, $tagId);
            header("Location:thankYou.php");
        }
    } else {

    }      //connection error to Infusionsoft
    }


    // validates input data
    function validate_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    // checks for whole number entered
    function valid_number($data)
    {
        if (floor($data) == $data) {
            return $data;
        } else {
            $data = 0;
        }
        return $data;
    }


?>