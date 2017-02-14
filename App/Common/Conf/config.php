<?php


switch ( 'local' ) {
	
	case  "local" :
		return array(
			//'配置项'=>'配置值'
			 /* 数据库设置 */
		    'DB_TYPE'               =>  'mysql',     // 数据库类型
		    'DB_HOST'               =>  'localhost', // 服务器地址
		    'DB_NAME'               =>  'tushu',          // 数据库名
		    'DB_USER'               =>  'root',      // 用户名
		    'DB_PWD'                =>  '1qaz4rfv',          // 密码
		    'DB_PORT'               =>  '3306',        // 端口
		    'DB_PREFIX'             =>  '',    // 数据库表前缀
		
			
			'TMPL_CACHE_ON'         =>  false,    // 是否开启模板编译缓存,设为false则每次都会重新编译
			
		    /*模板配置*/
		    'TMPL_L_DELIM' => '{{',
			'TMPL_R_DELIM' => '}}',
			'DEFAULT_THEME' => '', //模板主题
			
			/* URL配置 */
			'URL_CASE_INSENSITIVE' => true, // 默认false 表示URL区分大小写 true则表示不区分大小写
			'URL_MODEL' => 2, // URL模式
		
			/* 地址后缀 */
		    'URL_HTML_SUFFIX'=>'html',
			
		    "LOAD_EXT_FILE"=>"define",

			//定义__Home__模板常量
			'TMPL_PARSE_STRING' =>[
				'__HOME__' => '/App/Home',
				'__PIC__'=>'/Pic'
			]

		);
		break;
		
		
		
	case  "test" :
		return array(
			//'配置项'=>'配置值'
			 /* 数据库设置 */
		    'DB_TYPE'               =>  'mysql',     // 数据库类型
		    'DB_HOST'               =>  'localhost', // 服务器地址
		    'DB_NAME'               =>  'test',          // 数据库名
		    'DB_USER'               =>  'root',      // 用户名
		    'DB_PWD'                =>  '123456',          // 密码
		    'DB_PORT'               =>  '3306',        // 端口
		    'DB_PREFIX'             =>  '',    // 数据库表前缀
		
			
			'TMPL_CACHE_ON'         =>  false,    // 是否开启模板编译缓存,设为false则每次都会重新编译
			
		    /*模板配置*/
		    'TMPL_L_DELIM' => '<{',
			'TMPL_R_DELIM' => '}>',
			'DEFAULT_THEME' => '', //模板主题
		
			/* 地址后缀 */
		    'URL_HTML_SUFFIX'=>'html',
			
			'TMPL_PARSE_STRING' =>array('__HOME__' => '/Application/Home') //定义__Home__模板常量
		);
		break;
}