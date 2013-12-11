<?php
class PhaseoneAction extends CommonAction{


    public function topic(){
        $where = array();
        R('Public/select', array('WeiboShareList', 'weiboId,uid,content,created_at,user_screen_name,ischeck,reposts_count', $where, 'created_at DESC'));
        $this -> display();
    }

    public function getshare(){
        $WeiboShareList = M('WeiboShareList');
        $numTotal = 0;
        $update = 0;

        $q = urlencode('8不够 多1点');

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
                    $data['reposts_count'] = $value['reposts_count'];
                    $data['uid'] = $value['user']['idstr'];
                    if($WeiboShareList -> add($data)){
                        $numTotal ++;
                    }else{
                        $update_data = array();
                        $update_data['weiboId'] = $value['idstr'];
                        $data['reposts_count'] = $value['reposts_count'];
                        $update += $WeiboShareList -> save($update_data);
                    }
                    usleep(1000);
                }
            }else{
                break;
            }
            usleep(10000);
        }
        if($numTotal){
            $this -> success('采集成功,共采集到 ' . $numTotal . ' 条数据,更新' . $update . '条数据');
        }else{
            $this -> error('采集失败，没有新数据,更新' . $update . '条数据');
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

} 