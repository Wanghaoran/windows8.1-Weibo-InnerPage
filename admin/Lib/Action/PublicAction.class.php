<?php
class PublicAction extends Action {
  public function login(){
    $this -> display();
  }

  public function checkLogin(){
    if(empty($_POST['account'])){
      $this -> error(L('LOGIN_NAME_EMPTY'));
    }else if(empty($_POST['password'])){
      $this -> error(L('LOGIN_PWD_EMPTY'));
    }else if(empty($_POST['verify'])){
      $this -> error(L('LOGIN_VERIFY_EMPTY'));
    }
    if($this -> _session('verify') != $this -> _post('verify', 'md5')){
      $this -> error(L('VERIFY_ERROR'));
    }
    $admin = M('Admin');
    $where = array();
    $where['name'] = $this -> _post('account');
    $result = $admin -> field('id,name,password,last_login_time,last_login_ip,logincount') -> where($where) -> find();
    if(!$result){
      $this -> error(L('NAME_ERROR'));
    }
    if($result['password'] != $this -> _post('password', 'md5')){
      $this -> error(L('PASSWORD_ERROR'));
    }
    session(C('USER_AUTH_KEY'), $result['id']);
    session('last_login_time', $result['last_login_time']);
    session('last_login_ip', $result['last_login_ip']);
    session('logincount', $result['logincount']);
    session('name', $result['name']);
    $data = array();
    $data['last_login_time'] = time();
    $data['last_login_ip'] = get_client_ip();
    $data['logincount'] = $result['logincount']+1;
    $data['id'] = session(C('USER_AUTH_KEY'));
    M('AdminLoginLog') -> add(array('aid' => $result['id'], 'login_time' => $data['last_login_time'], 'login_ip' => $data['last_login_ip']));
    if(!$admin -> save($data)){
      $this -> error(L('LOGIN_ERROR'));
    }
    $this -> success(L('LOGIN_SUCCESS'), U('Index/index'));
  }

  public function main(){
   $info = array(
     '操作系统'=>PHP_OS,
     '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
     'PHP运行方式'=>php_sapi_name(),
     'ThinkPHP版本'=>THINK_VERSION.' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
     '上传附件限制'=>ini_get('upload_max_filesize'),
     '执行时间限制'=>ini_get('max_execution_time').'秒',
     '服务器时间'=>date("Y年n月j日 H:i:s"),
     '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
     '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
     '剩余空间'=>round((@disk_free_space(".")/(1024*1024)),2).'M',
     'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
     'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
     'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
   );
   $this->assign('info', $info);
   $this->display();  
  }

  public function password(){
    $this -> display(); 
  }

  public function changepwd(){
    if(empty($_POST['oldpassword'])){
      $this -> error(L('OLDPASSWORD_EMPTY'));
    }else if(empty($_POST['password'])){
      $this -> error(L('NEWPASSWORD_EMPTY'));
    }else if(empty($_POST['repassword'])){
      $this -> error(L('REPASSWORD_EMPTY'));
    }else if($_POST['password'] != $_POST['repassword']){
      $this -> error(L('PASSWORD_NEQ'));
    }else if(md5($_POST['verify']) != $_SESSION['verify']){
      $this -> error(L('VERIFY_ERROR'));
    }
    $cond = array();
    $cond['password'] = $this -> _post('oldpassword', 'md5');
    $cond['id'] = session(C('USER_AUTH_KEY'));
    $admin = M('Admin');
    if(!$admin -> field('id') -> where($cond) -> find()){
      $this -> error(L('OLDPASSWORD_ERROR'));
    }
    $cond['password'] = $this -> _post('password', 'md5');
    if($admin -> save($cond)){
      $this -> success(L('CHANGE_PWD_SUCCESS'));
    }else{
      $this -> error(L('CHANGE_PWD_ERROR'));
    }
  }

  public function logout(){
    session(C('USER_AUTH_KEY'), null);
    session(null);
    session('[destroy]');
    $this -> success(L('LOGOUT_SUCCESS'), U(C('USER_AUTH_GATEWAY')));
  }

  public function verify(){
    import('ORG.Util.Image');
    Image::buildImageVerify();
  }

  public function add($modelName){
    $model = D($modelName);
    if(!$model -> create()){
      $this -> error($model -> getError());
    }
    if($model -> add()){
      $this -> success(L('DATA_ADD_SUCCESS'));
    }else{
      $this -> error(L('DATA_ADD_ERROR'));
    }
  }

  public function del($modelName){
    $where_del = array();
    $where_del['id'] = array('in', $_POST['ids']);
    $model = D($modelName);
    if($model -> where($where_del) -> delete()){
      $this -> success(L('DATA_DELETE_SUCCESS'));
    }else{
      $this -> error(L('DATA_DELETE_ERROR'));
    }
  }

  public function edit($modelName, $field='', $id=''){
    $model = D($modelName);
    $result = $model -> field($field) -> find($id);
    $this -> assign('result', $result);
  }

  public function checkedit($modelName){
    $model = D($modelName);
    if(!$model -> create()){
      $this -> error($model -> getError());
    }
    if($model -> save()){
      $this -> success(L('DATA_UPDATE_SUCCESS'));
    }else{
      $this -> error(L('DATA_UPDATE_ERROR'));
    }
  }

  public function select($modelName, $field = '', $where = array(), $order = '', $join = '', $alias = ''){
    $model = M($modelName);
    import('ORG.Util.Page');
    $count = $model -> where($where)-> count();
    if(! empty ( $_REQUEST ['listRows'] )){
      $listRows = $_REQUEST ['listRows'];
    } else {
      $listRows = 15;
    }
    $page = new Page($count, $listRows);
    $pageNum = !empty($_REQUEST['pageNum']) ? $_REQUEST['pageNum'] : 1;
    $page -> firstRow = ($pageNum - 1) * $listRows;
    $result = $model -> alias($alias) -> field($field) -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows) -> join($join) -> order($order) -> select();
    $this -> assign('result', $result);
    $this -> assign('listRows', $listRows);
    $this -> assign('currentPage', $pageNum);
    $this -> assign('count', $count);
    return array('count' => $count, 'result' => $result);
  }

  public function viewweibo(){
    $app_key = C('WB_AKEY');
    $uid = $this -> _get('uid');
    $id = $this -> _get('id');
    redirect('http://api.weibo.com/2/statuses/go?source=' . $app_key . '&uid=' . $uid . '&id=' . $id);

  }
}
