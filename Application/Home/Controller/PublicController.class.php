<?php

namespace Home\Controller;
use Think\Controller;

class PublicController extends Controller{

    /**
     * 登陆
     */
    public function login(){
        if(IS_POST){
            $username = I('username');
            $password = I('password');
            $remenber = I('remenber');

            if(!$username){
                $this->error('请输入姓名！');
            }
            if(!$password){
                $this->error('请输入身份证！');
            }
            $user_object = D('Student');
            $uid = $user_object->login($username, $password);
            if(0 < $uid){
                $this->success('登录成功！', Cookie('__forward__') ? : C('HOME_PAGE'));
            }else{
                $this->error($user_object->getError());
            }
        }else{
            if(is_login()){
                $this->error("您已登陆系统", Cookie('__forward__') ? : C('HOME_PAGE'));
            }
            $this->display();
        }
    }   
    
}
