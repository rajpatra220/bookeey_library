<?php 
/**
 * This merchant demo is published by Writerz Wall/Bookeey as a demonstration of the process
 * of Online Bookeey Payment Gateway Transactions.
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
$isEnable = $bookeeyPipe->isEnable();

if($isEnable){
    /* $bookeeyPipe->setTitle('Custom Title');
    $bookeeyPipe->setDescription('Custom Description'); */
    $bookeeyPipe->setMerchantID('');    // Set the Merchant ID
    $bookeeyPipe->setSecretKey('');    // Set the Secret Key
    $bookeeyPipe->setAmount(4.5);  // Set amount in KWD
    if (isset($_REQUEST['selectedPaymentOption'])) {
        $selectedPaymentOption = $_REQUEST['selectedPaymentOption'];
        $bookeeyPipe->setSelectedPaymentOption($selectedPaymentOption);
    }else {
        $selectedPaymentOption = $bookeeyPipe->getDefaultPaymentOption();
    }
    $mode = ($bookeeyPipe->isTestModeEnable()) ? "Test Mode Enabled" : "Live Mode Enabled";
    // $paymentOptions = $bookeeyPipe->getPaymentOptions();    // Get All Payment Options
    $paymentOptions = $bookeeyPipe->getActivePaymentOptions();    // Get Active Payment Options
  
    $postParams = $bookeeyPipe->preparePostParams();   // Get Post Parameters

    $bookeeyArgArray = array();
    foreach ($postParams as $key => $value) {
        $bookeeyArgArray[] = '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
    }
    ?>
    <h1>*** <?php echo $mode;?> ***</h1>
    <h2><?php echo $bookeeyPipe->getTitle();?></h2>
    <h3><?php echo $bookeeyPipe->getDescription();?></h3>
    <h4>Amount: <?php echo $bookeeyPipe->getAmount()." KWD";?></h4>
    <form id="bookeeyPaymentForm" action="<?php echo $bookeeyPipe->getBookeyPaymentGatewayUrl();?>" method="POST">
    <?php 
    echo implode('', $bookeeyArgArray);
    foreach ($paymentOptions as $option) {
        ?>
        <input type="radio" name="payoptions" id="payoptions" onchange="updateCheckout()" value="<?php echo $option['code'];?>" <?php echo ($option['code'] == $selectedPaymentOption) ? "checked" : ""; ?>><?php echo $option['title'];?><br/>
    <?php 
    }?>
    <br>
    <button type="submit">Place Order</button>
    </form>
<?php 
}else{
    echo "<h1>Payment Gateway is Disable</h1>";
}

?>

<script type="text/javascript">
function updateCheckout() {
    var selectedPaymentOption = getRadioVal( document.getElementById('bookeeyPaymentForm'), 'payoptions' );
    var url = "http://localhost:9090/bookeeyPayment/buy.php?selectedPaymentOption="+selectedPaymentOption;
    window.location.replace(url);
}

function getRadioVal(form, name) {
    var val;
    // get list of radio buttons with specified name
    var radios = form.elements[name];
    
    // loop through list of radio buttons
    for (var i=0, len=radios.length; i<len; i++) {
        if ( radios[i].checked ) { // radio checked?
            val = radios[i].value; // if so, hold its value in val
            break; // and break out of for loop
        }
    }
    return val; // return value of checked radio or undefined if none checked
}
</script>