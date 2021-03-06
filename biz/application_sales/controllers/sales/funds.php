<?php
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");

class Funds extends CI_Controller {
  var $id = '';

  function __construct() {
    parent::__construct();
      $this->id = $this->phpsession->get( 'id', 'stc' );
      $this->name = $this->phpsession->get( 'name', 'stc' );
      $this->lv = $this->phpsession->get( 'lv', 'stc' );
      $this->cooperation_yn = $this->phpsession->get( 'cooperation_yn', 'stc' );

      if($this->cooperation_yn == 'Y') {
        echo "<script>alert('권한이 없습니다.');location.href='".site_url()."'</script>";
      }

      $this->load->library('user_agent');

      $this->load->Model('sales/STC_Funds');
    }

    function funds_list() {
      if(isset($_POST['search1'])) {
        $data['search1'] = $_POST['search1'];
      }else{
        $data['search1'] = date("Y");
      }


      if(isset($_POST['search2'])) {
        $data['search2'] = $_POST['search2'];
      }else{
        $data['search2'] = "IT";
      }

      $mode = "month";

      // 목표
      $sum_purpose=0;
      $data['item'] = $this->STC_Funds->funds_list($data['search1'],$data['search2']);
      foreach($data['item'][0] as $mon => $val){
        if(substr($mon,0,7)=='purpose') {
          $sum_purpose += $val;
        }
      }
      $data['sum_purpose']=$sum_purpose;

      // forcasting
      $sum_forcasting=0;
      for($i=1;$i<13;$i++){
         $forcasting = $this->STC_Funds->funds_forcasting_sum($data['search1'],$i,$data['search2']);
         // 총 금액 - 기발행 금액,
         // 기발행금액 월마다 더하기
         $forcasting_minus = $this->STC_Funds->forcasting_adjust($data['search1'], $i, $data['search2'], 'minus');
         $forcasting_plus = $this->STC_Funds->forcasting_adjust($data['search1'], $i, $data['search2'], 'plus');

         $data['forcasting_'.$i] = $forcasting[0]['sum'] - $forcasting_minus['sum'] + $forcasting_plus['sum'];
         $sum_forcasting+=$data['forcasting_'.$i];
      }
      $data['sum_forcasting']=$sum_forcasting;

      // (상품,조달,용역) 달성
      $forcasting_type = array("sale","service","support");

      $sum_sale=0;
      $sum_service=0;
      $sum_support=0;

      for($i=0;$i<count($forcasting_type);$i++){
        $type = $forcasting_type[$i];

        for($j=1;$j<13;$j++){
          $data['forcasting'][$type][$j] = $this->STC_Funds->forcasting_sum($data['search1'],$j,$data['search2'],$type);
          if ($type=="sale"){
            $sum_sale+=$data['forcasting'][$type][$j][0]['sum'];
          } else if ($type=="service"){
            $sum_service+=$data['forcasting'][$type][$j][0]['sum'];
          } else if ($type=="support"){
            $sum_support+=$data['forcasting'][$type][$j][0]['sum'];
          }
        }
      }
      $data['sum_sale']=$sum_sale;
      $data['sum_service']=$sum_service;
      $data['sum_support']=$sum_support;

      // 유지보수 Forcasting
      $sum_maintain_forcasting=0;
      for($i=1;$i<13;$i++){
         $data['maintain_forcasting'][$i] = $this->STC_Funds->maintain_forcasting_sum($data['search1'],$i,$data['search2']);
         $sum_maintain_forcasting+=$data['maintain_forcasting'][$i][0]['sum'];
      }
      $data['sum_maintain_forcasting']=$sum_maintain_forcasting;

      // 유지보수 달성
      $sum_maintain=0;
      for($i=1;$i<13;$i++){
         $data['maintain'][$i] = $this->STC_Funds->achieve_maintain_sum($data['search1'],$i,$data['search2']);
         $sum_maintain+=$data['maintain'][$i][0]['sum'];
      }
      $data['sum_maintain']=$sum_maintain;

      // 매입
      $sum_purchase_forcasting=0;
      $sum_purchase_maintain=0;
      $sum_purchase_request=0;
      for($i=1;$i<13;$i++){
         $data['purchase_forcasting'][$i] = $this->STC_Funds->purchase_sum($data['search1'],$i,$data['search2'],'forcasting');
         $data['purchase_maintain'][$i] = $this->STC_Funds->purchase_sum($data['search1'],$i,$data['search2'],'maintain');
         $sum_purchase_forcasting+=$data['purchase_forcasting'][$i][0]['sum'];
         $sum_purchase_maintain+=$data['purchase_maintain'][$i][0]['sum'];
         if ($data['search2'] == "IT" || $data['search2'] == 'D_2') {
           $data['purchase_request'][$i] = $this->STC_Funds->purchase_sum($data['search1'],$i,$data['search2'],'request');
           $sum_purchase_request+=$data['purchase_request'][$i][0]['sum'];
         } else {
           $data['purchase_request'][$i][0]['sum'] = 0;
         }
      }
      $data['sum_purchase']=$sum_purchase_forcasting + $sum_purchase_maintain + $sum_purchase_request;

      if($this->agent->is_mobile()) {
        $data['title'] = '매출현황';
        $this->load->view('sales/funds_list_mobile', $data);
      } else {
        $this->load->view('sales/funds_list',$data);
      }
    }

  function funds_input() {
    $data = Array();

    if(isset($_POST['search1'])) {
       $data['search1'] = $_POST['search1'];
    }else{
       $data['search1'] = date("Y");
    }

    if(isset($_POST['search2'])) {
       $data['search2'] = $_POST['search2'];
    }else{
       $data['search2'] = "D_1";
    }

    $data['item'] = $this->STC_Funds->funds_list($data['search1'],$data['search2']);


    $this->load->view('sales/funds_input',$data);
   }



  function funds_input_action() {
    $data = array(
      $dept_code = $_POST['search2'],
      $year = $_POST['search1'],
      $purpose_1 = (int)str_replace(',', '', $_POST['purpose_1']),
      $purpose_2 = (int)str_replace(',', '', $_POST['purpose_2']),
      $purpose_3 = (int)str_replace(',', '', $_POST['purpose_3']),
      $purpose_4 = (int)str_replace(',', '', $_POST['purpose_4']),
      $purpose_5 = (int)str_replace(',', '', $_POST['purpose_5']),
      $purpose_6 = (int)str_replace(',', '', $_POST['purpose_6']),
      $purpose_7 = (int)str_replace(',', '', $_POST['purpose_7']),
      $purpose_8 = (int)str_replace(',', '', $_POST['purpose_8']),
      $purpose_9 = (int)str_replace(',', '', $_POST['purpose_9']),
      $purpose_10 = (int)str_replace(',', '', $_POST['purpose_10']),
      $purpose_11 = (int)str_replace(',', '', $_POST['purpose_11']),
      $purpose_12 = (int)str_replace(',', '', $_POST['purpose_12'])
    );

    $cnt = $this->STC_Funds->funds_list_cnt($year,$dept_code);

    $result="";

    if($cnt[0]['cnt']=='0'){
      $result = $this->STC_Funds->funds_input($data,0);
    }else{
      $result = $this->STC_Funds->funds_input($data,1);
    }

    if($result) {
      echo "<script>alert('정상적으로 처리되었습니다.');location.href='".site_url()."/sales/funds/funds_list?mode=month'</script>";
    } else {
      echo "<script>alert('정상적으로 처리되지 못했습니다. 다시 입력해 주세요.');history.go(-1);</script>";
    }
  }

  function funds_list_detail_view($mode) {
    // $this->output->enable_profiler(TRUE);
    $data["type_0"] = array();
    $data["type_1"] = array();
    $data["type_2"] = array();
    $data["type_3"] = array();
    $data["type_4"] = array();
    if($mode == "month"){
      $year = $_GET['year'];
      $month = $_GET['month'];
      $company= $_GET['company'];
      $detail_seq = $this->STC_Funds->funds_list_detail_seq($year,$month,$company);
      // echo "<script>alert('".count($detail_seq)."')</script>";
      if(count($detail_seq)==0){
        $data['list_val'] = array();
      }
      // print_r($detail_seq);\
      $list_data = $this->STC_Funds->funds_list_detail_data($year,$month,$company);
// echo "<br><br>";
//       echo $list_data[0]['seq'];

      for ($i=0; $i<count($detail_seq); $i++) {
        $d_seq = $detail_seq[$i]['seq'];
        $data['list_val'][$i] = array();
        for ($j=0; $j<count($list_data); $j++) {
          if ($d_seq == $list_data[$j]['seq']) {
            array_push($data['list_val'][$i], $list_data[$j]);
          }
        }
      }

      for($i=0; $i<count($data['list_val']);$i++){
        $type = $data['list_val'][$i][0]['type'];
        if (count($data['list_val'][$i])>1){ // 프로젝트의 매입/매출 1건 이상
          if ($data['list_val'][$i][0]['bill_type']=="001") { // 매출이 먼저 있을 경우
            $sum_purchase = 0;
            for($j=0; $j<count($data['list_val'][$i]);$j++){
              if ($data['list_val'][$i][$j]['bill_type']=="002"){ // 매입의 합계 계산
                $sum_purchase += $data['list_val'][$i][$j]['issuance_amount'];
              }
            }
            $data['list_val'][$i][0]['sum_purchase'] = $sum_purchase; // 매입의 합계를 첫번째 매출에 추가
            foreach($data['list_val'][$i] as $lv){ // 매출 행을 변수에 입력
              if($lv['bill_type']=="001"){
                array_push($data["type_".$type],$lv);
              }
            }
          } else { // 프로젝트의 매입만 있을 경우
            $sum_sale_amount = 0;
            foreach($data['list_val'][$i] as $lv) {
              // echo count($data['list_val'][$i]).$lv['customer_companyname'];
              // echo "<br>";
              $sum_sale_amount += $lv['issuance_amount'];
            }
            // echo $sum_sale_amount.$data['list_val'][$i][0]['customer_companyname']."<br>";
            $data['list_val'][$i][0]['issuance_amount'] = $sum_sale_amount;
            array_push($data["type_".$type],$data['list_val'][$i][0]);
          }
        } else { // 프로젝트의 매입/매출이 1건일 경우
          array_push($data["type_".$type],$data['list_val'][$i][0]);
        }
      }


      // var_dump($data['type_2'][0]);
      // echo "<br><br>";
      // 여기여기 월, 분기에 각각 추가해야한다!!!!
      if($company == 'IT' || $company == 'D_2') {
        $request_data = $this->STC_Funds->request_tech_support_bill($year, $month);
        if(isset($request_data[0])) {
          array_push($data['type_2'], $request_data[0]);
        }
      }
      // var_dump($request_data[0]);

    } else if ($mode =='division'){
      $year = $_GET['year'];
      $division = $_GET['division'];
      $company= $_GET['company'];

      switch($division) {
        case 1:
          $m_array = array(1,2,3);
          break;
        case 2:
          $m_array = array(4,5,6);
          break;
        case 3:
          $m_array = array(7,8,9);
          break;
        case 4:
          $m_array = array(10,11,12);
          break;
      }
      for($k=0; $k<count($m_array); $k++){
        $month = $m_array[$k];
        // echo $k;
        $detail_seq = $this->STC_Funds->funds_list_detail_seq($year,$month,$company);
        // echo "<script>alert('".count($detail_seq)."')</script>";
        if(count($detail_seq)==0){
          $data['list_val'] = array();
        }
        // print_r($detail_seq);
        $list_data = $this->STC_Funds->funds_list_detail_data($year,$month,$company);
        for ($i=0; $i<count($detail_seq); $i++) {
          $d_seq = $detail_seq[$i]['seq'];
          $data['list_val'][$i] = array();
          for ($j=0; $j<count($list_data); $j++) {
            if ($d_seq == $list_data[$j]['seq']) {
              array_push($data['list_val'][$i], $list_data[$j]);
            }
          }
          // $data['list_val'][$i] = $this->STC_Funds->funds_list_detail_data($year,$month,$company,$d_seq);
        }


        for($i=0; $i<count($data['list_val']);$i++){
          $type = $data['list_val'][$i][0]['type'];
          if (count($data['list_val'][$i])>1){ // 프로젝트의 매입/매출 1건 이상
            if ($data['list_val'][$i][0]['bill_type']=="001") { // 매출이 먼저 있을 경우
              $sum_purchase = 0;
              for($j=0; $j<count($data['list_val'][$i]);$j++){
                if ($data['list_val'][$i][$j]['bill_type']=="002"){ // 매입의 합계 계산
                  $sum_purchase += $data['list_val'][$i][$j]['issuance_amount'];
                }
              }
              $data['list_val'][$i][0]['sum_purchase'] = $sum_purchase; // 매입의 합계를 첫번째 매출에 추가
              foreach($data['list_val'][$i] as $lv){ // 매출 행을 변수에 입력
                if($lv['bill_type']=="001"){
                  array_push($data["type_".$type],$lv);
                }
              }
            } else { // 프로젝트의 매입만 있을 경우
              $sum_sale_amount = 0;
              foreach($data['list_val'][$i] as $lv) {
                $sum_sale_amount += $lv['issuance_amount'];
              }
              $data['list_val'][$i][0]['issuance_amount'] = $sum_sale_amount;
              array_push($data["type_".$type],$data['list_val'][$i][0]);
            }
          } else { // 프로젝트의 매입/매출이 1건일 경우
            array_push($data["type_".$type],$data['list_val'][$i][0]);
          }
        }

        if($company == 'IT' || $company == 'D_2') {
          $request_data = $this->STC_Funds->request_tech_support_bill($year, $month);
          if(isset($request_data[0])) {
            array_push($data['type_2'], $request_data[0]);
          }
        }
      }

    }

    function arr_sort( $array, $key, $sort ){
      $keys = array();
      $vals = array();
      foreach( $array as $k=>$v ){
        $i = $v[$key].'.'.$k;
        $vals[$i] = $v;
        array_push($keys, $k);
      }
      unset($array);
      if( $sort=='asc' ){
        ksort($vals);
      }else{
        krsort($vals);
      }
      $ret = array_combine( $keys, $vals );
      unset($keys);
      unset($vals);
      return $ret;
    }

    for ($i=0;$i<5;$i++){
      if (count($data["type_".$i])>0){
        $data["type_".$i] = arr_sort($data['type_'.$i],'issuance_date','asc');
      }
      // var_dump($data["type_2"]);
    }

    $data['list_val'] = array_merge($data['type_1'],$data['type_2'],$data['type_4'],$data['type_3'],$data['type_0']);

    $this->load->view('sales/funds_list_detail_view',$data);
  }

  function maintain_type() {
    $seq = $this->input->post('seq');

    $result = $this->STC_Funds->maintain_type($seq)->cnt;

    echo json_encode($result);
  }

  function funds_list_excel() {
    // $this->output->enable_profiler(TRUE);
    $data["type_0"] = array();
    $data["type_1"] = array();
    $data["type_2"] = array();
    $data["type_3"] = array();
    $data["type_4"] = array();

    $year = $_POST['year'];
    $month = $_POST['month'];
    $company= $_POST['company'];
    $detail_seq = $this->STC_Funds->funds_list_detail_seq($year,$month,$company);
    // echo "<script>alert('".count($detail_seq)."')</script>";
    if(count($detail_seq)==0){
      $data['list_val'] = array();
    }
    // print_r($detail_seq);\
    $list_data = $this->STC_Funds->funds_list_detail_data($year,$month,$company);
// echo "<br><br>";
//       echo $list_data[0]['seq'];

    for ($i=0; $i<count($detail_seq); $i++) {
      $d_seq = $detail_seq[$i]['seq'];
      $data['list_val'][$i] = array();
      for ($j=0; $j<count($list_data); $j++) {
        if ($d_seq == $list_data[$j]['seq']) {
          array_push($data['list_val'][$i], $list_data[$j]);
        }
      }
    }

    for($i=0; $i<count($data['list_val']);$i++){
      $type = $data['list_val'][$i][0]['type'];
      if (count($data['list_val'][$i])>1){ // 프로젝트의 매입/매출 1건 이상
        if ($data['list_val'][$i][0]['bill_type']=="001") { // 매출이 먼저 있을 경우
          $sum_purchase = 0;
          for($j=0; $j<count($data['list_val'][$i]);$j++){
            if ($data['list_val'][$i][$j]['bill_type']=="002"){ // 매입의 합계 계산
              $sum_purchase += $data['list_val'][$i][$j]['issuance_amount'];
            }
          }
          $data['list_val'][$i][0]['sum_purchase'] = $sum_purchase; // 매입의 합계를 첫번째 매출에 추가
          foreach($data['list_val'][$i] as $lv){ // 매출 행을 변수에 입력
            if($lv['bill_type']=="001"){
              array_push($data["type_".$type],$lv);
            }
          }
        } else { // 프로젝트의 매입만 있을 경우
          $sum_sale_amount = 0;
          foreach($data['list_val'][$i] as $lv) {
            // echo count($data['list_val'][$i]).$lv['customer_companyname'];
            // echo "<br>";
            $sum_sale_amount += $lv['issuance_amount'];
          }
          // echo $sum_sale_amount.$data['list_val'][$i][0]['customer_companyname']."<br>";
          $data['list_val'][$i][0]['issuance_amount'] = $sum_sale_amount;
          array_push($data["type_".$type],$data['list_val'][$i][0]);
        }
      } else { // 프로젝트의 매입/매출이 1건일 경우
        array_push($data["type_".$type],$data['list_val'][$i][0]);
      }
    }


    // var_dump($data['type_2'][0]);
    // echo "<br><br>";
    // 여기여기 월, 분기에 각각 추가해야한다!!!!
    if($company == 'IT' || $company == 'D_2') {
      $request_data = $this->STC_Funds->request_tech_support_bill($year, $month);
      if(isset($request_data[0])) {
        array_push($data['type_2'], $request_data[0]);
      }
    }

    function arr_sort( $array, $key, $sort ){
      $keys = array();
      $vals = array();
      foreach( $array as $k=>$v ){
        $i = $v[$key].'.'.$k;
        $vals[$i] = $v;
        array_push($keys, $k);
      }
      unset($array);
      if( $sort=='asc' ){
        ksort($vals);
      }else{
        krsort($vals);
      }
      $ret = array_combine( $keys, $vals );
      unset($keys);
      unset($vals);
      return $ret;
    }

    for ($i=0;$i<5;$i++){
      if (count($data["type_".$i])>0){
        $data["type_".$i] = arr_sort($data['type_'.$i],'issuance_date','asc');
      }
      // var_dump($data["type_2"]);
    }

    $data['list_val'] = array_merge($data['type_1'],$data['type_2'],$data['type_4'],$data['type_3'],$data['type_0']);

    echo json_encode($data['list_val']);
  }

}
