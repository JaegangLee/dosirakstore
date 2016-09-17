<?php
class dosirakstoreModel extends Dosirakstore
{
	// 메뉴 편집의 메뉴 추가에 모듈이 나올 수 있도록 추가
	public function triggerModuleListInSitemap(&$arr)
	{
		array_push($arr, 'dosirakstore');
	}
	function getDosirakstoreAllList($args) {        	
        	$output = executeQueryArray('dosirakstore.getDosirakstoreAllList', $args);			
			return($output);
	}
	function getDosirakstoreCityList($args) {        	
		$output = executeQueryArray('dosirakstore.getDosirakstoreCityList', $args);			
		return($output);
	}
	function getDosirakstoreOne($args) {        	
		$output = executeQueryArray('dosirakstore.getDosirakstoreOne', $args);			
		return($output);
	}
}