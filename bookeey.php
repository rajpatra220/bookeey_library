<?php
/**
 * @package Bookeey Payment Gateway Library
 * @version 2.0.0
 * @author Writerz Wall
 * @link https://writerzwall.com
 * 
 * This is the core library class for the implementation of
 * Bookeey Payment Gateway in PHP.
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License version 3.0
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details at 
 * https://www.gnu.org/licenses/lgpl-3.0.html
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. Please check the license for more details.
 * 
 */

const APP_VERSION = "2.0.0";
const API_VERSION = "2.0.0";

///////////////////////////////////////
//Payment Option Codes. DO NOT CHANGE//
///////////////////////////////////////

const KNET_CODE = "knet";
const CREDIT_CODE = "credit";
const BOOKEEY_CODE = "Bookeey";
const AMEX_CODE = "amex";


///////////////////////////////////////////////////////////
//Payment Option Titles. Merchant may change these titles//
///////////////////////////////////////////////////////////

const KNET_TITLE = "KNET";
const CREDIT_TITLE = "Credit Card";
const BOOKEEY_TITLE = "Bookeey PG";
const AMEX_TITLE = "AMEX";


/////////////////////////////////////////////
//Bookeey Payment Gateway Merchant Settings//
/////////////////////////////////////////////


/**
 * Default Payment Option
 * Type: Constant Variable | String
 * Possible Values: Enter the payment option code or the corresponding constant variable which will be used as default payment option.
 */
const DEFAULT_PAYMENT_OPTION = BOOKEEY_CODE;

/**
 * Enable/Disable Payment Method
 * Type: Integer
 * Possible Values: 0 (Disable) | 1 (Enable)
 */
const IS_ENABLE = 1;

/**
 * Enable/Disable Test Mode
 * Type: Integer
 * Possible Values:  0 (Enable Live Mode) | 1 (Enable Test Mode)
 */
const IS_TEST_MODE_ENABLE = 1;

/**
 * Payment Method Title
 * Type: String
 * Possible Values: Any string type values possible
 */
const TITLE = "Bookeey Payment";

/**
 * Payment Method Description
 * Type: String
 * Possible Values: Any string type values possible
 */
const DESCRIPTION = "Pay with Bookeey payment";

/**
 * Merchant ID
 * Type: String
 * Possible Values: Enter the Merchant Id provided by Bookeey.
 */
const MERCHANT_ID = "";

/**
 * Secret Key
 * Type: String
 * Possible Values: Enter the Secret Key provided by Bookeey.
 */
const SECRET_KEY = "";


/////////////////////////////////////////
//Bookeey Payment Gateway Configuration//
/////////////////////////////////////////

/**
 * Success URL
 * Type: String
 * Possible Values: Enter the Success Page URL as per your project.
 */
const SUCCESS_URL = "http://localhost:9090/bookeey_library/success.php";

/**
 * Failure URL
 * Type: String
 * Possible Values: Enter the Failure Page URL as per your project.
 */
const FAILURE_URL = "http://localhost:9090/bookeey_library/failure.php";

/**
 * Test Bookeey Payment Gateway URL
 * Type: String
 * CRITICAL: DO NOT CHANGE THIS VALUE.
 */
const TEST_BOOKEEY_PAYMENT_GATEWAY_URL = "https://apps.bookeey.com/pgapi/api/payment/requestLink";

/**
 * Live Bookeey Payment Gateway URL
 * Type: String
 * CRITICAL: DO NOT CHANGE THIS VALUE.
 */
const LIVE_BOOKEEY_PAYMENT_GATEWAY_URL = "https://pg.bookeey.com/internalapi/api/payment/requestLink";

/**
 * Test Bookeey Payment Requery URL
 * Type: String
 * CRITICAL: DO NOT CHANGE THIS VALUE.
 */
const TEST_BOOKEEY_PAYMENT_REQUERY_URL = "https://apps.bookeey.com/pgapi/api/payment/paymentstatus";

/**
 * Live Bookeey Payment Requery URL
 * Type: String
 * CRITICAL: DO NOT CHANGE THIS VALUE.
 */
const LIVE_BOOKEEY_PAYMENT_REQUERY_URL = "https://pg.bookeey.com/internalapi/api/payment/paymentstatus";

/**
 * Payment Options
 * Type: Array
 * CRITICAL: DO NOT CHANGE THESE VALUES
 */
const PAYMENT_OPTIONS = array(
    array(
        'is_active' => 1,
        'title' => KNET_TITLE,
        'code' => KNET_CODE
    ),
    array(
        'is_active' => 1,
        'title' => CREDIT_TITLE,
        'code' => CREDIT_CODE
    ),
    array(
        'is_active' => 1,
        'title' => BOOKEEY_TITLE,
        'code' => BOOKEEY_CODE
    ),
    array(
        'is_active' => 1,
        'title' => AMEX_TITLE,
        'code' => AMEX_CODE
    )
);

class bookeey {

    var $isEnable;
    var $isTestModeEnable;
    var $title;
    var $description;
    var $merchantID;
    var $secretKey;
    var $successUrl;
    var $failureUrl;
    var $testBookeeyPaymentGatewayUrl;
    var $liveBookeeyPaymentGatewayUrl;
    var $testBookeeyPaymentRequeryUrl;
    var $liveBookeeyPaymentRequeryUrl;
    var $defaultPaymentOption;
    var $paymentOptions;
    var $amount;
    var $selectedPaymentOption;
    var $orderId;
    var $payerName;
    var $payerPhone;

    function __construct() {
        $this->isEnable = IS_ENABLE;
        $this->isTestModeEnable = IS_TEST_MODE_ENABLE;
        $this->title = TITLE;
        $this->description = DESCRIPTION;
        $this->merchantID = MERCHANT_ID;
        $this->secretKey = SECRET_KEY;
        $this->successUrl = SUCCESS_URL;
        $this->failureUrl = FAILURE_URL;
        $this->testBookeeyPaymentGatewayUrl = TEST_BOOKEEY_PAYMENT_GATEWAY_URL;
        $this->liveBookeeyPaymentGatewayUrl = LIVE_BOOKEEY_PAYMENT_GATEWAY_URL;
        $this->testBookeeyPaymentRequeryUrl = TEST_BOOKEEY_PAYMENT_REQUERY_URL;
        $this->liveBookeeyPaymentRequeryUrl = LIVE_BOOKEEY_PAYMENT_REQUERY_URL;
        $this->defaultPaymentOption = DEFAULT_PAYMENT_OPTION;
        $this->paymentOptions = PAYMENT_OPTIONS;
        $this->amount = '';
        $this->selectedPaymentOption = $this->defaultPaymentOption;
        $this->orderId = '';
        $this->payerName = '';
        $this->payerPhone = '';
    }


    /**
     * Get the Enable/Disable Status of the Payment Method
     * Return Type: Integer
     * Possible Values: 0 (Disable) | 1 (Enable)
     */
    function isEnable() {
        return $this->isEnable;
    }

    /**
     * Set the Enable/Disable Status of the Payment Method
     * Argument Type: Integer
     * Possible Values: 0 (Disable) | 1 (Enable)
     */
    function setIsEnable($data) {
        $this->isEnable = $data;
    }

    /**
     * Get the Enable/Disable status of the Test Mode
     * Return Type: Integer
     * Possible Values:  0 (Enable Live Mode) | 1 (Enable Test Mode)
     */
    function isTestModeEnable() {
        return $this->isTestModeEnable;
    }

    /**
     * Set the Enable/Disable status of the Test Mode
     * Argument Type: Integer
     * Possible Values:  0 (Enable Live Mode) | 1 (Enable Test Mode)
     */
    function setIsTestModeEnable($data) {
        $this->isTestModeEnable = $data;
    }

    /**
     * Get the Payment Method Title
     * Return Type: String
     * Possible Values: Any string type values possible
     */
    function getTitle() {
        return $this->title;
    }

    /**
     * Set the Payment Method Title
     * Argument Type: String
     * Possible Values: Any string type values possible
     */
    function setTitle($data) {
        $this->title = $data;
    }


    /**
     * Get the Payment Method Description
     * Return Type: String
     * Possible Values: Any string type values possible
     */
    function getDescription() {
        return $this->description;
    }

    /**
     * Set the Payment Method Description
     * Argument Type: String
     * Possible Values: Any string type values possible
     */
    function setDescription($data) {
        $this->description = $data;
    }


    /**
     * Get Merchant ID
     * Return Type: String
     */
    function getMerchantID() {
        return $this->merchantID;
    }

    /**
     * Set Merchant ID
     * Argument Type: String
     * Possible Values: Enter the Merchant Id provided by Bookeey.
     */
    function setMerchantID($data) {
        $this->merchantID = $data;
    }


    /**
     * Get Secret Key
     * Return Type: String
     */
    function getSecretKey() {
        return $this->secretKey;
    }

    /**
     * Set Secret Key
     * Argument Type: String
     * Possible Values: Enter the Secret Key provided by Bookeey.
     */
    function setSecretKey($data) {
        $this->secretKey = $data;
    }


    /**
     * Get Success URL
     * Return Type: String
     */
    function getSuccessUrl() {
        return $this->successUrl;
    }

    /**
     * Set Success URL
     * Argument Type: String
     * Possible Values: Enter the Success Page URL as per your project.
     */
    function setSuccessUrl($data) {
        $this->successUrl = $data;
    }


    /**
     * Get Failure URL
     * Return Type: String
     */
    function getFailureUrl() {
        return $this->failureUrl;
    }

    /**
     * Set Failure URL
     * Argument Type: String
     * Possible Values: Enter the Failure Page URL as per your project.
     */
    function setFailureUrl($data) {
        $this->failureUrl = $data;
    }


    /**
     * Get Amount
     * Return Type: Integer | Float
     */
    function getAmount() {
        return $this->amount;
    }

    /**
     * Set Amount
     * Argument Type: Integer | Float
     * Possible values: Enter any Integer or Float type number
     */
    function setAmount($data) {
        $this->amount = $data;
    }


    /**
     * Get Order Id
     * Type: Integer | String
     * Note: Order ID should be unique for each transaction.
     */
    function getOrderId() {
        return $this->orderId;
    }

    /**
     * Set Order Id
     * Type: Integer | String
     * Note: Order ID should be unique for each transaction.
     */
    function setOrderId($data) {
        $this->orderId = $data;
    }


    /**
     * Get Payer Name
     * Type: String
     */
    function getPayerName() {
        return $this->payerName;
    }

    /**
     * Set Payer Name
     * Type: String
     */
    function setPayerName($data) {
        $this->payerName = $data;
    }
    

    /**
     * Get Payer Phone
     * Type: String
     */
    function getPayerPhone() {
        return $this->payerPhone;
    }

    /**
     * Set Payer Phone
     * Type: String
     */
    function setPayerPhone($data) {
        $this->payerPhone = $data;
    }


    /**
     * Get Default Payment Option
     * Return Type: String
     */
    function getDefaultPaymentOption() {
        return $this->defaultPaymentOption;
    }

    /**
     * Set Default Payment Option
     * Argument Type: Constant Variable | String
     * Possible Values: Enter the payment option code or the corresponding constant variable which will be used as default payment option.
     */
    function setDefaultPaymentOption($data) {
        $this->defaultPaymentOption = $data;
    }

    /**
     * Get Selected Payment Option
     * Return Type: String
     */
    function getSelectedPaymentOption() {
        return $this->selectedPaymentOption;
    }

    /**
     * Set Selected Payment Option
     * Argument Type: Constant Variable | String
     * Possible Values: Enter the payment option code or the corresponding constant variable which will be used as selected payment option.
     */
    function setSelectedPaymentOption($data) {
        $this->selectedPaymentOption = $data;
    }


    /**
     * Get Test Bookeey Payment Gateway URL
     * Return Type: String
     */
    function getTestBookeeyPaymentGatewayUrl(){
        return $this->testBookeeyPaymentGatewayUrl;
    }

    /**
     * Get Live Bookeey Payment Gateway URL
     * Return Type: String
     */
    function getLiveBookeeyPaymentGatewayUrl() {
        return $this->liveBookeeyPaymentGatewayUrl;
    }


    /**
     * Get Test Bookeey Payment Requery URL
     * Return Type: String
     */
    function getTestBookeeyPaymentRequeryUrl(){
        return $this->testBookeeyPaymentRequeryUrl;
    }

    /**
     * Get Live Bookeey Payment Requery URL
     * Return Type: String
     */
    function getLiveBookeeyPaymentRequeryUrl() {
        return $this->liveBookeeyPaymentGatewayUrl;
    }


    /**
     * Get All Payment Options
     * Return Type: Array
     */
    function getPaymentOptions() {
        return $this->paymentOptions;
    }

    /**
     * Get Active Payment Options
     * Return Type: Array
     */
    function getActivePaymentOptions() {
        $paymentOptions = $this->getPaymentOptions();
        $activePaymentOptions = array_filter($paymentOptions, function ($var) {
            return ($var['is_active'] == 1);
        });

        return $activePaymentOptions;
    }

    /**
     * Get Bookeey Payment Gateway URL as per Active Mode
     * Type: String
     */
    function getBookeeyPaymentGatewayUrl() {
        $isTestModeEnable = $this->isTestModeEnable();

        if($isTestModeEnable) {
            $bookeeyPaymentGatewayUrl = $this->getTestBookeeyPaymentGatewayUrl();
        }else{
            $bookeeyPaymentGatewayUrl = $this->getLiveBookeeyPaymentGatewayUrl();
        }
        
        return $bookeeyPaymentGatewayUrl;
    }

    /**
     * Get Bookeey Payment Requery URL as per Active Mode
     * Type: String
     */
    function getBookeeyPaymentRequeryUrl() {
        $isTestModeEnable = $this->isTestModeEnable();

        if($isTestModeEnable) {
            $bookeeyPaymentRequeryUrl = $this->getTestBookeeyPaymentRequeryUrl();
        }else{
            $bookeeyPaymentRequeryUrl = $this->getLiveBookeeyPaymentRequeryUrl();
        }
        
        return $bookeeyPaymentRequeryUrl;
    }


    /**
     * Initiate Payment
     * Argument: Array (Pass the sub merchant id(s) and amount for each transaction in the array)
     */
    function initiatePayment($transactionDetails){
        session_start();
        $sessionId = session_id();
        $systemInfo = $this->systemInfo();
        $browser = $this->browser();
        $payerName = $this->getPayerName();
        $payerPhone = $this->getPayerPhone();
        $mid = $this->getMerchantID();
        $tex = $random_pwd = mt_rand(1000000000000000, 9999999999999999);
        $txnRefNo = $tex;
        $su = $this->getSuccessUrl();
        $fu = $this->getFailureUrl();
        $amt = $this->getAmount();
        $orderId = $this->getOrderId();
        // $txnTime = "1545633631518";
        // $txnTime = date("ymdHis");
        $rndnum = rand(10000,99999);
        $crossCat = "GEN";
        $secretKey = $this->getSecretKey();
        $defaultPaymentOption = $this->getDefaultPaymentOption();
        $selectedPaymentOption = $this->getSelectedPaymentOption();
        $paymentoptions = ($selectedPaymentOption == '') ? $defaultPaymentOption : $selectedPaymentOption;
        $data = "$mid|$txnRefNo|$su|$fu|$amt|$crossCat|$secretKey|$rndnum";
        $hashed = hash('sha512', $data);

        $paymentGatewayUrl = $this->getBookeeyPaymentGatewayUrl();

        $txnDtl = $transactionDetails;

        $txnHdr = array(
            "PayFor" => "ECom",
            "Txn_HDR" => $rndnum,
            "PayMethod" => $paymentoptions,
            "BKY_Txn_UID" => "",
            "Merch_Txn_UID" => $orderId,
            "hashMac" => $hashed
        );

        $appInfo = array(
            "APPTyp" => "",
            "OS" => $systemInfo['os'].' - '.$browser,
            "DevcType" => $systemInfo['device'],
            "IPAddrs" => $_SERVER['SERVER_ADDR'],
            "Country" => "",
            "AppVer" => APP_VERSION,
            "UsrSessID" => $sessionId,
            "APIVer" => API_VERSION
        );

        $pyrDtl = array(
            "Pyr_MPhone" => $payerPhone,
            "Pyr_Name" => $payerName
        );

        $merchDtl = array(
            "BKY_PRDENUM" => "ECom",
            "FURL" => $fu,
            "MerchUID" => $mid,
            "SURL" => $su
        );

        $moreDtl = array(
            "Cust_Data1" => "",
            "Cust_Data3" => "",
            "Cust_Data2" => ""
        );
        
        $postParams['Do_TxnDtl'] = $txnDtl;
        $postParams['Do_TxnHdr'] = $txnHdr;
        $postParams['Do_Appinfo'] = $appInfo;
        $postParams['Do_PyrDtl'] = $pyrDtl;
        $postParams['Do_MerchDtl'] = $merchDtl;
        $postParams['DBRqst'] = "PY_ECom";
        $postParams['Do_MoreDtl'] = $moreDtl;

        $ch = curl_init();

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        curl_setopt($ch, CURLOPT_URL,$paymentGatewayUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParams));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $serverOutput = curl_exec($ch);
        $decodeOutput = json_decode($serverOutput, true);
        curl_close ($ch);

        if (isset($decodeOutput['PayUrl'])) {
            if ($decodeOutput['PayUrl'] == '') {
                echo "Error Message: ".$decodeOutput['ErrorMessage'];
            }else{
                header("Location: ".$decodeOutput['PayUrl']);
            }   
        }else if(isset($decodeOutput['Message'])){
            echo "Error Message: ".$decodeOutput['Message'];
        }else{
            echo "Error<br>";
            print_r($decodeOutput);
        }
    }


    /**
     * Get Updated Transaction Status from Bookeey Payment Requery Url
     * Argument: String (Pass the Transaction Id for which you want to get the updated status)
     */
    function getPaymentStatus($orderIds){
        $requeryUrl = $this->getBookeeyPaymentRequeryUrl();

        $mid = $this->getMerchantID();
        $rndnum = rand(10000,99999);
        $secretKey = $this->getSecretKey();

        $data = "$mid|$secretKey|$rndnum";
        $hashed = hash('sha512', $data);

        $postParams['Mid'] = $mid;
        $postParams['MerchantTxnRefNo'] = $orderIds;
        $postParams['HashMac'] = $hashed;

        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL,$requeryUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postParams));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $serverOutput = curl_exec($ch);
        $decodeOutput = json_decode($serverOutput, true);
        curl_close ($ch);

        return $decodeOutput;
    }


    /**
     * Get System information
     */
    function systemInfo()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform    = "Unknown OS Platform";
        $os_array       = array(
            '/windows nt 10.0/i'    =>  'Windows 10',
            '/windows phone 8/i'    =>  'Windows Phone 8',
            '/windows phone os 7/i' =>  'Windows Phone 7',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        $found = false;
        $device = '';

        foreach ($os_array as $regex => $value) 
        { 
            if($found)
                break;
            else if (preg_match($regex, $user_agent)) 
            {
                $os_platform = $value;
                $device = !preg_match('/(windows|mac|linux|ubuntu)/i',$os_platform)
                        ?'MOBILE':(preg_match('/phone/i', $os_platform)?'MOBILE':'SYSTEM');
            }
        }
        $device = !$device? 'SYSTEM':$device;

        return array('os'=>$os_platform,'device'=>$device);
    }


    /**
     * Get Browser information
     */
    function browser() 
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser        =   "Unknown Browser";
        $browser_array  = array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Mozilla Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Google Chrome',
            '/edge/i'       =>  'Microsoft Edge',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        );

        $found = false;

        foreach ($browser_array as $regex => $value) 
        { 
            if($found)
            break;
            else if (preg_match($regex, $user_agent,$result)) 
            {
                $browser = $value;
            }
        }

        return $browser;
    }
}
?>