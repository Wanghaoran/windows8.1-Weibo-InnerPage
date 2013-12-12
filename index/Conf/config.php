<?php
$common_config = include './Public/config.public.php';
$app_config = array(
    'DEFAULT_ACTION' => 'part2',
);
return array_merge($common_config, $app_config);

?>