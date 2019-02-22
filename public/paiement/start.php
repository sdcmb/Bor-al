<?php

use vendor\autoload;

define ('SITE_URL','http://127.0.0.1:8000/');

$paypal = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
      'AQ84_WvSBCFRH9nyPZk2bDFXJSsT5JLWr0bl_AiW9sjQ0PInqZA4e2vCodXelZNRvhsZjMHYKzwqpj1V',
      'EGhTF-hzi3chTI-naFF-H3X_LTwm-zt_yy9FICotLMgQ0sokHLcAF5f-dGjAIMGcMN1FWDL-W_1AmGj_'
      )
  )

?>
