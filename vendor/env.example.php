<?php
  $variables = [
      'TABLE_NAME'=> 'orders',
      'TABLE_NAME_LOG'=>'http_log',
      'IS_DEV' => false,
      'DEV_LOG' => false,
      'DEV_CURL_PROXY' => false,
      'MOCK_SERVER' => false,
      'ENABLE_CLICK_API' => true,
      'FORCE_REMOTE_CLICK_SERVER'=>false,
      'clickApiToken' => 'eyJpdiI6IlFQZWNPbVwvUVZPNjB4NmI3byt6YkZnPT0iLCJ2YWx1ZSI6InQ1U3dtZktMVGlqRWpQQ0o2VEtcLzBCcmVaK241WDlWR1g1dWVXMVRBS0I2aHFtWTFKVlNSekVxTGRxbkFUeEJZemw3eWswYWZrKzJFS0thb2Yrckhxb2xIVzNqUlBIV0FTMG1ReGFOK3pmWT0iLCJtYWMiOiIwZGZjYmNhMDU2ZTJlMWYxMTY2MDIxN2RiMzQyYjVmMjhlMmQyMmViOGE0MmVlOTI0ZDlhYzlkNjgzOWRhNmI0In0=',
      'clickApiEndPoint' => 'https://test.lasasoft.com',
      'FUNNEL_ID' => '22222',
      'PREPAID_TEST' => false,
      'IS_LOCAL' => false,
      // 'LOG_DIR_ENV' => BASE_DIR . DS . 'assets' . DS . 'storage',
  ];
  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
?>
