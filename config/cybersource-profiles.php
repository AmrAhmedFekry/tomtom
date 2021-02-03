<?php

/* Cybersource Secure Acceptance W/M Profile Config*/
define('MERCHANT_ID', 'trippickup_egp');
define('PROFILE_ID',  '2797FF58-CF66-438B-98E6-50E71147C9F3');
define('ACCESS_KEY',  '4798c13a984a36658bed962294a55de6');
define('SECRET_KEY',  'bec6331d8a824cc1aaa6587227ad6bb5d2313ef0b742472aaa4470399757c00504f9dce5b3c74ab0ace8806553dd35dde87c43bdf36042ffb5168dd8cf61e065a8df4cf9ba4e494a93972d3d5ee97cafa31810479447472c8eb662650788dec8be2c272c401d4b8587d969d5537d770e40db51ac242942208fc2c1e079856fc9');

// DF TEST: 1snn5n9w, LIVE: k8vif92e
define('DF_ORG_ID', '1snn5n9w');

// PAYMENT URL
define('CYBS_BASE_URL', 'https://testsecureacceptance.cybersource.com');

define('PAYMENT_URL', CYBS_BASE_URL . '/pay');
// define('PAYMENT_URL', '/sa-sop/debug.php');

define('TOKEN_CREATE_URL', CYBS_BASE_URL . '/token/create');
define('TOKEN_UPDATE_URL', CYBS_BASE_URL . '/token/update');

// EOF Secure Acceptance W/M

 /* Cybersource Silnet Order Profile Config*/
// define('MERCHANT_ID', ''); Merchant Id is Unique in two cases
define('PROFILE_ID_S',  '');
define('ACCESS_KEY_S',  '');
define('SECRET_KEY_S',  '');

// DF TEST: 1snn5n9w, LIVE: k8vif92e
define('DF_ORG_ID_S', '1snn5n9w');

// PAYMENT URL
define('CYBS_BASE_URL_S', 'https://testsecureacceptance.cybersource.com/silent');

define('PAYMENT_URL_S', CYBS_BASE_URL_S . '/pay');
// define('PAYMENT_URL', '/sa-sop/debug.php');

define('TOKEN_CREATE_URL_S', CYBS_BASE_URL_S . '/token/create');
define('TOKEN_UPDATE_URL_S', CYBS_BASE_URL_S . '/token/update');

// EOF Silnet Order
