<?php 
/**
 * This merchant demo is published by Writerz Wall/Bookeey as a demonstration of the process
 * of Online Bookeey Payment Gateway Transactions Requery.
 * 
 * Note:- However this is not a fully running demo and there are parts that the merchant
 * has to build him self as per the requirements of their corresponding project.
 * Also, this demo is not tested for security or stability, and Writerz Wall/Bookeey does not intend to recommend
 * this for production purposes. Merchants should build their own web pages based on their needs. 
 * This demo is just a guide as to what the whole process will look like.
 * 
 */

ini_set("display_errors", "1");
error_reporting(E_ALL);
include_once("bookeey.php");
$bookeeyPipe = new bookeey;
$bookeeyPipe->setMerchantID('mer160009');    // Set the Merchant ID
$bookeeyPipe->setSecretKey('1234567');    // Set the Secret Key
 // Pass Transaction Ids in the array
$orderIds = array(
    "211744346",
    "272884101"
);
$transactionData = $bookeeyPipe->getPaymentStatus($orderIds);
echo "<pre>";
print_r($transactionData);
?>