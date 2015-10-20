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

            if(!$data['class_name']){
                $this->error('原所在班级不能为空!');
            }

            if(!$data['address']){
                $this->error('通信地址不能为空!');
            }

            if(!$data['phone']){
                $this->error('手机号码不能为空!');
            }

            if(11 != strlen($data['phone'])){
                $this->error('手机号码不格式不正确!');
            }

            if(!$data['email']){
                $this->error('邮箱不能为空!');
            }

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $this->error('邮箱格式不正确!');
            }

            if(!$data['qq']){
                $this->error('QQ号码不能为空!');
            }

            if(!$data['weixin']){
                $this->error('微信号不能为空!');
            }

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
