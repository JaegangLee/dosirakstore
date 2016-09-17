<?php
class dosirakstoreController extends Dosirakstore
{
	public function procDosirakstoreWrite()
	{
		// 권한 체크
		if (!$this->grant->write_menu)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		$oDB = &DB::getInstance();
		$oDB->begin();
		$no = Context::get('no');
		if ($no)
		{
			$isModify = true;
		}
		else
		{
			$isModify = false;
		}
		$vars = Context::getRequestVars();
		$args = new stdClass();
		$args->title = strip_tags($vars->title);
		$args->link = strip_tags($vars->link);
		$args->telephone = strip_tags($vars->telephone);
		$args->address = strip_tags($vars->address);
		$args->mapx = $vars->mapx;
		$args->mapy = $vars->mapy;
		
		if($isModify)
		{
			// 글 업데이트 
			$args->no= $no;
			$output = executeQueryArray('dosirakstore.updateDosirakstoreOne', $args);
			$msg_code = 'success_updated';

		}
		else
		{
			// 글 추가
			$output = executeQueryArray('dosirakstore.insertDosirakstoreOne', $args);
			$msg_code = 'success_registed';

		}
		
		// 결과 체크
		if(!$output->toBool()) {
			$oDB->rollback();
			return $output;
		}
		$oDB->commit();

		$this->setMessage($msg_code);
		$mid = Context::get('mid');	
		$this->setRedirectUrl(getNotEncodedUrl('', 'mid', $mid, 'no', $no)); 
	}
	public function procDosirakstoreDelete()
	{
		// 권한 체크
		if (!$this->grant->write_menu)
		{
			return new Object(-1, 'msg_not_permitted');
		}
		$oDB = &DB::getInstance();
		$oDB->begin();
	
		$no = Context::get('no');
		$args = new stdClass();
		$args->no = $no;
		$oDosirakstoreModel = getModel('dosirakstore');
		$output = $oDosirakstoreModel->getDosirakstoreOne($args);
		if(!$output->toBool()) {
			return new Object(-1, 'msg_not_founded');
		}		
		$args = new stdClass();
		$args->no = $no;

		// 글 삭제
		$output = executeQueryArray('dosirakstore.deleteDosirakstoreOne', $args);
		if(!$output->toBool()) {
			$oDB->rollback();
			return $output;
		}

		// 결과 체크
		$oDB->commit();

		// alert an message
		$this->add('mid', Context::get('mid'));
		$this->setRedirectUrl(getNotEncodedUrl('', 'mid', $mid)); 
	}
	function procSearchStore()
	{ 
		$local = Context::get('local'); 
		$mid = Context::get('mid');
		$this->setRedirectUrl(getNotEncodedUrl('', 'mid', $mid, 'local', $local)); 
	}
}
