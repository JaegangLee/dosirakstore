<?php
class dosirakstoreView extends Dosirakstore
{
	public function init()
	{
		// ���� �� ����
		$oModuleModel = getModel('module');
		$config = $oModuleModel->getModulePartConfig('dosirakstore', $this->module_info->module_srl);		
		Context::set('config', $config);
		
		// ���ø� ��θ� ��Ų ��η� ����
		$templatePath = sprintf('%sskins/%s/', $this->module_path, $this->module_info->skin);
		$this->setTemplatePath($templatePath);
		
		// ���ø� ���ϸ��� ����
		$templateFile = str_replace('dispDosirakstore', '', $this->act);
		$this->setTemplateFile($templateFile);
	}
	
		/*
			
		*/
	public function dispDosirakstoreContentMenu()
	{
		$no = Context::get('no');
		// ������ ��� ����
		
		// document_srl�� ������ �� ����
		if ($no)
		{
			return $this->viewDocument();
		}
		
		// ������ ��� ����
		else
		{
			return $this->viewList();
		}
	}
	public function dispDosirakstoreWrite()	
	{
		
		// ���� üũ
		if (!$this->grant->write_menu)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		
		$no = Context::get('no');
		$args->no = $no;
		$oDosirakstoreModel = getModel('dosirakstore');
		$output = $oDosirakstoreModel->getDosirakstoreOne($args);
		// �����ϸ� ������� ������ �����ۼ�
		$isModify = 0;
		if (isset($output->data))
		{
			$isModify = 1;
		}
		if ($this->grant->manager)
		{
			//$oDocument->setGrant();
		}
		Context::set('oDosirakstore', $output->data);

		$this->setTemplateFile('Write');

		
	}

	private function viewDocument()
	{
		$no = Context::get('no'); 
		$oDosirakstoreModel = getModel('dosirakstore');
		
		// ���� üũ
		if (!$this->grant->view)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		// document ���

		$args->no = $no;
		$output = $oDosirakstoreModel->getDosirakstoreOne($args);
		
		// �����ϴ��� Ȯ��
		if(!$output->toBool()) 
		{
			return new Object(-1, 'msg_not_founded');
		}
		
		// ��� �������̸� ���� ����
		if ($this->grant->manager)
		{
			//$oDocument->setGrant();
		}

		// ������ ���� �� ���� �߰�
		Context::addBrowserTitle($output->data->title);
		
		// ���ø� ���� ����
		Context::set('oDosirakstore', $output->data);
		
		// �� ����, ��� ���� ��� act�� �����ϱ� ������ ���ø� ������ ���� ����
		$this->setTemplateFile('View');
	}
	
	private function viewList()
	{
		$page = Context::get('page');
		$local = Context::get('local'); 

		$oDosirakstoreModel = getModel('dosirakstore');
		
		// ���� üũ
		if (!$this->grant->list)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		
		// ��� ���� �Ķ���� ����
		if(isset($local)){
			//����üũ
		   if(preg_match("/[0-9]/",$local)) {
				return new Object(-1, 'msg_invalid_password');
		   }
		}
		
		$args->local = $local;
		$args->page = $page;
		$args->list_count = 10; 
		$args->page_count = 10;
		
		// ��� ��������
		$output = $oDosirakstoreModel->getDosirakstoreCityList($args);
		
		//virtual number setting
		$data = $output->data;
		unset($output->data);
		$keys = array_keys($data);
		$virtual_number = ($output->total_count)-($args->list_count*($output->page-1));
		foreach($data as $key => $attribute)
		{
			$output->data[$virtual_number] = $attribute;
			$virtual_number--;
		}
		
		// ���ø� ���� ����
		Context::set('store_list', $output->data);
		Context::set('total_count', $output->total_count);
		Context::set('total_page', $output->total_page);
		Context::set('page', $output->page);
		Context::set('page_navigation', $output->page_navigation);
		
		// �� ����, ��� ���� ��� act�� �����ϱ� ������ ���ø� ������ ���� ����
		$this->setTemplateFile('List');
	}
	public function dispDosirakstoreDelete()	
	{
		// ���� üũ
		if (!$this->grant->write_menu)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		//no �� ��ü ���� get �ؿ���
		$no = Context::get('no');
		
		$args = new stdClass();
		$args->no = $no;
		$oDosirakstoreModel = getModel('dosirakstore');
		$output = $oDosirakstoreModel->getDosirakstoreOne($args);
		if(!$output->toBool()) {
			return new Object(-1, 'msg_not_founded');
		}
		$args = new stdClass();
		foreach($output->data as $no => $store)
		{
			$args->store = $store;
		}
		
		//�Ѱ��� ���� ����
		Context::set('store', $store);
		//���ø� ���� ����
		$this->setTemplateFile('Delete');

	}
}