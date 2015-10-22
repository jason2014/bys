<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台默认控制器
 * @author jry <598821125@qq.com>
 */
class IndexController extends AdminController{
    /**
     * 默认方法
     * @author jry <598821125@qq.com>
     */
    public function index(){
        $dataEnd = array();
        $data = array();

        $db = D('Student');

        $endtimeList = $db->field('LEFT(endtime,4) AS name, COUNT(`id`) AS total')->group('LEFT(endtime,4)')->select();

        $dataList = $db->field('LEFT(endtime,4) AS name,COUNT(`id`) AS total')->where('class_name !=""')->group('LEFT(endtime,4)')->select();

        foreach ($dataList as $v) {
            $dataEnd[$v['name']] = $v['total'];
        }
        
        foreach($endtimeList as $v){
            $data['labels'] .= '"'.$v['name'].'年",';
            $data['datasetsStart'] .= $v['total'].',';
            $data['datasetsEnd'] .= $dataEnd[$v['name']] ? $dataEnd[$v['name']].',' : '0,';
        }
        $data['labels'] = rtrim($data['labels'], ',');

        $data['datasetsStart'] = rtrim($data['datasetsStart'], ',');
        $data['datasetsEnd'] = rtrim($data['datasetsEnd'], ',');

        $this->assign('data', $data);
        $this->assign('start_date', $endtimeList[0]['name'].'年');
        $this->assign('end_date', $endtimeList[count($endtimeList)-1]['name'].'年');
        $this->display();
    }

    /**
     * 完全删除指定文件目录
     * @author jry <598821125@qq.com>
     */
    public function rmdirr($dirname = RUNTIME_PATH){
        $file = new \Common\Util\File();
        $result = $file->del_dir($dirname);
        if($result){
            $this->success("缓存清理成功");
        }else{
            $this->error("缓存清理失败");
        }
    }
}
