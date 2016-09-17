<?php
class dosirakstoreAdminModel extends Dosirakstore
{
	public function getDosirakstoreAdminSimpleSetup($moduleSrl, $setupUrl)
	{
		if (!$moduleSrl)
		{
			return;
		}
		
		$oModuleModel = getModel('module');
		$moduleInfo = $oModuleModel->getModuleInfoByModuleSrl($moduleSrl);
		if (!$moduleInfo)
		{
			return;
		}
		
		Context::set('module_info', $moduleInfo);
		
		$config = $oModuleModel->getModulePartConfig('dosirakstore', $moduleSrl);		
		Context::set('config', $config);
		
		$oTemplate = TemplateHandler::getInstance();
		$html = $oTemplate->compile($this->module_path . 'tpl/', 'simple_setup');
		
		return $html;
	}
}
