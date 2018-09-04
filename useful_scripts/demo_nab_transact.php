<?php

// demo test NAB transact

$demo = true;

if($demo) $trans_pass = 'abcd1234';
else $trans_pass = '4LE9mU7K';

// $trans_pass = 'abc123';
// $trans_pass = 'abcd1234';

// EPS_MERCHANT ( digit NAB Transact Client ID)
if($demo) $merchant = 'XYZ0010';
else $merchant = '6H70010';
// $merchant = 'XYZ0010';

if($demo) $action_url = 'https://demo.transact.nab.com.au/directpostv2/authorise">';
else $action_url = 'https://transact.nab.com.au/live/directpostv2/authorise">';


// EPS_TXNTYPE (type transaction, payment realtime=0)

// EPS_REFERENCEID (строка id корзины)
$referenceid = '157';

$txntype = 0;

// EPS_AMOUNT
$amount = '7.00';

$timestamp = as21_timestamp();

// EPS_FINGERPRINT (EPS_MERCHANT|TransactionPassword|EPS_TXNTYPE|EPS_REFERENCEID|EPS_AMOUNT|EPS_TIMESTAMP )
$fingerprint = $merchant.'|'.$trans_pass.'|'.$txntype.'|'.$referenceid.'|'.$amount.'|'.$timestamp;
$fingerprint_hash = sha1($fingerprint);

//EPS_RESULTURL (only https trusted ssl, res page on your website)
// $resulturl = 'https://www.resulturl.com';
$resulturl = 'https://aussieglo-new.webyourway.com.au/pay.php';
/**
 * Generates payment fingerprint
 *
 * @param $settings_fields
 *  An associative array containing settings required to fingerprint generation
 * @param $password
 * @return Base64-encoded fingerprint string
 */
function commerce_securepayau_direct_post_generate_payment_fingerprint($settings_fields, $password) {
  $signature_fields = array(
    $settings_fields['EPS_MERCHANT'],
    $password,
    $settings_fields['EPS_TXNTYPE'],
    $settings_fields['EPS_REFERENCEID'],
    $settings_fields['EPS_AMOUNT'],
    $settings_fields['EPS_TIMESTAMP'],
  );

  return sha1(implode('|', $signature_fields));
}


/**
 * Returns the current time as a NAB friendly timestamp.
 * @return string
 *  Timestamp string in YYYYMMDDHHMMSS format
 */
function as21_timestamp() {
  $datetime = new DateTime();
  $datetime->setTimezone(new DateTimezone('UTC'));
  $timestamp = $datetime->format('YmdHis');
  return $timestamp;
}

echo as21_timestamp();
echo "<br>";
echo $fingerprint;
echo "<br>";
// echo $digest = sha1($fingerprint);
// echo "<br>";
// echo $digest = sha1('XYZ0010|abcd1234|0|Test Reference|1.00|20140224221931');
// echo "<br>";

print_r($_POST);
print_r($_GET);

/*
 summarycode 
1 = Approved
2 = Declined by the bank
3 = Declined for any other reason
Use "rescode" and "restext" for more detail of the transaction result.
*/
?>

<form method="post" action="<?php echo $action_url;?>">
<input type="hidden" name="EPS_FIRSTNAME" value="vin">
<input type="hidden" name="EPS_LASTNAME" value="dizel">
<input type="hidden" name="EPS_ZIPCODE" value="428018">
<input type="hidden" name="EPS_TOWN" value="ufa">
<input type="hidden" name="EPS_EMAILADDRESS" value="freerun-2012@yandex.ru">
<input type="hidden" name="EPS_MERCHANT" value="<?php echo $merchant;?>">
<input type="hidden" name="EPS_TXNTYPE" value="<?php echo $txntype;?>">
<input type="hidden" name="EPS_REFERENCEID" value="<?php echo $referenceid;?>">
<input type="hidden" name="EPS_AMOUNT" value="<?php echo $amount;?>">
<input type="hidden" name="EPS_TIMESTAMP" value="<?php echo $timestamp;?>">
<input type="hidden" name="EPS_FINGERPRINT" value="<?php echo $fingerprint_hash;?>">
<input type="hidden" name="EPS_RESULTURL" value="<?php echo $resulturl;?>">
<input type="hidden" name="EPS_REDIRECT" value="TRUE">
<input type="hidden" name="return_link_url" value="<?php echo $resulturl;?>" >
<input type="text" name="EPS_CARDNUMBER" value="4444333322221111">
<input type="text" name="EPS_EXPIRYMONTH" value="05">
<input type="text" name="EPS_EXPIRYYEAR" value="2019">
<input type="text" name="EPS_CCV" value="123">
<input type="submit" name="send" value="send">
</form>

<!--  -->

<?php
      $timestamp = date('YmdHis');
      $referenceid = isset($_SESSION['user'])? $timestamp.$_SESSION['user'].rand(1, 1000000000000000) : $timestamp.rand(1, 1000000000000000);
      $referenceid = sha1($referenceid);
      $transaction_type =0;
      $amount = "53.00";

      $merchantid = "XYZ0010";
      $transaction_password = "abcd1234";

      $sha1 = $merchantid."|".$transaction_password."|".$transaction_type."|".$referenceid."|".$amount."|".$timestamp;
      $fingerprint = sha1($sha1);
      isset($_POST)? print_r($_POST) : '';
?>
    <form method="post" action="https://demo.transact.nab.com.au/directpostv2/authorise">

        <input type="hidden" name="EPS_MERCHANT" value="<?= $merchantid ?>">
        <input type="hidden" name="EPS_TXNTYPE" value="<?= $transaction_type ?>">
        <input type="hidden" name="EPS_REFERENCEID" value="<?= $referenceid ?>">
        <input type="hidden" name="EPS_AMOUNT" value="<?= $amount ?>">
        <input type="hidden" name="EPS_TIMESTAMP" value="<?= $timestamp ?>">
        <input type="hidden" name="EPS_FINGERPRINT" value="<?= $fingerprint ?>">
        <input type="hidden" name="EPS_RESULTURL" value="https://xxx.xxx.xxx/nab.php">

        Card Number <input type="text" name="EPS_CARDNUMBER">
<select name="EPS_EXPIRYMONTH">
 <option value="01">01
 <option value="02">02
 <option value="03">03
 <option value="04">04
 <option value="05">05
 <option value="06">06
 <option value="07">07
 <option value="08">08
 <option value="09">09
 <option value="10">10
 <option value="11">11
 <option value="12">12
</select>
<select name="EPS_EXPIRYYEAR">
 <option value="2014">2014
 <option value="2015">2015
 <option value="2016">2016
 <option value="2017">2017
 <option value="2018">2018
</select>

        Carc CCV<input type="text" name="EPS_CCV" value="999">
        <input type="submit" value="submit" >

    </form> 