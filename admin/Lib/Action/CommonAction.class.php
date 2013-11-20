<?php
class CommonAction extends Action {
  public function _initialize(){
    if(!$_SESSION[C('USER_AUTH_KEY')]){
      redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
    }
  }
}
