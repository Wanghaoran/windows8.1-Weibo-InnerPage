<?php
class IndexAction extends Action {
    public function index(){
//        $id = !empty($_GET['tid']) ? $this -> _get('tid', 'intval') : 1;
        $id = 4;
        $result = R('Topic/topic',array($id),'Widget');
        $this -> assign('result', $result);
        $list = R('Topic/topic',array($id, true),'Widget');
        $this -> assign('list', $list);
        $this -> display();
    }

    public function index2(){
        $id = 1;
        $result = R('Topic/topic',array($id),'Widget');
        $this -> assign('result', $result);
        $list = R('Topic/topic',array($id, true),'Widget');
        $this -> assign('list', $list);
        $this -> display();
    }

    public function part2(){
        $WeiboShareList = M('WeiboShareList');
        $result = $WeiboShareList -> field('weiboId,content,reposts_count,user_screen_name,user_profile_image_url,user_description,mid,uid,zannum') -> where('isshow=1') -> order('created_at DESC') -> select();
        $this -> assign('result', $result);
        $this -> display();
    }

    public function part3(){
        $id = !empty($_GET['tid']) ? $this -> _get('tid', 'intval') : 1;
        $result = R('Topic2/topic',array($id),'Widget');
        $this -> assign('result', $result);
        $list = R('Topic2/topic',array($id, true),'Widget');
        $this -> assign('list', $list);
        $this -> display();
    }

    public function part4(){
        $this -> display();
    }

    public function part5(){
        $id = !empty($_GET['tid']) ? $this -> _get('tid', 'intval') : 1;
        $result = R('Topic2/topic',array($id),'Widget');
        $this -> assign('result', $result);
        $list = R('Topic2/topic',array($id, true),'Widget');
        $this -> assign('list', $list);
        $this -> display();
    }

    public function part6(){
        $this -> display();
    }

    public function part7(){
        $id = !empty($_GET['tid']) ? $this -> _get('tid', 'intval') : 1;
        $result = R('Topic2/topic',array($id),'Widget');
        $this -> assign('result', $result);
        $list = R('Topic2/topic',array($id, true),'Widget');
        $this -> assign('list', $list);
        $this -> display();
    }

    public function addzannum(){
        $WeiboShareList = M('WeiboShareList');
        $WeiboShareList -> where(array('weiboId' => $this -> _get('id'))) -> setInc('zannum');
        $arr = $WeiboShareList -> field('zannum') -> where(array('weiboId' => $this -> _get('id'))) -> find();
        echo $arr['zannum'];
    }
}