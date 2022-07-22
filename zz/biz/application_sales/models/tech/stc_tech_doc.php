<?php
header("Content-type: text/html; charset=utf-8");

class STC_tech_doc extends CI_Model {

   function __construct() {

      parent::__construct();
//      $this->user_id = $this->phpsession->get( 'id', 'stc' );
      // $this->at = $this->phpsession->get( 'at', 'stc' );
      $this->name= $this->phpsession->get( 'name', 'stc' );
      $this->pGroupName= $this->phpsession->get( 'pGroupName', 'stc' );
   }


   // 고객사 정보 가저오기
   //카테고리 알아오기
   function get_customer() {
      // $sql = "select seq as forcasting_seq, customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_forcasting WHERE (sub_project_add IS NULL) or (sub_project_add IS not NULL AND sub_project_add not like CONCAT('%',seq,'%')) order by binary(customer)";
      //   $sql = "select distinct (customer_companyname) as customer from sales_forcasting order by binary(customer)";
      // $sql = "select t1.seq as maintain_seq,t1.forcasting_seq ,t1. customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_maintain AS t1,(select max(seq) as max_sort,forcasting_seq from sales_maintain WHERE NOW() between exception_saledate2 AND exception_saledate3 group by forcasting_seq) as t2 where t1.seq = t2.max_sort order by binary(customer_companyname)";
      $sql = "select seq as maintain_seq, forcasting_seq , customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_maintain WHERE CURDATE() between exception_saledate2 AND exception_saledate3 order by binary(customer_companyname)";
      $query = $this->db->query($sql);
      return $query->result_array();
   }

   function get_customer2() {
      // $sql = "select seq as forcasting_seq, customer_companyname as customer, customer_username, exception_saledate2 as maintain_start, exception_saledate3 as maintain_end , project_name from sales_forcasting WHERE (sub_project_add IS NULL) or (sub_project_add IS not NULL AND sub_project_add not like CONCAT('%',seq,'%')) order by binary(customer)";
      //   $sql = "select distinct (customer_companyname) as customer from sales_forcasting order by binary(customer)";
      $cooperation_t = '';

      if($this->cooperation_yn == 'Y') {
        $cooperation_t = 'WHERE t1.seq = 199';
      }

      $sql = "select t1.seq as forcasting_seq,t1.customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_forcasting AS t1 {$cooperation_t} order by binary(customer_companyname)";
      $query = $this->db->query($sql);
      return $query->result_array();
   }

   function get_customer3() { //수주완료에서 무상보증 기간 이내이고, 유지보수와 겹치지 않는 고객사

     $sql = "(SELECT null AS maintain_seq, sf.forcasting_seq, sf.customer,sf.customer_username, sf.maintain_start, sf.maintain_end, sf.project_name
     FROM (SELECT null AS maintain_seq, sf2.seq as forcasting_seq, sf2.customer_companyname as customer, sf2.customer_username, sf2.exception_saledate2 as maintain_start, sf2.exception_saledate3 as maintain_end , sf2.project_name from sales_forcasting sf2
     WHERE sf2.progress_step >= 015 AND warranty_end_date >= CURDATE()
     ORDER BY BINARY(customer_companyname)) sf
     left JOIN
     (SELECT sm2.seq AS maintain_seq2, sm2.forcasting_seq AS forcasting_seq2, sm2.customer_companyname AS customer2, sm2.customer_username AS customer_username2, sm2.exception_saledate2 AS maintain_start2, sm2.exception_saledate3 AS maintain_end2, sm2.project_name AS project_name2
     FROM sales_maintain sm2 WHERE CURDATE() BETWEEN sm2.exception_saledate2 AND sm2.exception_saledate3 order by binary(customer_companyname)) sm
     ON sf.forcasting_seq = sm.forcasting_seq2
     WHERE sm.maintain_seq2 IS NULL)
     UNION ALL
     (SELECT seq AS maintain_seq, forcasting_seq, customer_companyname AS customer, customer_username, exception_saledate2 AS maintain_start, exception_saledate3 AS maintain_end, project_name
     FROM sales_maintain
     WHERE CURDATE() BETWEEN exception_saledate2 AND exception_saledate3
     ORDER BY BINARY(customer_companyname))";

     $query = $this->db->query($sql);
     // echo $this->db->last_query();
     return $query->result_array();
   }

   // 기술지원보고서 문서번호 카운트 세기
   function tech_doc_num_count( $year = 0 ,$month = 0, $seq = 0 ) {
      if ($seq != 0) {

      $searchstring = " where YEAR(income_time) like ? AND MONTH(income_time) like ? AND seq BETWEEN 1 AND ? ";
      $sql = "select seq from tech_doc_basic".$searchstring;
      $query = $this->db->query( $sql, array($year, $month, $seq-1) );

      }//  수정포인트 -
      if ($seq == 0){
      $searchstring = " where YEAR(income_time) like ? AND MONTH(income_time) like ?"; //  수정포인트 -
      $sql = "select seq from tech_doc_basic".$searchstring;
      $query = $this->db->query( $sql, array($year, $month) );
      }
      return $query->num_rows();
   }

   //기술지원 보고서 파일체크
   function tech_doc_file( $seq, $filelcname){
      $sql = "select seq, file_realname, file_changename from tech_doc_basic where seq = ? and file_changename = ?";
      $query = $this->db->query( $sql, array($seq, $filelcname) );
      return $query->row_array();
   }

   // 기술지원 보고서 파일삭제
   function tech_doc_filedel($seq) {
      $sql = "update tech_doc_basic set file_changename = ?, file_realname = ? where seq = ?";
      $result = $this->db->query($sql, array(NULL,NULL,$seq));
      return $result;
   }

  function make_searchstring ($target, $searchkeyword) {
    if (strpos($searchkeyword, '+')!==false){
       $s = explode('+', $searchkeyword);
       $e = [];
       foreach($s as $a) {
          array_push($e, $target." like '%".trim($a)."%'");
       }
       $search = join(' AND ', $e);
    }else if (strpos($searchkeyword, '|')!==false){
       $s = explode('|', $searchkeyword);
       $e = [];
       foreach($s as $a) {
          array_push($e, $target." like '%".trim($a)."%'");
       }
       $search = join(' OR ', $e);
      $search = '('.$search.')';
    } else {
      $search = $target." like '%".$searchkeyword."%'";
    }

    return " AND ".$search;
  }

//기술지원보고서 리스트
function tech_doc_list( $type, $searchkeyword, $hashtag, $excellent_report_yn, $start_limit = 0, $offset = 0) {
  // var_dump($searchkeyword);
  $searchstring = '';

  if ($searchkeyword != ''){
    $searchkeyword= explode(',',$searchkeyword); // 하나로 합쳐진 문자열 분리

    if(trim($searchkeyword[0])!=''){ //고객사
      $searchstring .= $this->make_searchstring('customer', $searchkeyword[0]);
      // $searchstring .= " AND customer LIKE '%{$searchkeyword[0]}%' "; //  수정포인트 -고객사
    }
    if(trim($searchkeyword[1])!=''){ //작성자
      $searchstring .= $this->make_searchstring('writer', $searchkeyword[1]);
      // $searchstring .= " AND writer LIKE '%{$searchkeyword[1]}%' "; //  수정포인트 -직성자
    }
    if(trim($searchkeyword[2])!=''){ //작업명
      $searchstring .= $this->make_searchstring('subject', $searchkeyword[2]);
      // $searchstring .= " AND subject LIKE '%{$searchkeyword[2]}%' "; //  수정포인트 -작업명
    }
    if(trim($searchkeyword[3])!=''){ //작성일
      $searchstring .= " AND insert_date LIKE '%{$searchkeyword[3]}%' "; //  수정포인트 -작성일
    }
    if(trim($searchkeyword[4])!=''){ //결과
      $searchstring .= " AND result LIKE '%{$searchkeyword[4]}%' "; //  수정포인트 -결과
    }
    if(trim($searchkeyword[5])!=''){ //장비명
      $searchstring .= $this->make_searchstring('produce', $searchkeyword[5]);
      // $searchstring .= " AND produce LIKE '%{$searchkeyword[5]}%' "; //  수정포인트 -장비명
    }
    if(trim($searchkeyword[6])!=''){ //지원내역
      $searchstring .= $this->make_searchstring('work_process', $searchkeyword[6]);
      // $searchstring .= " AND work_process LIKE '%{$searchkeyword[6]}%' "; //  수정포인트 -지원내역
    }

    if(trim($searchkeyword[7])!='') { //해시태그
      $searchhashtag = preg_replace('/[," "]+/', '', $searchkeyword[7]); //',', 모든공백 제거
      $hashtag_arr = explode('#', $searchhashtag);
      unset($hashtag_arr[0]);

      if(count($hashtag_arr) > 1) { //여러개 검색
        $hashtag_name = join("','", $hashtag_arr);
        $hashtag_name = "('".$hashtag_name."')";
        $cnt = count($hashtag_arr);

        if($type == "N") { //임시저장
          $searchstring .= "AND seq IN (
            SELECT tb_seq FROM (SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq WHERE h.hashtag_name IN {$hashtag_name} AND tb_name = 'tech_doc_basic_temporary_save'
            ) AS ht GROUP BY tb_seq HAVING COUNT(*) = {$cnt})";
        } else {
          $searchstring .= "AND seq IN (
            SELECT tb_seq FROM (SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq WHERE h.hashtag_name IN {$hashtag_name} AND tb_name = 'tech_doc_basic'
            ) AS ht GROUP BY tb_seq HAVING COUNT(*) = {$cnt})";
        // echo $searchstring;
        }

      } else if (count($hashtag_arr) == 1) { //한개 검색
          $hashtag_name = $hashtag_arr[1];
          $hashtag_name = "('".$hashtag_name."')";

          if($type == "N") { //임시저장
            $searchstring .= "AND seq IN (
              SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq
              WHERE h.hashtag_name = {$hashtag_name} AND tb_name = 'tech_doc_basic_temporary_save')";
          } else {
            $searchstring .= "AND seq IN (
              SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq
              WHERE h.hashtag_name = {$hashtag_name} AND tb_name = 'tech_doc_basic')";
          // echo $searchstring;
          }

      }

    }
    if(trim($searchkeyword[8])!=''){ //지원구분
      $searchstring .= $this->make_searchstring('work_name', $searchkeyword[8]);
    }
    if(trim($searchkeyword[9])!=''){ //제조사
      $searchstring .= $this->make_searchstring('manufacturer', $searchkeyword[9]);
    }
    if(trim($searchkeyword[10])!=''){ //작성기간 시작일
      $searchstring .= " AND insert_date >= '{$searchkeyword[10]}' AND CAST(insert_date as DATE) <= '{$searchkeyword[11]}'";
    }
    // if(trim($searchkeyword[11])!=''){ //작성기간 종료일
    //   $searchstring .= " AND insert_date <= '{$searchkeyword[11]}'";
    // }
    if(trim($searchkeyword[12])!='') {
      $searchstring .= $this->make_searchstring('version', $searchkeyword[12]);
    }
    if(trim($searchkeyword[13])!='') {
      $searchstring .= $this->make_searchstring('sn', $searchkeyword[13]);
    }
  }

  if($hashtag != '') { //해시태그 눌렀을때 셀렉
    if($type == "N") { //임시저장
      $hashtag_table = 'tech_doc_basic_temporary_save';
    } else {
      $hashtag_table = 'tech_doc_basic';
    }
    $hashtag_string = " AND seq IN (
      SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq
      WHERE h.hashtag_name = '{$hashtag}' AND tb_name = '{$hashtag_table}')";
  } else {
    $hashtag_string = '';
  }

  if($type != 'N' && $excellent_report_yn == "Y") {
    $ex_string = ' AND ex_cnt > 0';
  } else {
    $ex_string = '';
  }

  if($this->cooperation_yn == 'Y') {
    $coop = " AND writer_seq = {$this->seq}";
  } else {
    $coop = '';
  }


   if($type == "N"){ //임시저장tbl
     $sql = "SELECT * FROM tech_doc_basic_temporary_save WHERE writer = '{$this->name}' {$searchstring} {$hashtag_string} ORDER BY seq DESC";
     // $my_register_list =  " AND writer = '{$this->name}'";
    // $my_register_list =  " AND register ='{$type}'  AND (writer_id = '{$this->id}' OR participant LIKE '%{$this->id}%')";
   }else{ //기존 등록tbl
     $sql = "SELECT * FROM tech_doc_basic tdb LEFT JOIN (SELECT basic_seq, COUNT(*) as ex_cnt FROM tech_doc_excellent_report GROUP BY basic_seq) tder on tdb.seq = tder.basic_seq where 1=1 {$searchstring} {$hashtag_string} {$ex_string} {$coop} ORDER BY tdb.seq DESC";
     // $my_register_list = "";
   }
   // $sql = "SELECT * FROM tech_doc_basic WHERE register ='{$type}'{$my_register_list}{$searchstring} ORDER BY seq DESC";
// echo $sql;
   if  ( $offset <> 0 )
      $sql = $sql." limit {$start_limit}, {$offset}";

   $query = $this->db->query( $sql );
   return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
}


// 기술지원보고서 리스트개수
//컨트롤러에서 넘긴 $searchkeyword 넣어줘야해ㅜ 꼭,,넣어,,
function tech_doc_list_count( $type, $searchkeyword, $hashtag, $excellent_report_yn, $start_limit = 0, $offset = 0) {

  $searchstring = '';

  if ($searchkeyword != ''){

    $searchkeyword = explode(',',$searchkeyword); // 하나로 합쳐진 문자열 분리

    if(trim($searchkeyword[0])!=''){ //고객사
      $searchstring .= $this->make_searchstring('customer', $searchkeyword[0]);
      // $searchstring .= " AND customer LIKE '%{$searchkeyword[0]}%' "; //  수정포인트 -고객사
    }
    if(trim($searchkeyword[1])!=''){ //작성자
      $searchstring .= $this->make_searchstring('writer', $searchkeyword[1]);
      // $searchstring .= " AND writer LIKE '%{$searchkeyword[1]}%' "; //  수정포인트 -직성자
    }
    if(trim($searchkeyword[2])!=''){ //직업명
      $searchstring .= $this->make_searchstring('subject', $searchkeyword[2]);
      // $searchstring .= " AND subject LIKE '%{$searchkeyword[2]}%' "; //  수정포인트 -작업명
    }
    if(trim($searchkeyword[3])!=''){ //작성일
      $searchstring .= " AND insert_date LIKE '%{$searchkeyword[3]}%' "; //  수정포인트 -작성일
    }
    if(trim($searchkeyword[4])!=''){ //결과
      $searchstring .= " AND result LIKE '%{$searchkeyword[4]}%' "; //  수정포인트 -결과
    }
    if(trim($searchkeyword[5])!=''){ //장비명
      $searchstring .= $this->make_searchstring('produce', $searchkeyword[5]);
      // $searchstring .= " AND produce LIKE '%{$searchkeyword[5]}%' "; //  수정포인트 -장비명
    }
    if(trim($searchkeyword[6])!=''){ //지원내역
      $searchstring .= $this->make_searchstring('work_process', $searchkeyword[6]);
      // $searchstring .= " AND work_process LIKE '%{$searchkeyword[6]}%' "; //  수정포인트 -지원내역
    }
    // var_dump($searchkeyword);
    // exit;

    if(trim($searchkeyword[7])!='') { //해시태그
      $searchhashtag = preg_replace('/[," "]+/', '', $searchkeyword[7]); //',', 모든공백 제거
      $hashtag_arr = explode('#', $searchhashtag);
      unset($hashtag_arr[0]);

      if(count($hashtag_arr) > 1) { //여러개 검색
        $hashtag_name = join("','", $hashtag_arr);
        $hashtag_name = "('".$hashtag_name."')";
        $cnt = count($hashtag_arr);

        if($type == "N") { //임시저장
          $searchstring .= "AND seq IN (
            SELECT tb_seq FROM (SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq WHERE h.hashtag_name IN {$hashtag_name} AND tb_name = 'tech_doc_basic_temporary_save'
            ) AS ht GROUP BY tb_seq HAVING COUNT(*) = {$cnt})";
        } else {
          $searchstring .= "AND seq IN (
            SELECT tb_seq FROM (SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq WHERE h.hashtag_name IN {$hashtag_name} AND tb_name = 'tech_doc_basic'
            ) AS ht GROUP BY tb_seq HAVING COUNT(*) = {$cnt})";
        // echo $searchstring;
        }

      } else if (count($hashtag_arr) == 1) { //한게 검색
          $hashtag_name = $hashtag_arr[1];
          $hashtag_name = "('".$hashtag_name."')";

          if($type == "N") { //임시저장
            $searchstring .= "AND seq IN (
              SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq
              WHERE h.hashtag_name = {$hashtag_name} AND tb_name = 'tech_doc_basic_temporary_save')";
          } else {
            $searchstring .= "AND seq IN (
              SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq
              WHERE h.hashtag_name = {$hashtag_name} AND tb_name = 'tech_doc_basic')";
          // echo $searchstring;
          }

      }

    }
    if(trim($searchkeyword[8])!=''){ //지원구분
      $searchstring .= $this->make_searchstring('work_name', $searchkeyword[8]);
      // $searchstring .= " AND writer LIKE '%{$searchkeyword[8]}%' "; //  수정포인트 -지원구분
    }
    if(trim($searchkeyword[9])!=''){ //제조사
      $searchstring .= $this->make_searchstring('manufacturer', $searchkeyword[9]);
      // $searchstring .= " AND writer LIKE '%{$searchkeyword[9]}%' "; //  수정포인트 -제조사
    }
    if(trim($searchkeyword[10])!=''){ //작성기간 시작일
      // $searchstring .= $this->make_searchstring('insert_date', $searchkeyword[10]);
      $searchstring .= " AND insert_date >= '{$searchkeyword[10]}' AND CAST(insert_date as DATE) <= '{$searchkeyword[11]}'";

      // $searchstring .= " AND writer LIKE '%{$searchkeyword[10]}%' "; //  수정포인트 -작성기간
    }
    if(trim($searchkeyword[12])!='') {
      $searchstring .= $this->make_searchstring('version', $searchkeyword[12]);
    }
    if(trim($searchkeyword[13])!='') {
      $searchstring .= $this->make_searchstring('sn', $searchkeyword[13]);
    }

  }

  if($hashtag != '') { //해시태그 눌렀을때 셀렉
    if($type == "N") { //임시저장
      $hashtag_table = 'tech_doc_basic_temporary_save';
    } else {
      $hashtag_table = 'tech_doc_basic';
    }
    $hashtag_string = " AND seq IN (
      SELECT tb_seq FROM hashtag_link hl JOIN hashtag h ON hl.hashtag_seq = h.seq
      WHERE h.hashtag_name = '{$hashtag}' AND tb_name = '{$hashtag_table}')";
  } else {
    $hashtag_string = '';
  }

  if($type != 'N' && $excellent_report_yn == "Y") {
    $ex_string = ' AND ex_cnt > 0';
  } else {
    $ex_string = '';
  }

  if($this->cooperation_yn == 'Y') {
    $coop = " AND writer_seq = {$this->seq}";
  } else {
    $coop = '';
  }

   if($type == "N"){ //임시저장tbl
     $sql = "SELECT count(seq) AS ucount FROM tech_doc_basic_temporary_save WHERE writer = '{$this->name}' {$searchstring} {$hashtag_string} ORDER BY seq DESC";
   }else{ //기존 등록tbl
     $sql = "SELECT count(seq) AS ucount FROM tech_doc_basic tdb LEFT JOIN (SELECT basic_seq, COUNT(*) as ex_cnt FROM tech_doc_excellent_report GROUP BY basic_seq) tder on tdb.seq = tder.basic_seq where 1=1 {$searchstring} {$hashtag_string} {$ex_string} {$coop} ORDER BY seq DESC";
   }
   // $sql = "select count(seq) as ucount from tech_doc_basic".$searchstring." order by seq desc"; //  수정포인트
   $query = $this->db->query( $sql );

   return $query->row();
}

   function tech_doc_insert( $data, $mode = 0 , $seq = 0 , $table = 0) {

     $db_name = $data['db_name'];
     unset($data['db_name']);
     array_values($data);

      if( $mode == 0 ) { //insert
        if(!empty($seq) && $seq <> ''){ //

          if($db_name == 'N'){
            //등록 페이지에서 임시저장을 한다.
            $result = $this->db->insert('tech_doc_basic_temporary_save', $data );
            $insert_seq = $this->db->insert_id();

            $this->db->where('seq', $seq);
            $this->db->delete('tech_doc_basic');

            $this->db->where('tb_seq', $seq); //기존 해시태그링크 초기화
            $this->db->delete('hashtag_link');

          }else{
            //임시저장 페이지에서 등록을 한다.
            $result = $this->db->insert('tech_doc_basic', $data );
            $insert_seq = $this->db->insert_id();

            $this->db->where('seq', $seq);
            $this->db->delete('tech_doc_basic_temporary_save');

            $this->db->where('tb_seq', $seq); //기존 해시태그링크 초기화
            $this->db->delete('hashtag_link');
          }

        }else{

          if($db_name == 'N'){
            //임시저장으로 처음 저장
            $result = $this->db->insert('tech_doc_basic_temporary_save', $data );
            $insert_seq = $this->db->insert_id();
          }else{
            //등록으로 처음 등록
            $result = $this->db->insert('tech_doc_basic', $data );
            // $result = $this->db->insert('tech_doc_basic', $data );
            $insert_seq = $this->db->insert_id();

            if($result){
              //수정이 필요한 부분
              $engineer_seq = $data['engineer_seq'];
              $sql3 = "select * FROM weekly_report WHERE (SELECT income_time from tech_doc_basic order by seq desc limit 1) BETWEEN s_date AND e_date AND (";
              if(strpos($engineer_seq, ',') !== false){ //엔지니어 여러명일때
                $engineer_seq = explode(',',$engineer_seq);
                for($i =0; $i <count($engineer_seq); $i++){
                  $e_seq = mb_substr(trim($engineer_seq[$i]),0,3);
                  if($i==0){
                     $sql3 .= "group_name = (SELECT user_group FROM user where seq = '{$e_seq}')";
                  }else{
                     $sql3 .= " or group_name = (SELECT user_group FROM user where seq = '{$e_seq}')";
                  }
               }
            }else{//엔지니어 한명 일 때
               $e_seq = mb_substr(trim($engineer_seq),0,3);
               $sql3 .= "group_name = (SELECT user_group FROM user where seq = '{$e_seq}')";
            }
            $sql3 .= "or group_name ='기술본부')";
            //이거 쿼리로 한번에 할 수 있게 수정해바

            $query = $this->db->query($sql3);
            if ($query->num_rows() <= 0) {
               return $insert_seq;
            } else {
               $weekly_report = $query->result_array();
               $produceinfo='';
               $produce= explode(",",$data['produce']);
               $host= explode(",",$data['host']);
               $version= explode(",",$data['version']);
               $hardware= explode(",",$data['hardware']);
               $license= explode(",",$data['license']);
               for($i=0; $i < count($produce); $i++){
                  if($i!=count($produce)){
                     $produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}\n";
                  }else{
                     $produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}";
                  }
               }

               for($i =0; $i < count($weekly_report); $i++){
                  $sql3 = "INSERT INTO weekly_report_doc (report_seq,tech_seq,group_name,year,month,week,type,work_name,produce,customer,subject,writer,income_time,insert_time) values ({$weekly_report[$i]['seq']},(SELECT seq from tech_doc_basic order by seq desc limit 1),'{$weekly_report[$i]['group_name']}','{$weekly_report[$i]['year']}','{$weekly_report[$i]['month']}','{$weekly_report[$i]['week']}',0,'{$data['work_name']}','{$produceinfo}','{$data['customer']}','{$data['subject']}','{$data['engineer']}','{$data['income_time']}', NOW())";
                  $query3 = $this->db->query($sql3);
                  }
              }
            }
          }

        }

        return $insert_seq;

      } else { //modify $mode == 1
        if($db_name == 'N'){ //임시저장tbl
          //임시저장 페이지에서 다시 임시저장을 한다.(수정)

          $this->db->where('seq', $seq);
          $result = $this->db->update('tech_doc_basic_temporary_save', $data);
          return $result;

        }else{//기존 등록tbl
          //등록 페이지에서 다시 등록을 한다(수정)

             $sql2 = "SELECT * FROM weekly_report_doc WHERE tech_seq = {$seq}";
             $query2 = $this->db->query($sql2);
             if($query2->num_rows() <= 0){ //modify num_rows <=0
                $result =  $this->db->update('tech_doc_basic', $data, array('seq' => $seq));
                //////
                $engineer_seq = $data['engineer_seq'];
                $sql3 = "select * FROM weekly_report WHERE (SELECT income_time from tech_doc_basic order by seq desc limit 1) BETWEEN s_date AND e_date AND (";
                if(strpos($engineer_seq, ',') !== false){ //엔지니어 여러명일때
                   $engineer_seq = explode(',',$engineer_seq);
                   for($i =0; $i <count($engineer_seq); $i++){
                      $e_seq = mb_substr(trim($engineer_seq[$i]),0,3);
                      if($i==0){
                         $sql3 .= "group_name = (SELECT user_group FROM user where seq = '{$e_seq}')";
                      }else{
                         $sql3 .= " or group_name = (SELECT user_group FROM user where seq = '{$e_seq}')";
                      }
                   }
                }else{//엔지니어 한명 일 때
                   $e_seq = mb_substr(trim($engineer_seq),0,3);
                   $sql3 .= "group_name = (SELECT user_group FROM user where seq = '{$e_seq}')";
                }
                $sql3 .= "or group_name ='기술본부')";
                //이거 쿼리로 한번에 할 수 있게 수정해바

                $query = $this->db->query($sql3);
                if ($query->num_rows() <= 0) {
                   return $result;
                } else {
                   $weekly_report = $query->result_array();
                   $produceinfo='';
                   $produce= explode(",",$data['produce']);
                   $host= explode(",",$data['host']);
                   $version= explode(",",$data['version']);
                   $hardware= explode(",",$data['hardware']);
                   $license= explode(",",$data['license']);
                   for($i=0; $i < count($produce); $i++){
                      if($i!=count($produce)){
                         $produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}\n";
                      }else{
                         $produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}";
                      }
                   }

                   for($i =0; $i < count($weekly_report); $i++){

                      $sql3 = "INSERT INTO weekly_report_doc (report_seq,tech_seq,group_name,year,month,week,type,work_name,produce,customer,subject,writer,income_time,insert_time) VALUES ({$weekly_report[$i]['seq']},{$seq},'{$weekly_report[$i]['group_name']}','{$weekly_report[$i]['year']}','{$weekly_report[$i]['month']}','{$weekly_report[$i]['week']}',0,'{$data['work_name']}','{$produceinfo}','{$data['customer']}','{$data['subject']}','{$data['engineer']}','{$data['income_time']}', NOW())";
                      $query3 = $this->db->query($sql3);
                   }
                }
                return $result;
             }else{ //modify num_rows > 0

                $produceinfo='';
                $produce= explode(",",$data['produce']);
                $host= explode(",",$data['host']);
                $version= explode(",",$data['version']);
                $hardware= explode(",",$data['hardware']);
                $license= explode(",",$data['license']);
                for($i=0; $i < count($produce); $i++){
                   if($i!=count($produce)){
                      $produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}\n";
                   }else{
                      $produceinfo .= "{$produce[$i]}/{$host[$i]}/{$version[$i]}/{$hardware[$i]}/{$license[$i]}";
                   }
                }

                $result = $this->db->update('tech_doc_basic', $data, array('seq' => $seq));

                if($result){
                   $weekly=$query2->result_array();

                   for($i=0; $i<count($weekly); $i++){
                      $sql3="update weekly_report_doc set work_name='{$data['work_name']}' ,income_time='{$data['income_time']}' ,customer='{$data['customer']}', produce='{$produceinfo}',writer='{$data['engineer']}', update_time = now() where seq = {$weekly[$i]['seq']}";
                      $result = $this->db->query($sql3);
                   }
                }
                return $result;
             } //modify num_rows
          }//$db_name = Y || $db_name = N
      }
   }

   //정기점검보고서 썼을때 유지보수에서 점검여부 완료로 수정 하는고
   // function maintain_result($some_inspection,$data,$mode){
   function maintain_result($some_inspection,$data){
      $maintain_type='';
      $maintain_result ='';
      $file='';

      if($data['handle'] == "현장지원"){
         $maintain_type=1;
      }else{
         $maintain_type=2;
      }

      if($some_inspection == 'N'){ //전체완료 일땐 완료
         $maintain_result = 1;
      }else{                   //부분 완료일때는 미완료
         $maintain_result = 0;
      }

      if(isset($data['file_realname']) && isset($data['file_changename'])){ //첨부파일 여부
         $file='Y';
      }else{
         $file='N';
      }

      // if($mode == 0){ //기존 프로젝트로 update
      //    $sql="update sales_forcasting set maintain_date='".$data['income_time']."', maintain_result={$maintain_result}, maintain_user='".$data['writer']."', file='{$file}', maintain_type='{$maintain_type}'
      //    WHERE seq in (select * from (SELECT seq FROM sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting where seq ={$data['forcasting_seq']}) OR seq = {$data['forcasting_seq']})as t)";
      //    $result = $this->db->query($sql);
      // }else{//제품의 프로젝트로
      //    $sql="select forcasting_seq as seq from sales_forcasting as t1 join sales_forcasting_product as t2 on t1.seq = t2.forcasting_seq WHERE t2.seq IN ({$data['produce_seq']}) GROUP BY forcasting_seq";
      //    $update_seq = $this->db->query($sql)->result_array();

      //    for($i=0; $i<count($update_seq); $i++){
      //       $sql1="update sales_forcasting set maintain_date='".$data['income_time']."', maintain_result={$maintain_result}, maintain_user='".$data['writer']."', file='{$file}', maintain_type='{$maintain_type}'
      //       where seq in (select * from (SELECT seq FROM sales_forcasting WHERE sub_project_add = (SELECT sub_project_add FROM sales_forcasting where seq ={$update_seq[$i]['seq']}) OR seq ={$update_seq[$i]['seq']})as t)";
      //       $result = $this->db->query($sql1);
      //    }
      // }
      if($data['maintain_seq'] == null || $data['maintain_seq'] == ""){//이전 데이터 기지보 수정 할때 maintain_seq 없을때
         // $sql = "update sales_maintain set maintain_date='{$data['income_time']}', maintain_result={$maintain_result}, maintain_user='{$data['writer']}', file='{$file}', maintain_type='{$maintain_type}' WHERE seq = {$data['maintain_seq']} ";
         $sql = "UPDATE sales_maintain SET maintain_date='{$data['income_time']}', maintain_result={$maintain_result}, maintain_user='{$data['writer']}', file='{$file}', maintain_type='{$maintain_type}' WHERE forcasting_seq = {$data['forcasting_seq']} ORDER BY seq DESC  LIMIT 1";
      }else{
         $sql = "UPDATE sales_maintain SET maintain_date='{$data['income_time']}', maintain_result={$maintain_result}, maintain_user='{$data['writer']}', file='{$file}', maintain_type='{$maintain_type}' WHERE seq = {$data['maintain_seq']} ";
      }
      $result = $this->db->query($sql);
      return $result;
   }

   //   공지사항 뷰내용 가져오기
   function tech_doc_view( $seq, $type ) {

     if($type == 'N'){
       $db_name = 'tech_doc_basic_temporary_save';
     }else{
       $db_name = 'tech_doc_basic';
     }

      ///test////
      if(strpos($seq,',') == false){
         $sql = "SELECT * FROM {$db_name} WHERE seq = {$seq}";
         // $sql = "SELECT * FROM tech_doc_basic WHERE seq = {$seq}";
         $query = $this->db->query( $sql );

      }else{
         $seq = explode(',',$seq);

         $sql = "SELECT * FROM {$db_name} WHERE seq = {$seq[0]}";
         // $sql = "SELECT * FROM tech_doc_basic WHERE seq = {$seq[0]}";
         for($i=1; $i<count($seq); $i++){
            $sql = $sql." or seq={$seq[$i]}";
         }
         $query = $this->db->query($sql);
         return $query->result_array();
      }

      if ($query->num_rows() <= 0) {
         return false;
      } else {
         return $query->row_array() ;
      }
   }

   //메일 보냈는지 확인
   function tech_mail_send($mail_send,$seq){

      if(strpos($seq,',') == false){
         $sql = "update tech_doc_basic set mail_send=? where seq=?";
         $query = $this->db->query($sql,array($mail_send,$seq));
      }else{
         $seq = explode(',',$seq);
         $sql = "update tech_doc_basic set mail_send='{$mail_send}' where seq = {$seq[0]}";
         for($i=1; $i<count($seq); $i++){
            $sql = $sql." or seq = {$seq[$i]}";
         }
         $query = $this->db->query($sql);
      }
   }

   // 삭제
   function tech_doc_delete( $seq, $type ) {

     if($type == 'N'){
       $db_name = 'tech_doc_basic_temporary_save';
     }else{
       $db_name = 'tech_doc_basic';
     }
      $sql = "DELETE FROM {$db_name} WHERE seq = {$seq}";
      // $sql = "DELETE FROM tech_doc_basic WHERE seq = ?";
      $query = $this->db->query( $sql );

      return   $query;
   }





   //===========================================================

   //Site 장비등록 관린 쿼리
   // db table : sales_forcasting_product
   //
   //
      // 추가및 수정
   function tech_device_insert( $data, $mode , $seq) {
         $result = $this->db->update('sales_maintain_product', $data, array('seq' => $seq));
         $sql = "select * from sales_maintain_product where seq = {$seq}";
         $update_data = $this->db->query($sql)->row_array();
         // echo "<script>alert('{$update_data['integration_maintain_product_seq']}')</script>";
         if($update_data['integration_maintain_product_seq'] != "" || $update_data['integration_maintain_product_seq']!= null){
            $result =  $this->db->update('sales_integration_maintain_product', $data, array('seq' => $update_data['integration_maintain_product_seq']));
         }
         return $result;
   }

   //장비등록  보기/수정  장비 뷰
   function tech_device_view( $seq ) {
      // $sql = "select * from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq where t2.seq = ?";
      // $sql = "select * from sales_maintain as t1 join sales_maintain_product as t2 join product as t3 on t1.seq=t2.maintain_seq and t2.product_code=t3.seq where t2.seq = ?";
      $sql = "SELECT t1.*,t2.*,t3.product_name, t3.product_company,t3.product_item FROM
      sales_maintain as t1 join sales_maintain_product as t2 join product as t3 on t1.seq = t2.maintain_seq and t2.product_code=t3.seq where t2.seq = {$seq}
      union
      SELECT t1.*,t2.*,t3.product_name,t3.product_company,t3.product_item FROM
      sales_maintain as t1 join sales_maintain_product as t2 join sales_integration_maintain_product as t3 on t1.seq = t2.maintain_seq and t2.integration_maintain_product_seq=t3.seq where t2.seq = {$seq}";
      $query = $this->db->query( $sql );

      if ($query->num_rows() <= 0) {
         return false;
      } else {
         return $query->row_array() ;
      }
   }

   // 삭제
   function tech_device_delete( $seq ) {
      $sql = "delete from site_device where seq = ?";
      $query = $this->db->query( $sql, $seq );

      return   $query;
   }

   //점검항목 템플릿 가져오기
   function check_list_template($seq){
      if($seq == 'all'){
         $sql = "select * from product_check_list_template";
      }else{
         $sql = "select * from product_check_list_template where seq = '{$seq}'";
      }

      $query = $this->db->query( $sql );

      if ($query->num_rows() <= 0) {
         return false;
      } else {
         return $query->result_array();
      }
   }

   //정기점검 2 기술지원 보고서에서 템플릿 가져오기
   function template($product){
      // $sql = "select * from product_check_list_template where seq = (SELECT sp.product_check_list from sales_forcasting_product AS sp JOIN sales_forcasting AS sf ON sp.forcasting_seq = sf.seq WHERE sp.seq={$product}) or product_name =(SELECT sp.product_check_list from sales_forcasting_product AS sp JOIN sales_forcasting AS sf ON sp.forcasting_seq = sf.seq WHERE sp.seq={$product})";
      $sql ="SELECT * FROM product_check_list_template WHERE seq = (SELECT sp.product_check_list FROM sales_maintain_product AS sp JOIN sales_maintain AS sf ON sp.maintain_seq = sf.seq WHERE sp.seq={$product})";
      $query = $this->db->query( $sql );

      if ($query->num_rows() <= 0) {
         return false;
      } else {
         return $query->result_array();
      }
   }

   // 기술지원보고서 리스트
   function tech_device_list( $searchkeyword, $search1, $start_limit = 0, $offset = 0) {
      $keyword = "%".$searchkeyword."%";

      if($searchkeyword != "") {
         if($search1 == "001") {
            $searchstring = " where product_name like '{$keyword}' ";
         } else if($search1 == "002" ) {
            $searchstring = " where customer_companyname like '{$keyword}' ";
         } else if($search1 == "003" ) {
            $searchstring = " where t2.product_serial like '{$keyword}' ";
         }

      } else {
         $searchstring = "";
      }

      //$sql = "select seq, customer, produce, writer, end_date from site_device".$searchstring." order by seq desc";
      // $sql = "select t2.seq,customer_companyname,product_version,product_name,product_item,product_serial,product_state,t2.product_check_list,t2.product_host from sales_forcasting as t1 join sales_forcasting_product as t2 join product as t3 on t1.seq=t2.forcasting_seq and t2.product_code=t3.seq".$searchstring." order by t1.seq desc,t2.seq desc";
      $sql = "(select t1.seq as maintain_seq,t2.seq,customer_companyname,t2.product_version,t3.product_name,t3.product_item,t2.product_serial,t2.product_state,t2.product_check_list,t2.product_host,t1.project_name from (SELECT * from sales_maintain WHERE CURDATE() between exception_saledate2 AND exception_saledate3) as t1 join sales_maintain_product as t2 join product as t3 on t1.seq=t2.maintain_seq and t2.product_code=t3.seq ".$searchstring.")
      UNION
      (select t1.seq as maintain_seq,t2.seq,customer_companyname,t2.product_version,t3.product_name,t3.product_item,t2.product_serial,t2.product_state,t2.product_check_list,t2.product_host,t1.project_name
      from (SELECT * from sales_maintain WHERE CURDATE() between exception_saledate2 AND exception_saledate3) as t1 join sales_maintain_product as t2
      join sales_integration_maintain_product as t3 on t1.seq=t2.maintain_seq and t2.integration_maintain_product_seq=t3.seq ".$searchstring." ) ORDER BY maintain_seq desc,seq DESC";
      if  ( $offset <> 0 )
         $sql = $sql." limit ?, ?";

      if  ( $searchkeyword != "" )
         $query = $this->db->query( $sql, array( $start_limit, $offset ) );
      else
         $query = $this->db->query( $sql, array( $start_limit, $offset ) );

      return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
   }

   // 리스트개수
   function tech_device_list_count($searchkeyword, $search1) {
      $keyword = "%".$searchkeyword."%";

      if($searchkeyword != "") {
         if($search1 == "001") {
            $searchstring = " where product_name like '{$keyword}' ";
         } else if($search1 == "002" ) {
            $searchstring = " where customer_companyname like '{$keyword}' ";
         } else if($search1 == "003" ) {
            $searchstring = " where t2.product_serial like '{$keyword}'";
         }

      } else {
         $searchstring = "";
      }

      // $sql = "select count(*) as ucount from (SELECT * from sales_maintain WHERE CURDATE() between exception_saledate2 AND exception_saledate3) as t1 join sales_maintain_product as t2 join product as t3 on t1.seq=t2.maintain_seq and t2.product_code=t3.seq".$searchstring." order by t1.seq desc,t2.seq DESC";

      $sql ="select (select count(t2.seq) from (SELECT * from sales_maintain WHERE CURDATE() between exception_saledate2 AND exception_saledate3) as t1 join sales_maintain_product as t2 join product as t3 on t1.seq=t2.maintain_seq and t2.product_code=t3.seq ".$searchstring." )
      +(select count(t2.seq)
      from (SELECT * from sales_maintain WHERE CURDATE() between exception_saledate2 AND exception_saledate3) as t1 join sales_maintain_product as t2
      join sales_integration_maintain_product as t3 on t1.seq=t2.maintain_seq and t2.integration_maintain_product_seq=t3.seq ".$searchstring.") as ucount";

      if  ( $searchkeyword != "" )
         $query = $this->db->query( $sql );
      else
         $query = $this->db->query( $sql );
      return $query->row();
   }

   //점검항목 템플릿 insert
   function product_check_list_input($data){
      $sql="insert into product_check_list_template (product_name,check_list) values('{$data['product_name']}','{$data['check_list']}')";
      $query =$this->db->query($sql);
      return   $query;
   }

   //점검항목 템플릿 delete
   function product_check_list_delete($seq){
      $sql="delete from product_check_list_template where seq= '{$seq}'";
      $query =$this->db->query($sql);
      return   $query;
   }

   //점검항목 템플릿 update
   function product_check_list_update($data){
      $sql="update product_check_list_template set product_name='{$data['product_name']}', check_list='{$data['check_list']}' where seq={$data['seq']}";
      $query =$this->db->query($sql);
      return   $query;
   }

   //cover insert
   function cover_insert($cover_name){
      $sql="insert into cover (cover_name) values ('{$cover_name}') ";
      $query =$this->db->query($sql);
      return   $query;
   }

   //cover select
   function cover_select($seq=''){
      if($seq == '' || $seq =='basic'){
         $sql="select * from cover";
      }else{
         $sql="select * from cover where seq={$seq}";
      }

      $query =$this->db->query($sql);
      return $query->result_array();
   }

   //야간근무결과보고서 작성여부 확인
   function night_document($seq) {
     $sql = "SELECT approval_doc_status FROM electronic_approval_doc WHERE tech_seq = {$seq} AND approval_form_seq = 56";
     $query = $this->db->query($sql);
     $result = $query->row_array();
     return $result;
   }

   //주말근무결과보고서 작성여부 확인
   function weekend_document($seq) {
     $sql = "SELECT approval_doc_status FROM electronic_approval_doc WHERE tech_seq = {$seq} AND approval_form_seq = 21";
     $query = $this->db->query($sql);
     $result = $query->row_array();
     return $result;
   }

   //출장보고서 작성여부 확인
   function trip_document($seq) {
     $sql = "SELECT approval_doc_status FROM electronic_approval_doc WHERE tech_seq = {$seq} AND approval_form_seq = 17";
     $query = $this->db->query($sql);
     $result = $query->row_array();
     return $result;
   }

   function approval_document($seq) {
     $sql = "SELECT approval_doc_status FROM electronic_approval_doc WHERE tech_seq = {$seq} AND approval_form_seq = 74";
     $query = $this->db->query($sql);
     return $query->row_array();
   }

   //cover delete
   function cover_delete($seq){
      $sql="delete from cover where seq ={$seq}";
      $query =$this->db->query($sql);
      return   $query;

   }

   function cover_coordinate_update($data,$seq){
      return $this->db->update('cover', $data, array('seq' => $seq)) ;
   }


   //KI1
   function schedule_update($schedule_seq, $count=1){
      $sql = "UPDATE tech_schedule_list SET tech_report = 0 WHERE seq ={$schedule_seq}";
      $query =$this->db->query($sql);
   }

   function schedule_delete($seq, $count=1){
      $sql = "UPDATE tech_schedule_list SET tech_report = 1 WHERE seq = {$seq}";
      $query =$this->db->query($sql);
   }

   function find_end_work_day($seq) {
     $sql = "SELECT date_format(income_time, '%Y-%m-%d') as income_time, date_format(end_work_day, '%Y-%m-%d') as end_work_day from tech_doc_basic where seq = {$seq}";
     $query = $this->db->query($sql);
     if ($query->num_rows() <= 0) {
        return false;
     } else {
        return $query->row_array();
     }
   }

   // function same_schedule_check($customer, $start_day, $schedule_seq){
   //
   //   //참석자에서 본인을 빼고 나머지 사람들이 작성자인 일정 찾기 위해 엔지니어에서 본인 세션이름 제거하는 부분
   //   // $engineer_arr_first = explode(', ',$engineer);
   //   // $engineer_arr_second = array();
   //   // foreach ($engineer_arr_first as $value) {
   //   //     $eaf = explode(' ',$value);
   //   //     array_push($engineer_arr_second, $eaf[0]);
   //   // }
   //   // $find_self = array_search($writer, $engineer_arr_second );
   //   // unset($engineer_arr_second[$find_self]);
   //   // // $engineer_arr_second = array_splice( $engineer_arr_second, $find_self, 1 );
   //   // $participant = implode("|", $engineer_arr_second);
   //
   //
   //    // $sql = "SELECT seq FROM tech_schedule_list WHERE customer='{$customer}' AND start_day='{$start_day}'";
   //    $sql = "SELECT seq FROM tech_schedule_list WHERE customer='{$customer}' AND start_day='{$start_day}' AND seq !='{$schedule_seq}'";
   //    // $sql = "SELECT seq FROM tech_schedule_list WHERE customer='{$customer}' AND start_day='{$start_day}' AND work_name='{$work_name}' AND user_name regexp '{$participant}'";
   //
   //    $query =$this->db->query($sql);
   //    if ($query->num_rows() <= 0) {
   //       return false;
   //    } else {
   //       return $query->result();
   //    }
   // }

   // function same_schedule_delete($seq){
   //   $sql = "SELECT B.seq FROM tech_schedule_list B INNER JOIN tech_schedule_list A ON B.customer = A.customer AND B.start_day = A.start_day WHERE A.seq = '{$seq}'";
   //   //일정 작성자가 본인
   //   // $sql = "SELECT B.seq FROM tech_schedule_list B INNER JOIN tech_schedule_list A ON B.customer = A.customer AND B.start_day = A.start_day AND B.work_name = A.work_name AND B.user_name ='{$writer}' WHERE A.seq = '{$seq}'";
   //   // $sql = "SELECT B.seq FROM tech_schedule_list B WHERE B.customer = A.customer AND B.start_day = A.start_day AND B.work_name = A.work_name (SELECT A.customer, A.start_day, A.work_name FROM tech_schedule_list A WHERE A.seq = '{$seq}')";
   //
   //   $query = $this->db->query($sql);
   //   if ($query->num_rows() <= 0) {
   //      return false;
   //   } else {
   //      return $query->result();
   //   }
   // }

   function user_name_duty($participantArr){
      if(is_array($participantArr)){ //담당SE가 여러 명일 때
         $participant = implode( '|', $participantArr );
         $sql = "SELECT concat(user_name,' ',user_duty) as val FROM user where user_name regexp '$participant'";
         $query =$this->db->query($sql);
         // $result = $query->result_array();
         $result = '';
         foreach ($query->result_array() as $row){
            if($result == ''){
               $result = $row['val'];
            }else{
               $result = $result.', '.$row['val'];
            }
         }
         return   $result;
      }else{ //담당SE가 한 명일 때
         $participant = $participantArr;
         $sql = "SELECT user_duty FROM user where user_name='{$participant}'";
         $query =$this->db->query($sql);
         $result = $query->result_array();
         return   $result;
      }

   }
   //KI2

   function schedule_list($seq){
     $sql = "SELECT *
             FROM tech_schedule_list
             WHERE participant_seq like '%{$seq}%' and tech_report > 0 and work_type='tech' and start_day <= CURDATE()
             AND DATEDIFF(end_day, start_day) < 2
             AND (s_file_realname IS NOT NULL OR start_reason IS NOT NULL)
             AND (e_file_realname IS NOT NULL OR end_reason IS NOT NULL)
             ORDER BY start_day, start_time";
     $query = $this->db->query($sql);
     $result = $query->result_array();
     return $result;
   }

  function details($seq){
    // $query = $this->db->get_where('tech_schedule_list', array('seq' => $seq));
    // $result = $query->row();
    // return $result;
    $where = "WHERE seq={$seq}";
    // if($seq ==''){
    //   $where = '';
    // }
    $sql = "SELECT * FROM tech_schedule_list {$where}";
    // $sql = "SELECT A.*, B.user_duty FROM tech_schedule_list A LEFT OUTER JOIN user B ON A.user_name = B.user_name {$where}";
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result;
  }

  function schedule_file_info($seq) {
    $sql = "SELECT s_file_changename, s_file_realname, e_file_changename, e_file_realname, start_reason, end_reason FROM tech_schedule_list where seq = {$seq}";

    $query = $this->db->query($sql);

    if ($query->num_rows() <= 0) {
       return false;
    } else {
       return $query->row_array() ;
    }
  }

  //요청사항 추가 수정
  function request_insert($type ,$data){
      if($type == 0){
         return $this->db->insert('tech_request', $data);
      }else if($type == 1){//update
         return $this->db->update('tech_request', $data ,array('seq' => $data['seq']));
      }else if ($type == 3){
         $sql = "select * from tech_request where tech_doc_seq = '{$data}'";
         $query =$this->db->query($sql);
         if ($query->num_rows() <= 0) {
            return false;
         } else {
            return $query->row_array();
         }
      }else if ($type == 4){
         $sql = "SELECT a.*,b.user_name from tech_request AS a
         left join user AS b
         ON a.writer_id = b.user_id
         WHERE a.result ='N' {$data}
         order BY a.seq";
         $query =$this->db->query($sql);
         if ($query->num_rows() <= 0) {
            return false;
         } else {
            return $query->result_array();
         }
      }else if ($type == 5){
         $sql = "select * from tech_request where seq = '{$data}'";
         $query = $this->db->query($sql);
         if ($query->num_rows() <= 0) {
            return false;
         } else {
            return $query->row_array();
         }
      }
  }

   //요청사항 추가 수정
   function issue_insert($type ,$data){
      if($type == 0){//insert
          return $this->db->insert('tech_issue', $data );
      }else if($type == 1){//update
         return $this->db->update('tech_issue', $data ,array('seq' => $data['seq']));
      }else if ($type == 3){
          $sql = "select * from tech_issue where tech_doc_seq = '{$data}'";
          $query =$this->db->query($sql);
          if ($query->num_rows() <= 0) {
             return false;
          } else {
             return $query->row_array();
          }
      }else if ($type == 4){
         $sql = "SELECT a.*,b.user_name from tech_issue AS a
         left join user AS b
         ON a.writer_id = b.user_id
         WHERE a.result ='N' {$data}
         order BY a.seq";
         $query =$this->db->query($sql);
         if ($query->num_rows() <= 0) {
            return false;
         } else {
            return $query->result_array();
         }
      }else if ($type == 5){
         $sql = "select * from tech_issue where seq = '{$data}'";
         $query =$this->db->query($sql);
         if ($query->num_rows() <= 0) {
            return false;
         } else {
            return $query->row_array();
         }
      }
   }

   //버그사항 추가 수정
   function bug_insert($type ,$data){
       if($type == 0){
          return $this->db->insert('tech_bug', $data);
       }else if($type == 1){//update
          return $this->db->update('tech_bug', $data ,array('seq' => $data['seq']));
       }else if ($type == 3){
          $sql = "select * from tech_bug where tech_doc_seq = '{$data}'";
          $query =$this->db->query($sql);
          if ($query->num_rows() <= 0) {
             return false;
          } else {
             return $query->row_array();
          }
       }else if ($type == 4){
          $sql = "SELECT a.*,b.user_name from tech_bug AS a
          left join user AS b
          ON a.writer_id = b.user_id
          WHERE a.result ='N' {$data}
          order BY a.seq";
          $query =$this->db->query($sql);
          if ($query->num_rows() <= 0) {
             return false;
          } else {
             return $query->result_array();
          }
       }else if ($type == 5){
          $sql = "select * from tech_bug where seq = '{$data}'";
          $query = $this->db->query($sql);
          if ($query->num_rows() <= 0) {
             return false;
          } else {
             return $query->row_array();
          }
       }
   }


   function hashtag_reset($insert_seq) { //해시태그수정 or 보고서삭제시 초기화
     $this->db->where('tb_seq', $insert_seq);
     $this->db->delete('hashtag_link');

   }

   function hashtag_cnt($hashtag) { //해시태그 중복여부확인위한 카운트
     $sql = "SELECT count(*) as cnt from hashtag where hashtag_name = '{$hashtag}'";
     $result = $this->db->query($sql);

     return $result->row_array();
   }

   function hashtag_insert($data) { //해시태그테이블에 추가
     $this->db->insert('hashtag', $data);
     $hashtag_seq = $this->db->insert_id();

     return $hashtag_seq;
   }

   function hashtag_select($hashtag) { //중복해시태그 셀렉
     $sql = "SELECT seq FROM hashtag where hashtag_name = '{$hashtag}'";
     $result = $this->db->query($sql);

     return $result->row_array();
   }

   function hashtag_link_insert($data) { //링크테이블에 추가
     $result = $this->db->insert('hashtag_link', $data);

     return $result;
   }

   function hashtag_view($seq, $type) { //해시태그 뷰
     if($type == "N") { //임시저장
       $sql = "SELECT hashtag_name FROM hashtag_link AS hl JOIN hashtag AS h ON hl.hashtag_seq = h.seq
       WHERE tb_seq = '{$seq}' AND tb_name = 'tech_doc_basic_temporary_save'";
     } else {
       $sql = "SELECT hashtag_name FROM hashtag_link AS hl JOIN hashtag AS h ON hl.hashtag_seq = h.seq
       WHERE tb_seq = '{$seq}' AND tb_name = 'tech_doc_basic'";
     }

     $hashtag_name = $this->db->query($sql);

     return $hashtag_name->result_array();
   }

   function bug_view($seq){ //버그 뷰
     $sql = "SELECT contents FROM tech_bug WHERE tech_doc_seq = '{$seq}'";
     $result = $this->db->query($sql);

     return $result->row_array();
   }

   // function bug_modify($seq){ // 기지보 수정창 버그 뷰
   //   $sql = "SELECT contents FROM tech_bug WHERE tech_doc_seq = '{$seq}'";
   //   $result = $this->db->query($sql);
   //
   //   return $result->row_array();
   // }


   //기지보 미완료 리스트
   function tech_doc_basic_incompletion($search){
     $sql ="SELECT * FROM tech_doc_basic WHERE result LIKE '%미완료%' {$search} ORDER BY seq";
     $query =$this->db->query($sql);
     if ($query->num_rows() <= 0) {
        return false;
     } else {
        return $query->result_array();
     }
   }


   // 시리얼 번호로 ㅍ로젝트 검색
   function search_serial($type, $keyword){
     if($type == "maintain"){

       $sql = "SELECT a.maintain_seq, UNIX_TIMESTAMP(b.exception_saledate3) as maintain_end, b.forcasting_seq, b.customer_companyname, b.project_name FROM sales_maintain_product AS a LEFT JOIN sales_maintain AS b ON a.maintain_seq = b.seq WHERE a.product_serial LIKE '%{$keyword}%' AND CURDATE() BETWEEN b.exception_saledate2 AND b.exception_saledate3 GROUP BY a.maintain_seq order by BINARY(b.customer_companyname)";

     }else{

       $sql = "SELECT a.forcasting_seq, b.customer_companyname, b.project_name FROM sales_forcasting_product AS a LEFT JOIN sales_forcasting AS b ON a.forcasting_seq = b.seq WHERE a.product_serial LIKE '%{$keyword}%' GROUP BY a.forcasting_seq order by BINARY(b.customer_companyname)";

     }
     $query = $this->db->query($sql);
     if ($query->num_rows() > 0) {
       return $query->result();
     } else {
       return false;
     }
   }

   function req_support_info($seq) {
     $sql = "SELECT cooperative_company, workplace_name, produce, installation_date, visit_date, visit_remark, file_change_name, file_real_name from request_tech_support WHERE seq= {$seq}";

     $query = $this->db->query($sql);

     return $query->result();
   }

   function req_support_approval_complete($approval_seq,$seq) {
     $sql = "UPDATE request_tech_support SET approval_seq = '{$approval_seq}' WHERE seq = '{$seq}'";
// echo $sql;
     $query = $this->db->query($sql);

   }

   //기술지원보고서 리스트
   function tech_doc_list_mobile( $type, $searchkeyword, $searchkeyword2, $search1, $start_limit = 0, $offset = 0) {
      $keyword = "%".$searchkeyword."%";
      $keyword2 = "%".$searchkeyword2."%";

      if($searchkeyword != "") {
         if($search1 == "001") {
            $searchstring = "WHERE subject LIKE '{$keyword}' "; //  수정포인트 -작업명
         } else if($search1 == "002" ) {
            $searchstring = "WHERE customer LIKE '{$keyword}' "; //  수정포인트 - 고객사
         } else if($search1 == "003" ) {
            $searchstring = "WHERE writer LIKE '{$keyword}' "; //  수정포인트 - 작성자
         } else if($search1 == "004" ) {
            $searchstring = "WHERE income_time LIKE '{$keyword}' "; //  수정포인트 - 작업일
         } else if($search1 == "005" ) {
            if($keyword=="%완료%"){
               $keyword="기술지원 완료%";
            }
            $searchstring = "WHERE result LIKE '{$keyword}' "; //  수정포인트 - 결과
         } else if($search1 == "006" ){

           $searchstring = "WHERE produce LIKE '{$keyword}' AND version LIKE '{$keyword2}'";
         }

         if($type == "N"){
           $searchstring .= " AND writer = '{$this->name}'";
         }

      } else {
         $searchstring = "";
         if($type == "N"){
           $searchstring .= "WHERE writer = '{$this->name}'";
         }
      }


      // $sql = "select * from tech_doc_basic".$searchstring." order by seq desc";

      if($type == "N"){ //임시저장tbl
        $sql = "SELECT * FROM tech_doc_basic_temporary_save {$searchstring} ORDER BY seq DESC";
        // $my_register_list =  " AND writer = '{$this->name}'";
       // $my_register_list =  " AND register ='{$type}'  AND (writer_id = '{$this->id}' OR participant LIKE '%{$this->id}%')";
     }else{ //기존 등록tbl
        $sql = "SELECT * FROM tech_doc_basic {$searchstring} ORDER BY seq DESC";
        // $my_register_list = "";
      }

      // $sql = "SELECT * FROM tech_doc_basic WHERE register ='{$type}'{$my_register_list}{$searchstring} ORDER BY seq DESC";

      if  ( $offset <> 0 )
         $sql = $sql." limit {$start_limit}, {$offset}";

      if  ( $searchkeyword != "" )
         if($searchkeyword2 == ""){
            $query = $this->db->query( $sql );
         }else{
            $query = $this->db->query( $sql );
         }
      else
         $query = $this->db->query( $sql );

      return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
   }


   // 기술지원보고서 리스트개수
   function tech_doc_list_count_mobile( $type, $searchkeyword,$searchkeyword2, $search1, $start_limit = 0, $offset = 0) {
      $keyword = "%".$searchkeyword."%";
      $keyword2 = "%".$searchkeyword2."%";

      if($searchkeyword != "") {
         if($search1 == "001") {
            $searchstring = "WHERE subject LIKE '{$keyword}' "; //  수정포인트 -작업명
         } else if($search1 == "002" ) {
            $searchstring = "WHERE customer LIKE '{$keyword}' "; //  수정포인트 - 고객사
         } else if($search1 == "003" ) {
            $searchstring = "WHERE writer LIKE '{$keyword}' "; //  수정포인트 - 작성자
         } else if($search1 == "004" ) {
            $searchstring = "WHERE income_time LIKE '{$keyword}' "; //  수정포인트 - 작업일
         } else if($search1 == "005" ) {
            $searchstring = "WHERE result LIKE '{$keyword}' "; //  수정포인트 - 작업일
         } else if($search1 == "006" ) {
            $searchstring = "WHERE produce LIKE '{$keyword}' AND version LIKE '{$keyword2}'";
         }

         if($type == "N"){
           $searchstring .= " AND writer = '{$this->name}'";
         }

      } else {
         $searchstring = "";
         if($type == "N"){
           $searchstring .= "WHERE writer = '{$this->name}'";
         }
      }

      if($type == "N"){ //임시저장tbl
        $sql = "SELECT count(seq) AS ucount FROM tech_doc_basic_temporary_save {$searchstring} ORDER BY seq DESC";
      }else{ //기존 등록tbl
        $sql = "SELECT count(seq) AS ucount FROM tech_doc_basic {$searchstring} ORDER BY seq DESC";
      }
      // $sql = "select count(seq) as ucount from tech_doc_basic".$searchstring." order by seq desc"; //  수정포인트
      if( $searchkeyword != "" ){
         if( $searchkeyword2 == "" ){
            $query = $this->db->query( $sql );
         }else{
            $query = $this->db->query( $sql );
         }
      }else{
         $query = $this->db->query( $sql );
      }
      return $query->row();
   }

   // 제품 정보 저장
  function save_product_info($mode, $product_seq, $data) {
    $this->db->where('seq', $product_seq);
    return $this->db->update('sales_'.$mode.'_product', $data);
  }

  //제품 제조사(중복없이)가져오기
  function product_company(){
    $sql = "SELECT DISTINCT product_company FROM product";
    $query = $this->db->query( $sql );

    if ($query->num_rows() <= 0) {
      return false;
    } else {
      return $query->result_array();
    }
  }

  //우수보고서 선택
  function excellentReportInsert($data){
   return $this->db->insert('tech_doc_excellent_report', $data);
  }

  //우수보고서 취소
  function excellentReportCancle($seq){
    $where = array(
      'basic_seq' => $seq,
      'selector_seq' => $this->seq
    );

    $this->db->where($where);
    $this->db->delete('tech_doc_excellent_report');
  }

  function excellent_check_list($seq) {
    $sql = "SELECT tder.*, u.user_name, u.user_duty FROM tech_doc_excellent_report tder LEFT JOIN user u ON tder.selector_seq = u.seq WHERE basic_seq = {$seq}";

    $query = $this->db->query($sql);

    return $query->result_array();
  }

  function find_sign_img($writer) {
    $sql = "SELECT sign_changename FROM user WHERE user_name = '{$writer}'";

    $query = $this->db->query($sql);

    return $query->row_array();
  }
}

?>
