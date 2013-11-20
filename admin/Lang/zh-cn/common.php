<?php
$common_lang = include './Public/lang.public.php';

$app_lang = array(
  'LOGIN_NAME_EMPTY' => '帐号不能为空,请重新输入',
  'NAME_ERROR' => '帐号不存在或已禁用,请重新输入',
  'LOGIN_PWD_EMPTY' => '密码不能为空,请重新输入',
  'PASSWORD_ERROR' => '登录密码错误,请重新输入',
  'LOGIN_VERIFY_EMPTY' => '验证码不能为空',
  'VERIFY_ERROR' => '验证码错误',
  'LOGIN_SUCCESS' => '登录成功,欢迎光临',
  'LOGIN_ERROR' => '登录失败,用户表更新失败',
  'OLDPASSWORD_EMPTY' => '旧密码不能为空',
  'NEWPASSWORD_EMPTY' => '新密码不能为空',
  'REPASSWORD_EMPTY' => '重复新密码不能为空',
  'PASSWORD_NEQ' => '两次输入的密码不一致',
  'OLDPASSWORD_ERROR' => '原密码输入错误',
  'CHANGE_PWD_SUCCESS' => '更改密码成功',
  'CHANGE_PWD_ERROR' => '更改密码失败',
  'LOGOUT_SUCCESS' => '退出成功',
);

return array_merge($common_lang, $app_lang);
