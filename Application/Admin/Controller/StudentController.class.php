<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 后台默认控制器
 * @author jry <598821125@qq.com>
 */
class StudentController extends AdminController{

    public function index(){
        $p          = I('p');
        $name       = I('name');    
        $idcardtype = I('idcardtype');    
        $major      = I('major');    
        $endtime    = I('endtime');    
        //search
        $condition = array();
        $criteria = array();

        if(!empty($name)){
            $condition['name'] = array('LIKE', '%'.$name.'%');
            $criteria['name'] = $name;
        }

        if(!empty($idcardtype)){
            $condition['idcardtype'] = array('LIKE', '%'.$idcardtype.'%');
            $criteria['idcardtype'] = $idcardtype;
        }

        if(!empty($endtime)){
            $condition['endtime'] = array('LIKE', $endtime.'%');
            $criteria['endtime'] = $endtime;
        }

        if(!empty($major)){
            $condition['major'] = array('LIKE', $major);
            $criteria['major'] = $major;
        }

        $pageSize = 20;
        $currentPage = empty($p) ? 1 : $p;

        $db = M('Student');
        //符合条件的记录总数
        $total = $db->field('id')->where($condition)->count();

        $Page = new \Common\Util\Page($total, $pageSize);

        $data = $db->where($condition)->order('education DESC,id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();

        $majorList = $db->field('major AS name')->group('major')->order('major')->select();

        $endtimes = $db->field('LEFT(endtime,4) AS name')->group('LEFT(endtime,4)')->order('name DESC')->select();

        $this->assign('data', $data);
        $this->assign('total', $total);
        $this->assign('pageShow', $Page->show());
        $this->assign('criteria', $criteria);

        $this->assign('majorList', $majorList);
        $this->assign('endtimes', $endtimes);

        $this->display();
    }

    public function view($id){
        $model = M('Student')->where(array('id'=>$id))->find();

        $this->assign('model', $model);
        $this->display();
    }

}