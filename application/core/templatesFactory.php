<?php


class TemplatesFactory {

	private static $templates;  

	public static function templates(){    
		if(!TemplatesFactory::$templates){       
			TemplatesFactory::$templates=new League\Plates\Engine(APP.'view/plates');
			TemplatesFactory::$templates->addData(['titulo' => 'Default Title']);    
		}
		return TemplatesFactory::$templates;
	}
}