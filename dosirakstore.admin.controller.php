<?php
class dosirakstoreAdminController extends Dosirakstore
{
	public function procDosirakstoreAdminUpdateSimpleSetup()
	{
		$moduleSrl = Context::get('module_srl');
		
		$oModuleModel = getModel('module');
		$moduleInfo = $oModuleModel->getModuleInfoByModuleSrl($moduleSrl);
		
		if (!$moduleInfo || $moduleInfo->module != 'dosirakstore')
		{
			return new Object(-1, 'invalid_request');
		}
		
		$args = new stdClass();
		$args->title = Context::get('title');
		
		$oModuleController = getController('module');
		$oModuleController->insertModulePartConfig('dosirakstore', $moduleSrl, $args);
	}
}
