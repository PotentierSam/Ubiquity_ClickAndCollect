<?php
return array(
	"siteUrl"=>"http://127.0.0.1:8090/",
	"database"=>[
			"type"=>"mysql",
			"dbName"=>"clickandcollect",
			"serverName"=>"127.0.0.1",
			"port"=>3306,
			"user"=>"root",
			"password"=>"",
			"options"=>[],
			"cache"=>false
			],
	"sessionName"=>"s62a0ec470f91e",
	"namespaces"=>[],
	"templateEngine"=>"Ubiquity\\views\\engine\\Twig",
	"templateEngineOptions"=>[
			"cache"=>false
			],
	"test"=>false,
	"debug"=>true,
	"logger"=>function (){return new \Ubiquity\log\libraries\UMonolog("clickandcollect",\Monolog\Logger::INFO);},
	"di"=>[
			"@exec"=>[
					"jquery"=>function ($controller){
						return \Ajax\php\ubiquity\JsUtils::diSemantic($controller);
					}
					]
			],
	"cache"=>[
			"directory"=>"cache/",
			"system"=>"Ubiquity\\cache\\system\\ArrayCache",
			"params"=>[]
			],
	"mvcNS"=>[
			"models"=>"models",
			"controllers"=>"controllers",
			"rest"=>"",
			"domains"=>"testController"
			]
	);