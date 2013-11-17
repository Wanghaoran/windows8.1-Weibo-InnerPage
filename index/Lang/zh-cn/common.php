<?php
$common_lang = include './Public/lang.public.php';

$app_lang = array(
  'TEST' => '测试语言包',
);

return array_merge($common_lang, $app_lang);
