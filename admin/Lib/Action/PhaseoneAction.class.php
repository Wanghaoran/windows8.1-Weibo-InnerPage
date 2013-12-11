<?php
class PhaseoneAction extends CommonAction{


    public function topic(){
        $where = array();
        R('Public/select', array('WeiboShareList', 'weiboId,uid,content,created_at,user_screen_name,ischeck,reposts_count,isshow', $where, 'created_at DESC'));
        $this -> display();
    }

    public function getshare(){
        $WeiboShareList = M('WeiboShareList');
        $numTotal = 0;
        $update = 0;

        $q = urlencode('八Windows多一点');

        for($i = 1; $i <= 4; $i++){
            $get = file_get_contents('http://api.weibo.com/2/search/topics.json?source=3922776172&count=50&page=' . $i . '&q=' . $q . '');
            $data_arr = json_decode($get, true);
            if($data_arr['total_number'] != 0){
                foreach($data_arr['statuses'] as $value){
                    $data = array();
                    $data['weiboId'] = $value['idstr'];
                    $data['content'] = $value['text'];
                    $data['thumbnail_pic'] = $value['thumbnail_pic'];
                    $data['original_pic'] = $value['original_pic'];
                    $data['created_at'] = strtotime($value['created_at']);
                    $data['user_profile_image_url'] = $value['user']['profile_image_url'];
                    $data['user_screen_name'] = $value['user']['screen_name'];
                    $data['user_description'] = $value['user']['description'];
                    $data['reposts_count'] = $value['reposts_count'];
                    $data['uid'] = $value['user']['idstr'];
                    $data['mid'] = $value['mid'];
                    if($WeiboShareList -> add($data)){
                        $numTotal ++;
                    }else{
                        $update_data = array();
                        $update_data['weiboId'] = $value['idstr'];
                        $update_data['reposts_count'] = $value['reposts_count'];
                        $update += $WeiboShareList -> save($update_data);
                    }
                    usleep(1000);
                }
            }else{
                break;
            }
            usleep(10000);
        }
        if($numTotal || $update){
            $this -> success('采集成功,共采集到 ' . $numTotal . ' 条数据,更新' . $update . '条数据');
        }else{
            $this -> error('采集失败，没有新数据');
        }
    }

    public function delshare(){
        $where_del = array();
        $where_del['weiboId'] = array('in', $_POST['ids']);
        $WeiboShareList = M('WeiboShareList');
        if($WeiboShareList -> where($where_del) -> delete()){
            $this -> success(L('DATA_DELETE_SUCCESS'));
        }else{
            $this -> error(L('DATA_DELETE_ERROR'));
        }

    }

    public function checkshow(){
        $WeiboShareList = M('WeiboShareList');
        $update = array();
        $update['weiboId'] = $_GET['id'];
        $update['isshow'] = $_GET['type'];
        if($WeiboShareList -> save($update)){
            $this -> success(L('DATA_UPDATE_SUCCESS'));
        }else{
            $this -> error(L('DATA_UPDATE_ERROR'));
        }
    }

} 