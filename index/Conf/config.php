<?php
$common_config = include './Public/config.public.php';
$app_config = array(
    //'配置项'=>'配置值'
);
return array_merge($common_config, $app_config);

?>