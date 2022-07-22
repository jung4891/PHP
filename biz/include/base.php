<?php
	$misc = base_url().'misc/';
	$img = $misc.'img/';
	$id = $this->phpsession->get( 'id', 'stc' );
	$name = $this->phpsession->get( 'name', 'stc' );
	$lv = $this->phpsession->get( 'lv', 'stc' );
	$parent_group = $this->phpsession->get( 'pGroupName', 'stc' );
    $group = $this->phpsession->get( 'group', 'stc' );
	$biz_lv = $this->phpsession->get( 'biz_lv', 'stc' );
	$sales_lv = $this->phpsession->get( 'sales_lv', 'stc' );
	$tech_lv = $this->phpsession->get( 'tech_lv', 'stc' );
	$admin_lv = $this->phpsession->get( 'admin_lv', 'stc' );
	$email = $this->phpsession->get( 'email', 'stc' ); //김수성 수정-161228//이메일발송용
?>
