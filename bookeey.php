<?php
/**
 * @package Bookeey Payment Gateway Library
 * @version 1.0.0
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


///////////////////////////////////////
//Payment Option Codes. DO NOT CHANGE//
///////////////////////////////////////

const KNET_CODE = "knet";
const CREDIT_CODE = "credit";
const BOOKEEY_CODE = "Bookeey";


///////////////////////////////////////////////////////////
//Payment Option Titles. Merchant may change these titles//
///////////////////////////////////////////////////////////

const KNET_TITLE = "KNET";
const CREDIT_TITLE = "Credit Card";
const BOOKEEY_TITLE = "Bookeey PG";


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
const SUCCESS_URL = "success.php";

/**
 * Failure URL
 * Type: String
 * Possible Values: Enter the Failure Page URL as per your project.
 */
const FAILURE_URL = "failure.php";

/**
 * Test Bookeey Payment Gateway URL
 * Type: String
 * CRITICAL: DO NOT CHANGE THIS VALUE.
 */
const TEST_BOOKEEY_PAYMENT_GATEWAY_URL = "https://demo.bookeey.com/portal/bookeeyPg";

/**
 * Live Bookeey Payment Gateway URL
 * Type: String
 * CRITICAL: DO NOT CHANGE THIS VALUE.
 */
const LIVE_BOOKEEY_PAYMENT_GATEWAY_URL = "https://www.bookeey.com/portal/bookeeyPg";

/**
 * Test Bookeey Payment Requery URL
 * Type: String
 * CRITICAL: DO NOT CHANGE THIS VALUE.
 */
const TEST_BOOKEEY_PAYMENT_REQUERY_URL = "https://demo.bookeey.com/portal/paymentrequery";

/**
 * Live Bookeey Payment Requery URL
 * Type: String
 * CRITICAL: DO NOT CHANGE THIS VALUE.
 */
const LIVE_BOOKEEY_PAYMENT_REQUERY_URL = "https://www.bookeey.com/portal/paymentrequery";

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
        $this->amount = 2.5;
        $this->selectedPaymentOption = '';
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
    function getBookeyPaymentGatewayUrl() {
        $isTestModeEnable = $this->isTestModeEnable();

        if($isTestModeEnable) {
            $bookeyPaymentGatewayUrl = $this->getTestBookeeyPaymentGatewayUrl();
        }else{
            $bookeyPaymentGatewayUrl = $this->getLiveBookeeyPaymentGatewayUrl();
        }
        
        return $bookeyPaymentGatewayUrl;
    }

    /**
     * Get Bookeey Payment Requery URL as per Active Mode
     * Type: String
     */
    function getBookeyPaymentRequeryUrl() {
        $isTestModeEnable = $this->isTestModeEnable();

        if($isTestModeEnable) {
            $bookeyPaymentRequeryUrl = $this->getTestBookeeyPaymentRequeryUrl();
        }else{
            $bookeyPaymentRequeryUrl = $this->getLiveBookeeyPaymentRequeryUrl();
        }
        
        return $bookeyPaymentRequeryUrl;
    }


    /**
     * Prepare and Get Post Parameters for the Payment
     * Type: Array
     */
    function preparePostParams(){
        $mid = $this->getMerchantID();
        $tex = $random_pwd = mt_rand(1000000000000000, 9999999999999999);
        $txnRefNo = $tex;
        $su = $this->getSuccessUrl();
        $fu = $this->getFailureUrl();
        $amt = $this->getAmount();
        // $txnTime = "1545633631518";
        $txnTime = date("ymdHis");
        $crossCat = "GEN";
        $secretKey = $this->getSecretKey();
        $defaultPaymentOption = $this->getDefaultPaymentOption();
        $selectedPaymentOption = $this->getSelectedPaymentOption();
        $paymentoptions = ($selectedPaymentOption == '') ? $defaultPaymentOption : $selectedPaymentOption;
        $data = "$mid|$txnRefNo|$su|$fu|$amt|$txnTime|$crossCat|$secretKey";
        $hashed = hash('sha512', $data);
        
        //Form Post Params
        //Important: The order of the following parameters are ESSENTIAL for the encryption to work.
        $params['mid']       = $mid;
        $params['txnRefNo']  = $txnRefNo;
        $params['surl']      = $su;
        $params['furl']      = $fu;
        $params['amt']       = $amt;
        $params['crossCat']  = $crossCat;
        $params['hashMac']   = $hashed;
        $params['status']    = '';
        $params['code']      = '';
        $params['msg']       = '';
        $params['txnid'] = '';
        $params['txnTime'] = $txnTime;
        $params['customerHash'] = '';
        $params['returnHash'] = '';
        $params['paymentoptions'] = $paymentoptions;

        //Encrypt values to create the AuthHash
        $post_values = "";
        foreach ($params as $key => $value) {
            $post_values .= $value;
        }
        $post_values .= $secretKey;

        $params['ShowTransactionResult'] = 0;

        //Adding to the form params the AuthHash
        $params['AuthHash'] = $this->encryptAndEncode($post_values);

        return $params;
    }

    /**
     * Encrypt and Encode the Post Params
     */
    function encryptAndEncode($strIn)
    {
        //The encryption required by bookeey is SHA-512
        $result = mb_convert_encoding($strIn, 'UTF-16LE', 'ASCII');
        $result = hash('sha512', $result);
        return $result;
    }


    /**
     * Get Updated Transaction Status from Bookeey Payment Requery Url
     * Argument: String (Pass the Transaction Id for which you want to get the updated status)
     */
    function transactionRequery($transactionId){
        $requeryUrl = $this->getBookeyPaymentRequeryUrl();
        $ch = curl_init();
        $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, $requeryUrl.'?txnId='.$transactionId);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $decodedata = json_decode($result, true);

        return $decodedata;
    }
}
?>