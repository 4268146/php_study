<?php
/**
 * 公共配置文件
 */
return array(
  //加载其他配置文件
  'LOAD_EXT_CONFIG' => 'db',

  // 设置禁止访问的模块列表
  'MODULE_DENY_LIST'      =>  array('Common','Runtime'),

  // 设置可访问目录
  'MODULE_ALLOW_LIST'    =>    array('Admin','StudentA','StudentB','StudentC'),

  //默认访问目录
  'DEFAULT_MODULE'       =>    'Admin',

  // 默认控制器名称
  //'DEFAULT_CONTROLLER'    =>  'Public', 

  // 默认操作名称
  //'DEFAULT_ACTION'        =>  'Login', 

  // 显示页面Trace信息
  //'SHOW_PAGE_TRACE' =>true,


  /* 模板相关配置 */
  'TMPL_PARSE_STRING' => array(

    '__STYLESHEET__'   => __ROOT__.'/Public/Common/stylesheets',    //stylesheets文件
    '__JAVASCRIPT__'   => __ROOT__.'/Public/Common/javascripts',    //javascripts文件
    '__DATETIMEPICKER__' => __ROOT__.'/Public/Common/datetimepicker', //时间的插件
    '__BOOTSTRAP__'   => __ROOT__.'/Public/Common/bootstrap',       //bootstrap文件
    '__JQUERY__'   => __ROOT__.'/Public/Common/jquery',       //jquery文件
    '__PLUGIN__'   => __ROOT__.'/Public/plugin_folder',       //plugin_folder文件

  ),

  'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
  // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
//'URL_HTML_SUFFIX'=>'shtml',);
);
