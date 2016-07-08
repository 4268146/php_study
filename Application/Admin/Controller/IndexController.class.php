<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
  public function index(){
    $CommonUser = M("common_user");
    $common_users = $CommonUser->select();

    $this->assign("data", $common_users);
    $this->display();
    }
}
