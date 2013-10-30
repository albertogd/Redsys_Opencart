<form action="<?php echo $action; ?>" method="post" id="payment">
	<input type="hidden" name="Ds_Merchant_MerchantCode" value="<?php echo $merchantCode; ?>">
	<input type="hidden" name="Ds_Merchant_Terminal" value="<?php echo $terminal; ?>">
	<input type="hidden" name="Ds_Merchant_Amount" value="<?php echo $amount; ?>">
	<input type="hidden" name="Ds_Merchant_Currency" value="<?php echo $currency; ?>">
	<input type="hidden" name="Ds_Merchant_Order"  value="<?php echo $order; ?>">
	<input type="hidden" name="Ds_Merchant_ConsumerLanguage" value="<?php echo $language; ?>">
	<input type="hidden" name="Ds_Merchant_TransactionType" value="<?php echo $transaction_type; ?>">
	<input type="hidden" name="Ds_Merchant_MerchantURL" value="<?php echo $merchant_url; ?>">
	<input type="hidden" name="Ds_Merchant_UrlOK" value="<?php echo $url_ok; ?>">
	<input type="hidden" name="Ds_Merchant_UrlKO" value="<?php echo $url_ko; ?>">
	<input type="hidden" name="Ds_Merchant_MerchantSignature" value="<?php echo $signature; ?>">
	
</form>
<div class="buttons">
	<div class="right"><a id="button-confirm" class="button" onclick="$('#payment').submit();"><span><?php echo $button_confirm; ?></span></a></div>
</div>