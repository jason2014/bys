<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends HomeController{

    public function index(){
        $user = session('user_auth');
        $model = M('Student')->where(array('id'=>$user['uid']))->find();

        $this->assign('model', $model);
        $this->display('Public/index');
    }

    public function edit(){
        if(IS_POST){
            $data = array(
                'id' => I('id'),
                'class_name' => trim(I('class_name')),
                'company' => trim(I('company')),
                'job' => trim(I('job')),
                'prov' => I('prov'),
                'city' => I('city'),
                'dist' => I('dist'),
                'address' => trim(I('address')),
                'phone' => trim(I('phone')),
                'email' => trim(I('email')),
                'qq' => trim(I('qq')),
                'weixin' => trim(I('weixin'))
            );
            

            $user_object = D('Student');
            if($user_object->save($data) ){
                $this->success('更新成功', U('index'));
            }else{
                $this->error('更新失败');
            }
        }else{

            $user = session('user_auth');
            $model = M('Student')->where(array('id'=>$user['uid']))->find();

            $this->assign('model', $model);
            $this->display('Public/edit');
        }
    }

    /**
     * 注销
     * @author jry <598821125@qq.com>
     */
    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
        $this->success('退出成功！', 'Public/login');
    }
}
