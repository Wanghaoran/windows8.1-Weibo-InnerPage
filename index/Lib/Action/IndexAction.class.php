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
        $result = $WeiboShareList -> field('content,reposts_count,user_screen_name,user_profile_image_url,user_description,mid,uid') -> where('isshow=1') -> limit(30) -> order('created_at DESC') -> select();
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
}