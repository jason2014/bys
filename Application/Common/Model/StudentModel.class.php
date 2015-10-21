<?php
namespace Common\Model;
use Think\Model;

class StudentModel extends Model{
    /**
     * 登陆
     * @author jason <jijianqiao2011@qq.com>
     */
    public function login($username, $password, $map=array()){
        //去除前后空格
        $username = trim($username);

        $map['name'] = array('eq', $password); //用户名登陆
        $map['idcardtype'] = array('eq', $username);

        $user = $this->where($map)->find(); //查找用户

        if(!$user){
            $this->error = '用户不存在或被禁用！';
        }else{
            if($password !== $user['name']){
                $this->error = '密码错误！';
            }else{
                //更新登录信息
                // $data = array(
                //     'id'              => $user['id'],
                //     'login'           => array('exp', '`login`+1'),
                //     'last_login_time' => NOW_TIME,
                //     'last_login_ip'   => get_client_ip(1),
                // );
                $data = array('id'=>$user['id'], 'update_time'=> date('Y-m-d H:i:s'));
                $this->save($data);
                $this->autoLogin($user);
                return $user['id'];
            }
        }
        return false;
    }

    /**
     * 设置登录状态
     * @author jason <jijianqiao2011@qq.com>
     */
    public function autoLogin($user){
        //记录登录SESSION和COOKIES
        $auth = array(
            'uid' => $user['id']
        );
        session('user_auth', $auth);
    }

    /**
     * 检测用户是否登录
     * @return integer 0-未登录，大于0-当前登录用户ID
     * @author jason <jijianqiao2011@qq.com>
     */
    public function isLogin(){
        $user = session('user_auth'); //用户登录信息
        if (empty($user)) {
            return 0;
        }else{
            return $user['uid'];
        }
    }

}