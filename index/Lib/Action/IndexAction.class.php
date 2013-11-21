<?php
class IndexAction extends Action {
    public function index(){
        $id = !empty($_GET['tid']) ? $this -> _get('tid', 'intval') : 1;
        $result = R('Topic/topic',array($id),'Widget');
        $this -> assign('result', $result);
        $list = R('Topic/topic',array($id, true),'Widget');
        $this -> assign('list', $list);
        $this -> display();
    }
}