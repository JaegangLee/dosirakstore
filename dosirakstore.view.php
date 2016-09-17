<?php
class dosirakstoreView extends Dosirakstore
{
	public function init()
	{
		// 설정 값 세팅
		$oModuleModel = getModel('module');
		$config = $oModuleModel->getModulePartConfig('dosirakstore', $this->module_info->module_srl);		
		Context::set('config', $config);
		
		// 템플릿 경로를 스킨 경로로 세팅
		$templatePath = sprintf('%sskins/%s/', $this->module_path, $this->module_info->skin);
		$this->setTemplatePath($templatePath);
		
		// 템플릿 파일명을 세팅
		$templateFile = str_replace('dispDosirakstore', '', $this->act);
		$this->setTemplateFile($templateFile);
	}
	
		/*
			
		*/
	public function dispDosirakstoreContentMenu()
	{
		$no = Context::get('no');
		// 없으면 목록 보기
		
		// document_srl이 있으면 글 보기
		if ($no)
		{
			return $this->viewDocument();
		}
		
		// 없으면 목록 보기
		else
		{
			return $this->viewList();
		}
	}
	public function dispDosirakstoreWrite()	
	{
		
		// 권한 체크
		if (!$this->grant->write_menu)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		
		$no = Context::get('no');
		$args->no = $no;
		$oDosirakstoreModel = getModel('dosirakstore');
		$output = $oDosirakstoreModel->getDosirakstoreOne($args);
		// 존재하면 수정모드 없으면 새로작성
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
		
		// 권한 체크
		if (!$this->grant->view)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		// document 얻기

		$args->no = $no;
		$output = $oDosirakstoreModel->getDosirakstoreOne($args);
		
		// 존재하는지 확인
		if(!$output->toBool()) 
		{
			return new Object(-1, 'msg_not_founded');
		}
		
		// 모듈 관리자이면 권한 세팅
		if ($this->grant->manager)
		{
			//$oDocument->setGrant();
		}

		// 브라우저 제목에 글 제목 추가
		Context::addBrowserTitle($output->data->title);
		
		// 템플릿 변수 세팅
		Context::set('oDosirakstore', $output->data);
		
		// 글 보기, 목록 보기 모두 act가 동일하기 때문에 템플릿 파일을 직접 지정
		$this->setTemplateFile('View');
	}
	
	private function viewList()
	{
		$page = Context::get('page');
		$local = Context::get('local'); 

		$oDosirakstoreModel = getModel('dosirakstore');
		
		// 권한 체크
		if (!$this->grant->list)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		
		// 목록 얻을 파라미터 세팅
		if(isset($local)){
			//숫자체크
		   if(preg_match("/[0-9]/",$local)) {
				return new Object(-1, 'msg_invalid_password');
		   }
		}
		
		$args->local = $local;
		$args->page = $page;
		$args->list_count = 10; 
		$args->page_count = 10;
		
		// 목록 가져오기
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
		
		// 템플릿 변수 세팅
		Context::set('store_list', $output->data);
		Context::set('total_count', $output->total_count);
		Context::set('total_page', $output->total_page);
		Context::set('page', $output->page);
		Context::set('page_navigation', $output->page_navigation);
		
		// 글 보기, 목록 보기 모두 act가 동일하기 때문에 템플릿 파일을 직접 지정
		$this->setTemplateFile('List');
	}
	public function dispDosirakstoreDelete()	
	{
		// 권한 체크
		if (!$this->grant->write_menu)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		//no 로 업체 정보 get 해오기
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
		
		//넘겨줄 인자 설정
		Context::set('store', $store);
		//템플릿 파일 지정
		$this->setTemplateFile('Delete');

	}
}