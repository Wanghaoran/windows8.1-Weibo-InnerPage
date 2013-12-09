<?php
class IndexAction extends Action {
    public function index(){
//        $id = !empty($_GET['tid']) ? $this -> _get('tid', 'intval') : 1;
        $id = 3;
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
        $this -> display();
    }

    public function part3(){
        $id = !empty($_GET['tid']) ? $this -> _get('tid', 'intval') : 1;
        $result = R('Topic/topic',array($id),'Widget');
        $this -> assign('result', $result);
        $list = R('Topic/topic',array($id, true),'Widget');
        $this -> assign('list', $list);
        $this -> display();
    }
}