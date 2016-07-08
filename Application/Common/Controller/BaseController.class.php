<?php
// +--------------------------------------------------------------------------
// | ZAIYOUDAO [ 载攸道 先顺得常 ] <http://www.zaiyoudao.com>
// +--------------------------------------------------------------------------
// | Copyright © 2010-2015 ISDCE. All rights reserved <http://www.isdce.com>
// +--------------------------------------------------------------------------
// | Project: YiPHP [ 我会的仅仅是偷懒！ ] <http://www.yiphp.com>
// +--------------------------------------------------------------------------
// | Author: 牛很多戒很多不戒 <n@isdce.com> <http://juexue.wang>
// +--------------------------------------------------------------------------

namespace Common\Controller;
use Think\Controller;

/**
 * 开发者公共配置控制器
 */
class BaseController extends Controller {

	//空操作默认为登陆
	public function _empty(){

		$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/index.php/Simian/Auth/Login/Login.html';
//				$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/Simian/Auth/Public/Login.html';
		redirect("$url", 0,'');

	}

	/* 开发者公共配置 */
    protected function _initialize(){

      $this->assign("current_url_addr", __APP__.'/'.CONTROLLER_NAME . "/" . ACTION_NAME);
		header('Content-type: text/html; charset=utf-8');
		$path_initialize = CONTROLLER_NAME."/".ACTION_NAME;
		$this->assign('path_initialize',$path_initialize);
			//判断是否登陆
		$m_user_group = M('user_group');
		$b_uid = $_COOKIE['b_uid'];
		$map['Id'] = $b_uid;
		$authority = $m_user_group->where($map)->field('run,status')->select();


			if($_COOKIE['b_uid'] == null){

				$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/index.php/Simian/Auth/Login/Login.html';
//				$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/Simian/Auth/Public/Login.html';
				redirect("$url", 0,'');
				die;
			}
			if($authority[0]['status'] == 0){
				$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/index.php/Simian/Auth/Login/Login.html';
				redirect("$url", 0,'');
				die;
			}
			if($authority[0]['run'] != "0"){
				$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/index.php/Simian/Auth/Login/Login.html';
				redirect("$url", 0,'');
				die;
			}

//			//权限判断
			$authority_initialize = $this->getAuthority($path_initialize);
		if($authority_initialize == 1){
			$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/index.php/MeeZao/B/User/Welcome.html';
			redirect("$url", 0,'');
			die;
		}
//		dump($authority_initialize);
			//获得菜单
			$this->getMenu();
			//获得用户信息
			$this->getUserInfo();

    }




	//用户信息
	public function getAuthority($path_initialize){

		$m_user_group = M('user_group');
		$b_uid = $_COOKIE['b_uid'];
		$map['Id'] = $b_uid;
		$map['run'] = "0";
		$data = $m_user_group->where($map)->field('authority,groupname')->select();
		$m_main_group = M('main_group');
		$map_group['url'] = $path_initialize;
		$authority = $m_main_group->where($map_group)->order('numorder')->select();
//		dump($authority);
		if($authority[0]['url'] != ""){
			if($data[0]['authority'] != 111){
				$groupname = $data[0]['groupname'];
				$map_group['groupname'] = $groupname;
				$map_group['status'] = "1";
				$menu = $m_main_group->join('LEFT JOIN zyd_child_group ON zyd_child_group.ownid = zyd_main_group.id')->where($map_group)->order('numorder')->select();
				if($menu[0]['url'] != ""){
					return 0;
				}else{
					return 1;
				}
			}else{
				return 0;
			}
		}else{
			return 0;
		}
//		dump($menu);



	}
	//用户信息
	public function getUserInfo(){

		//用户信息
		$m_user_group = M('user_group');
		$b_uid = $_COOKIE['b_uid'];
		$map['Id'] = $b_uid;
		$map['run'] = "0";
		$data = $m_user_group->where($map)->field('name')->select();
		$this->assign('user',$data);



	}

//	//生成横导航
//	public function getNav(){
//
//		$d_common_menu = D('common_menu');
//		//生成横导航
//		$nav = $d_common_menu->getNav();
//		$this->assign('nav',$nav);
//		$this->assign('top_nav',$nav);
//
//
//	}

	//生成菜单
	public function getMenu(){
		$m_user_group = M('user_group');
		$b_uid = $_COOKIE['b_uid'];
		$map['Id'] = $b_uid;
		$map['run'] = "0";
		$data = $m_user_group->where($map)->field('authority,groupname')->select();
		$m_main_group = M('main_group');
		$map_group['fatherid'] = "0";
		if($data[0]['authority'] == 111){
			$menu = $m_main_group->where($map_group)->order('numorder')->select();
		}else{
			$groupname = $data[0]['groupname'];
			$map_group['groupname'] = $groupname;
			$map_group['status'] = "1";
			$menu = $m_main_group->join('LEFT JOIN zyd_child_group ON zyd_child_group.ownid = zyd_main_group.id')->where($map_group)->order('numorder')->select();
		}
		$this->assign('menu_group',$menu);
	}

	//版权信息
	public function copyrightData(){

		//版权信息
		$copyrightMap['pid'] = C('PROJECT_ID');
		$projectMap['id'] = C('PROJECT_ID');
		$m_common_project_log = M('common_project_log');
		$m_common_project = M('common_project');
		$project_copyright = $m_common_project_log->where($copyrightMap)->order('id desc')->find();
		$project_data = $m_common_project->where($projectMap)->find();

		$this->assign('project_copyright',$project_copyright);
		$this->assign('project_data',$project_data);


	}







}
