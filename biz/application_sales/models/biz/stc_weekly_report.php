<?php
header("Content-type: text/html; charset=utf-8");

class STC_weekly_report extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->user_id = $this->phpsession->get( 'id', 'stc' );
    }

    function weekly_report_insert($data) {
      return $this->db->insert('weekly_report', $data );
        // $check_sql = "SELECT * FROM weekly_report WHERE year ='{$data['year']}' and month ='{$data['month']}' AND week ='{$data['week']}' AND group_name ='{$data['group_name']}'";
        // $query = $this->db->query( $check_sql );
        // if ($query->num_rows() <= 0){
        // }else{
        //     return false;
        // }
    }

    function weekly_report_list( $searchkeyword,$search_keyword2, $search1, $start_limit = 0, $offset = 0) {
        $keyword = $searchkeyword;
        $tmp="";
        $user_seq = $this->seq;
        $user_group = $this->group;
        $pGroupName = $this->pGroupName;

        if($searchkeyword != "") {
                if($search1 == "001") {
                        $searchstring = " where group_name like '%{$keyword}%' "; //  수정포인트 -작업명
                } else if($search1 == "002" ) {
                        $searchstring = " where month like '%{$keyword}%' and week like '%{$search_keyword2}%'";
        $keyword = substr($searchkeyword,8,2);
                } else if($search1 == "003" ) {
                        $searchstring = " where writer like '%{$keyword}%' "; //  수정포인트 - 작성자
                }
        } else {
                $searchstring = "";
        }

        if($user_group == "CEO" || $pGroupName == "기술연구소") {
          $group = "";
        } else if($pGroupName == '기술본부') { //김갑진 이사님
          $group = "group_name like '기술%' and group_name != '기술연구소'";
        } else if($pGroupName == '영업본부') {
          $group = "group_name like '사업%'";
        } else {
          $group = "group_name = '{$user_group}'";
        }

        if($searchstring == "" && $group != "") {
          $where = " WHERE ";
        } else if($searchstring != "" && $group != "") {
          $where = " AND ";
        } else {
          $where = "";
        }

        $sql = "SELECT * FROM weekly_report LEFT JOIN (SELECT user_seq, notice_seq FROM weekly_report_read GROUP BY notice_seq, user_seq HAVING user_seq = {$user_seq}) AS wrr ON seq = wrr.notice_seq ".$searchstring.$where.$group." ORDER BY seq DESC"; //  수정포인트

        if  ( $offset <> 0 )
            $sql = $sql." limit ?, ?";

        if  ( $searchkeyword != "" )
            $query = $this->db->query( $sql, array($start_limit, $offset ) );

        else
            $query = $this->db->query( $sql, array( $start_limit, $offset ) );

        return array( 'count' => $query->num_rows(), 'data' => $query->result_array() );
    }

    function weekly_report_list_count( $searchkeyword,$search_keyword2, $search1, $start_limit = 0, $offset = 0) {
        $keyword = $searchkeyword;
        $tmp="";
        $user_seq = $this->seq;
        $user_group = $this->group;
        $pGroupName = $this->pGroupName;

        if($searchkeyword != "") {
                if($search1 == "001") {
                        $searchstring = " where group_name like '%{$keyword}%'"; //  수정포인트 -작업명
                } else if($search1 == "002" ) {
                        // $searchstring = " where s_date like '".substr($searchkeyword,0,7)."%' and week = '{$keyword}'"; //  수정포인트 - 고객사
                        $searchstring = " where month like '%{$keyword}%' and week like '%{$search_keyword2}%'";
        $keyword=substr($searchkeyword,8,2);
                } else if($search1 == "003" ) {
                        $searchstring = " where writer like '%{$keyword}%'"; //  수정포인트 - 작성자
                }

        } else {
                $searchstring = "";
        }

        if($user_group == "CEO" || $pGroupName == "기술연구소") {
          $group = "";
        } else if($pGroupName == '기술본부') { //김갑진 이사님
          $group = "group_name like '기술%' and group_name != '기술연구소'";
        } else if($pGroupName == '영업본부') {
          $group = "group_name like '사업%'";
        } else {
          $group = "group_name = '{$user_group}'";
        }

        if($searchstring == "" && $group != "") {
          $where = " WHERE ";
        } else if($searchstring != "" && $group != "") {
          $where = " AND ";
        } else {
          $where = "";
        }

        $sql = "SELECT count(seq) AS ucount FROM weekly_report ".$searchstring.$where.$group." ORDER BY seq DESC"; //  수정포인트

        if  ( $searchkeyword != "" )
            $query = $this->db->query( $sql);
        else
            $query = $this->db->query( $sql );

        return $query->row();
    }

    function weekly_report_read_count($notice_seq, $user_seq) {
      $sql = "SELECT count(*) AS cnt FROM weekly_report_read WHERE notice_seq = {$notice_seq} AND user_seq = {$user_seq}";
      $query = $this->db->query($sql);
      return $query->row_array();
    }

    function weekly_report_read_insert($notice_seq, $user_seq, $data) {
      $this->db->insert('weekly_report_read', $data );
    }

    //주간업무보고
    function weekly_report_view( $seq  ) {
        $sql = "SELECT * FROM weekly_report WHERE seq = ?";
        $query = $this->db->query( $sql, $seq );

        if ($query->num_rows() <= 0) {
                return false;
        } else {
                return $query->row_array() ;
        }
    }

    //주간업무보고 금주
    function weekly_report_doc_view($seq){
        // $sql = "select * from weekly_report_doc where report_seq in ({$seq}) order by FIELD(work_name,'납품설치','설치지원','기술지원','장애지원','정기점검','정기점검2','데모(BMT)지원','미팅','교육지원','교육참석'), income_time";
        $sql = "SELECT * FROM weekly_report_doc WHERE report_seq IN ({$seq}) ORDER BY FIELD(work_name,'정기점검','정기점검2') , income_time ASC";

        $query = $this->db->query($sql);

        if ($query->num_rows() <= 0) {
            return false;
        } else {
            return $query->result_array() ;
        }
    }

    //주간업무보고 차주
    function next_weekly_report_doc_view($seq){
        $sql = "select * from next_weekly_report_doc where report_seq in ({$seq}) order by FIELD(work_name,'납품설치','설치지원','기술지원','장애지원','정기점검','정기점검2','데모(BMT)지원','미팅','교육지원','교육참석'), income_time";

        $query = $this->db->query($sql);

        if ($query->num_rows() <= 0) {
                return false;
        } else {
                return $query->result_array() ;
        }
    }

    //주간업무보고 금주 총 수
    function weekly_report_doc_total($seq){

        $sql = "select count(*) as sum from weekly_report_doc where report_seq in({$seq})";

        $query = $this->db->query($sql);


        if ($query->num_rows() <= 0) {
                return false;
        } else {
                return $query->result_array() ;
        }

    }


    //주간업무보고 차주 총 수
    function next_weekly_report_doc_total($seq){
        $sql = "select count(*) as sum from next_weekly_report_doc where report_seq in({$seq})";

        $query = $this->db->query($sql);

        if ($query->num_rows() <= 0) {
                return false;
        } else {
                return $query->result_array() ;
        }
    }

    //주간업무보고 금주 work_name 갯수
    function weekly_report_doc_count($seq,$year,$month,$group){
        if($group == "기술연구소"){
            $sql = "SELECT monthT.month_cnt,weekT.work_name,weekT.cnt FROM (SELECT COUNT(work_name) AS month_cnt,work_name FROM weekly_report_doc WHERE YEAR={$year} AND MONTH={$month} and group_name='{$group}' GROUP BY work_name) AS monthT
                    JOIN (SELECT COUNT(work_name)AS cnt ,work_name FROM weekly_report_doc weekT where report_seq = {$seq} and group_name='{$group}' GROUP BY work_name) AS weekT
                    ON monthT.work_name = weekT.work_name";
        }else{
            $sql ="SELECT t2.month_cnt,t5.cnt,t5.work_name FROM
                    (SELECT COUNT(*) as month_cnt,t1.work_name FROM (SELECT COUNT(*) AS cnt,wrd.work_name from weekly_report_doc AS wrd JOIN weekly_report AS wr ON wrd.report_seq=wr.seq WHERE wr.group_name='{$group}' AND wr.year='{$year}' and wr.month='{$month}' GROUP BY wrd.tech_seq) AS t1 GROUP BY t1.work_name) AS t2
                    right JOIN
                    (SELECT t3.work_name,t3.value,t4.cnt from work_name_config AS t3 left JOIN (select work_name, count(*) as cnt from weekly_report_doc WHERE report_seq IN ({$seq}) group by work_name) AS t4
                    ON t3.work_name=t4.work_name) AS t5 ON t2.work_name = t5.work_name order BY t5.value";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() <= 0) {
            return false;
        } else {
            return $query->result_array() ;
        }

    }

    //주간업무보고 차주 work_name 갯수
    function next_weekly_report_doc_count($seq,$group){
        if($group == '기술연구소'){
            $sql = "SELECT COUNT(work_name)AS cnt,work_name FROM next_weekly_report_doc where report_seq ={$seq} and group_name='{$group}' GROUP BY work_name";
        }else{
            $sql = "SELECT t1.work_name,t2.cnt FROM work_name_config AS t1 LEFT JOIN (SELECT work_name, count(*) AS cnt FROM next_weekly_report_doc WHERE report_seq IN ({$seq}) GROUP BY work_name) AS t2  ON  t1.work_name=t2.work_name ORDER BY t1.value;";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() <= 0) {
                return false;
        } else {
                return $query->result_array() ;
        }

    }

    //주간업무 등록 전 중복 체크
    function weekly_report_duplcheck($data){
      $query = $this->db->get_where('weekly_report', $data);
      if($query->num_rows() > 0){
        return 'dupl';
      }else{
        return 'ok';
      }
    }
    //주간업무보고 처음 그룹별로 등록할때
    function weekly_report_doc_insert($group,$year,$month,$week,$s_date,$e_date){
        $tmp_s_date = $s_date." 00:00:00";
        $tmp_e_date = $e_date." 23:59:59";

        $report_seq_sql = "SELECT seq from weekly_report order BY seq desc limit 1";
        $report_seq_query = $this->db->query( $report_seq_sql );
        $report_seq = $report_seq_query->row_array();
        if($group == '기술본부' ){

            $sql1 = "insert into weekly_report_doc (report_seq,tech_seq,group_name,work_name,produce,year,month,week,type,customer,subject,result,writer,income_time,insert_time)
            SELECT (select seq from weekly_report order by seq desc limit 1) AS report_seq ,tech_seq, group_name, work_name, produce, year, month, week, type, customer, subject, result, writer, income_time, NOW() AS insert_time
            FROM weekly_report_doc WHERE YEAR ='{$year}' and MONTH='{$month}' and WEEK='{$week}' AND (group_name = '기술1팀' OR group_name = '기술2팀' OR group_name = '기술1팀-2') group BY tech_seq order by seq;";
            $query = $this->db->query($sql1);

            $sql2 = "insert into next_weekly_report_doc (report_seq,tech_seq,schedule_seq,group_name,work_name,produce,year,month,week,type,customer,subject,preparations,writer,income_time,insert_time)
            SELECT (select seq from weekly_report order by seq desc limit 1) AS report_seq ,tech_seq, schedule_seq, group_name, work_name, produce, year, month, week, type, customer, subject, preparations, writer, income_time, NOW() AS insert_time
            FROM next_weekly_report_doc WHERE YEAR ='{$year}' and MONTH='{$month}' and WEEK='{$week}' AND (group_name = '기술1팀' OR group_name = '기술2팀' OR group_name = '기술1팀-2') group BY tech_seq order by seq;";
            $query = $this->db->query($sql2);

            $doc_cnt_sql = "SELECT COUNT(*) as cnt FROM tech_doc_basic where income_time >= '{$tmp_s_date}' and income_time <= '{$tmp_e_date}' AND engineer REGEXP (SELECT replace(GROUP_CONCAT(user_name),',','|') AS NAME FROM user WHERE user_group = '{$group}') and engineer not like '%,%' order by income_time DESC";
            $doc_cnt_query = $this->db->query( $doc_cnt_sql );
            $doc_cnt = $doc_cnt_query->row_array();

            $sql ="call insert_weekly_report_doc({$doc_cnt['cnt']},'{$group}','{$tmp_s_date}','{$tmp_e_date}',{$year},{$month},{$week},{$report_seq['seq']},2)";
            $query = $this->db->query($sql);



            //차주 업무내용 가져오기
            $s_date2 = date("Y-m-d", strtotime("{$s_date} +7 day"));
            $e_date2 = date("Y-m-d", strtotime("{$e_date} +7 day"));

            $new_report_seq_sql = "SELECT seq FROM weekly_report order by seq desc limit 1";
            $new_report_seq_query = $this->db->query($new_report_seq_sql);
            $new_report_seq = $new_report_seq_query->row();
            $new_report_seq = $new_report_seq->seq;

            // $new_tech_report_seq_sql2 = "SELECT tech_seq FROM next_weekly_report_doc WHERE tech_seq != '' order by tech_seq asc limit 1";
            // $new_tech_report_seq_query2 = $this->db->query($new_tech_report_seq_sql2);
            // $new_tech_report_seq2 = $new_tech_report_seq_query2->row();
            // $new_tech_report_seq2 = $new_tech_report_seq2->tech_seq;

            //내용분할
            $select_row_array_sql2 = "SELECT tsl.seq, tsc.contents_num, tsl.group, tsl.work_name, tsl.customer, tsc.contents, tsl.participant, tsl.start_day FROM tech_schedule_contents tsc JOIN tech_schedule_list tsl ON tsc.schedule_seq = tsl.seq WHERE tsc.weekly_report = 'Y' AND tsl.start_day BETWEEN '{$s_date2}' AND '{$e_date2}' AND tsl.participant REGEXP ( SELECT REPLACE(GROUP_CONCAT(us.user_name),',','|') AS NAME FROM user us WHERE us.user_group = '기술본부' || us.user_group = '기술1팀' || us.user_group = '기술2팀' || us.user_group = '기술1팀-2') ORDER BY start_day DESC";
            //$select_row_array_sql2 = "SELECT tsl.seq, tsc.contents_num, tsl.group, tsl.work_name, tsl.customer, tsc.contents, tsl.participant, tsl.start_day FROM tech_schedule_contents tsc JOIN tech_schedule_list tsl ON tsc.schedule_seq = tsl.seq WHERE tsc.weekly_report = 'Y' AND tsl.start_day BETWEEN '{$s_date2}' AND '{$e_date2}' AND tsl.participant REGEXP ( SELECT REPLACE(GROUP_CONCAT(us.user_name),',','|') AS NAME FROM user us WHERE us.user_group='{$group}') ORDER BY start_day DESC";

            $select_row_array_query2 = $this->db->query($select_row_array_sql2);
            $select_row_array2 = $select_row_array_query2->result_array();
            if(count($select_row_array2) > 0){
              for($j=0; $j<count($select_row_array2); $j++){

                $new_tech_report_seq_sql2 = "SELECT DISTINCT(
                    IFNULL(
                      (SELECT DISTINCT(c.tech_seq) FROM next_weekly_report_doc c WHERE c.schedule_seq = {$select_row_array2[$j]['seq']}),
                      (SELECT MIN(tech_seq)-1 FROM next_weekly_report_doc)
                    )
                  ) AS tech_seq
                  FROM next_weekly_report_doc";
                $new_tech_report_seq_query2 = $this->db->query($new_tech_report_seq_sql2);
                $new_tech_report_seq2 = $new_tech_report_seq_query2->row();
                $new_tech_report_seq2 = $new_tech_report_seq2->tech_seq;

                $sql = "INSERT INTO next_weekly_report_doc (report_seq,tech_seq,schedule_seq,contents_num,group_name,year,month,week,work_name,customer,subject,writer,income_time,insert_time) VALUES ('{$new_report_seq}','{$new_tech_report_seq2}','{$select_row_array2[$j]['seq']}','{$select_row_array2[$j]['contents_num']}','{$select_row_array2[$j]['group']}',{$year},{$month},{$week},'{$select_row_array2[$j]['work_name']}','{$select_row_array2[$j]['customer']}','{$select_row_array2[$j]['contents']}','{$select_row_array2[$j]['participant']}','{$select_row_array2[$j]['start_day']}',NOW())";
                // $new_tech_report_seq2 = $new_tech_report_seq2 -1;
                $query = $this->db->query($sql);
              }
            }




        // }else if($group == '영업본부' ){
          //@@@
        }else if($group == '기술1팀' || $group == '기술2팀' || $group == '기술1팀-2'){ //기술1팀, 기술2팀

            //주간업무 기술본부 있나 체크
            $check_sql = "select * from weekly_report where year='{$year}' and month='{$month}' and week='{$week}' and group_name='기술본부'";
            $check_query = $this->db->query( $check_sql );

            $doc_cnt_sql = "SELECT COUNT(*) as cnt FROM tech_doc_basic where income_time >= '{$tmp_s_date}' and income_time <= '{$tmp_e_date}' AND engineer REGEXP (SELECT replace(GROUP_CONCAT(user_name),',','|') AS NAME FROM user WHERE user_group = '{$group}') order by income_time DESC";
            $doc_cnt_query = $this->db->query( $doc_cnt_sql );
            $doc_cnt = $doc_cnt_query->row_array();

            $sql ="call insert_weekly_report_doc({$doc_cnt['cnt']},'{$group}','{$tmp_s_date}','{$tmp_e_date}',{$year},{$month},{$week},{$report_seq['seq']},1)";
            $query = $this->db->query($sql);

            //기술본부 있을때 기술본부에도 추가 (tech_seq 겹치면 안넣어줭)
            if ($check_query->num_rows() > 0 && $query){
                $weekly_report_tech = $check_query->row_array();
                $sql2 ="call insert_weekly_report_doc({$doc_cnt['cnt']},'{$group}','{$tmp_s_date}','{$tmp_e_date}',{$year},{$month},{$week},{$weekly_report_tech['seq']},2)";
                $query = $this->db->query($sql2);
            }




            //차주 업무내용 가져오기
            $s_date2 = date("Y-m-d", strtotime("{$s_date} +7 day"));
            $e_date2 = date("Y-m-d", strtotime("{$e_date} +7 day"));

            // $new_report_seq_sql = "SELECT seq FROM weekly_report order by seq desc limit 1";
            // $new_report_seq_query = $this->db->query($new_report_seq_sql);
            // $new_report_seq = $new_report_seq_query->row();
            // $new_report_seq = $new_report_seq->seq;

            // // $new_tech_report_seq_sql2 = "SELECT tech_seq FROM next_weekly_report_doc WHERE tech_seq != '' order by tech_seq asc limit 1";
            // $new_tech_report_seq_sql2 = "SELECT IFNULL( (tech_seq), (SELECT tech_seq FROM next_weekly_report_doc WHERE tech_seq != '' order by tech_seq asc LIMIT 1) ) FROM next_weekly_report_doc WHERE schedule_seq = {$select_row_array2[$j]['seq']}";
            // $new_tech_report_seq_query2 = $this->db->query($new_tech_report_seq_sql2);
            // $new_tech_report_seq2 = $new_tech_report_seq_query2->row();
            // $new_tech_report_seq2 = $new_tech_report_seq2->tech_seq;

            //내용분할
            $select_row_array_sql2 = "SELECT tsl.seq, tsc.contents_num, tsl.group, tsl.work_name, tsl.customer, tsc.contents, tsl.participant, tsl.start_day FROM tech_schedule_contents tsc JOIN tech_schedule_list tsl ON tsc.schedule_seq = tsl.seq WHERE tsc.weekly_report = 'Y' AND tsl.start_day BETWEEN '{$s_date2}' AND '{$e_date2}' AND tsl.participant REGEXP ( SELECT REPLACE(GROUP_CONCAT(us.user_name),',','|') AS NAME FROM user us WHERE us.user_group='{$group}') ORDER BY start_day DESC";
            $select_row_array_query2 = $this->db->query($select_row_array_sql2);
            $select_row_array2 = $select_row_array_query2->result_array();

            $new_report_seq_sql = "SELECT seq FROM weekly_report order by seq desc limit 1";
            $new_report_seq_query = $this->db->query($new_report_seq_sql);
            $new_report_seq = $new_report_seq_query->row();
            $new_report_seq = $new_report_seq->seq;


            if(count($select_row_array2) > 0){
              for($j=0; $j<count($select_row_array2); $j++){
                $new_tech_report_seq_sql2 = "SELECT DISTINCT(
                    IFNULL(
                      (SELECT DISTINCT(c.tech_seq) from next_weekly_report_doc c WHERE c.schedule_seq = {$select_row_array2[$j]['seq']}),
                      (SELECT MIN(tech_seq)-1 from next_weekly_report_doc)
                    )
                  ) AS tech_seq
                  FROM next_weekly_report_doc;";
                $new_tech_report_seq_query2 = $this->db->query($new_tech_report_seq_sql2);
                $new_tech_report_seq2 = $new_tech_report_seq_query2->row();
                $new_tech_report_seq2 = $new_tech_report_seq2->tech_seq;

                $sql = "INSERT INTO next_weekly_report_doc (report_seq,tech_seq,schedule_seq,contents_num,group_name,year,month,week,work_name,customer,subject,writer,income_time,insert_time) VALUES ('{$new_report_seq}','{$new_tech_report_seq2}','{$select_row_array2[$j]['seq']}','{$select_row_array2[$j]['contents_num']}','{$select_row_array2[$j]['group']}',{$year},{$month},{$week},'{$select_row_array2[$j]['work_name']}','{$select_row_array2[$j]['customer']}','{$select_row_array2[$j]['contents']}','{$select_row_array2[$j]['participant']}','{$select_row_array2[$j]['start_day']}',NOW())";
                // $new_tech_report_seq2 = $new_tech_report_seq2 -1;
                $query = $this->db->query($sql);
              }
            }




        // }else if($group == '사업1부' || $group == '사업2부'){
        //   //주간업무 영업본부 있나 체크
        //   $check_sql = "select * from weekly_report where year='{$year}' and month='{$month}' and week='{$week}' and group_name='영업본부'";
        //   $check_query = $this->db->query( $check_sql );
        //
        //   //영업본부 있을때 영업본부에도 추가 (tech_seq 겹치면 안넣어줭)
        //   if ($check_query->num_rows() > 0 && $query){
        //     $weekly_report_tech = $check_query->row_array();
        //     $sql2 ="call insert_weekly_report_doc(0,'{$group}','{$tmp_s_date}','{$tmp_e_date}',{$year},{$month},{$week},{$weekly_report_tech['seq']},2)";
        //     $query = $this->db->query($sql2);
        //   }

        }else{

          $new_report_seq_sql = "SELECT seq FROM weekly_report order by seq desc limit 1";
          $new_report_seq_query = $this->db->query($new_report_seq_sql);
          $new_report_seq = $new_report_seq_query->row();
          $new_report_seq = $new_report_seq->seq;

          // //금주 업무내용 가져오기
          // $new_tech_report_seq_sql = "SELECT tech_seq FROM weekly_report_doc WHERE tech_seq != '' order by tech_seq asc limit 1";
          // $new_tech_report_seq_query = $this->db->query($new_tech_report_seq_sql);
          // $new_tech_report_seq = $new_tech_report_seq_query->row();
          // $new_tech_report_seq = $new_tech_report_seq->tech_seq;

          //내용분할
          $select_row_array_sql = "SELECT tsl.seq, tsc.contents_num, tsl.group, tsl.work_name, tsl.customer, tsl.visit_company, tsc.contents, tsl.title, tsl.participant, tsl.start_day, tsl.end_day FROM tech_schedule_contents tsc JOIN tech_schedule_list tsl ON tsc.schedule_seq = tsl.seq WHERE tsc.weekly_report = 'Y' AND tsl.start_day BETWEEN '{$s_date}' AND '{$e_date}' AND tsl.participant REGEXP ( SELECT REPLACE(GROUP_CONCAT(us.user_name),',','|') AS NAME FROM user us WHERE us.user_group='{$group}') ORDER BY start_day DESC";
          $select_row_array_query = $this->db->query($select_row_array_sql);
          $select_row_array = $select_row_array_query->result_array();
          if(count($select_row_array) > 0){
            for($i=0; $i<count($select_row_array); $i++){
              if($group == '기술연구소'){

                $new_tech_report_seq_sql = "SELECT DISTINCT(
                    IFNULL(
                      (SELECT DISTINCT(c.tech_seq) FROM weekly_report_doc c WHERE c.schedule_seq = {$select_row_array[$i]['seq']}),
                      (SELECT MIN(tech_seq)-1 FROM weekly_report_doc)
                    )
                  ) AS tech_seq
                  FROM weekly_report_doc";
                $new_tech_report_seq_query = $this->db->query($new_tech_report_seq_sql);
                $new_tech_report_seq = $new_tech_report_seq_query->row();
                $new_tech_report_seq = $new_tech_report_seq->tech_seq;

                $insert_lab_data = array(
                  'report_seq' => $new_report_seq,
                  'tech_seq' => $new_tech_report_seq,
                  'schedule_seq' => $select_row_array[$i]['seq'],
                  'contents_num' => $select_row_array[$i]['contents_num'],
                  'group_name' => $select_row_array[$i]['group'],
                  'year' => $year,
                  'month' => $month,
                  'week' => $week,
                  'writer' => $select_row_array[$i]['participant'],
                  'income_time' => $select_row_array[$i]['start_day'],
                  'insert_time' => date("Y-m-d H:i:s")
                );

                $val_arr = explode(',,,',$select_row_array[$i]['contents']);
                $val_arr_length = count($val_arr);
                for($p = 0; $p < $val_arr_length; $p++){

                    $val_arr2 = explode(':::', $val_arr[$p]);
                    $val_arr_key = $val_arr2[0];
                    $val_arr_value = $val_arr2[1];

                    if($val_arr_key == 'dev_type'){
                      $lab_work_name = $val_arr_value;
                    }else if($val_arr_key == 'dev_page'){
                      $lab_customer = $val_arr_value;
                    }else if($val_arr_key == 'dev_requester'){
                      $lab_type = $val_arr_value;
                    }else if($val_arr_key == 'dev_develop'){
                      $lab_subject = $val_arr_value;
                    }else if($val_arr_key == 'dev_complete'){
                      if($val_arr_value == 'Y'){
                        $lab_result = '완료';
                        $lab_completion_time = $select_row_array[$i]['end_day'];
                      }else{
                        $lab_result = '미완료';
                        $lab_completion_time = null;
                      };
                    };
                };
                $insert_lab_data2 = array(
                  'type' => $lab_type, //요청자
                  'work_name' => $lab_work_name, //작업구분
                  'produce' => $select_row_array[$i]['title'], //요청사항
                  'customer' => $lab_customer, //페이지
                  'subject' => $lab_subject, //개발사항
                  'result' => $lab_result, //결과
                  'completion_time' => $lab_completion_time //예정일자
                );
                $insert_data = array_merge($insert_lab_data, $insert_lab_data2);

              }else{ //기술연구소 외

                $new_tech_report_seq_sql = "SELECT DISTINCT(
                    IFNULL(
                      (SELECT DISTINCT(c.tech_seq) FROM weekly_report_doc c WHERE c.schedule_seq = {$select_row_array[$i]['seq']}),
                      (SELECT MIN(tech_seq)-1 FROM weekly_report_doc)
                    )
                  ) AS tech_seq
                  FROM weekly_report_doc";
                $new_tech_report_seq_query = $this->db->query($new_tech_report_seq_sql);
                $new_tech_report_seq = $new_tech_report_seq_query->row();
                $new_tech_report_seq = $new_tech_report_seq->tech_seq;

                $insert_data = array(
                  'report_seq' => $new_report_seq,
                  'tech_seq' => $new_tech_report_seq,
                  'schedule_seq' => $select_row_array[$i]['seq'],
                  'contents_num' => $select_row_array[$i]['contents_num'],
                  'group_name' => $select_row_array[$i]['group'],
                  'year' => $year,
                  'month' => $month,
                  'week' => $week,
                  'work_name' => $select_row_array[$i]['work_name'],
                  'customer' => $select_row_array[$i]['customer'],
                  'visit_company' => $select_row_array[$i]['visit_company'],
                  'subject' => $select_row_array[$i]['contents'],
                  'writer' => $select_row_array[$i]['participant'],
                  'income_time' => $select_row_array[$i]['start_day'],
                  'insert_time' => date("Y-m-d H:i:s")
                );

              }
              $query = $this->db->insert('weekly_report_doc', $insert_data);
              $new_tech_report_seq = $new_tech_report_seq -1;
            }
          }

          //차주 업무내용 가져오기
          $s_date2 = date("Y-m-d", strtotime("{$s_date} +7 day"));
          $e_date2 = date("Y-m-d", strtotime("{$e_date} +7 day"));

          // $new_tech_report_seq_sql2 = "SELECT tech_seq FROM next_weekly_report_doc WHERE tech_seq != '' order by tech_seq asc limit 1";
          // $new_tech_report_seq_query2 = $this->db->query($new_tech_report_seq_sql2);
          // $new_tech_report_seq2 = $new_tech_report_seq_query2->row();
          // $new_tech_report_seq2 = $new_tech_report_seq2->tech_seq;

          //이전 일정
          // $select_row_array_sql2 = "SELECT sch.seq,sch.group,sch.work_name,sch.customer,sch.visit_company,sch.contents,sch.user_name,sch.start_day FROM tech_schedule_list sch WHERE start_day BETWEEN '{$s_date2}' and '{$e_date2}' AND participant REGEXP (SELECT replace(GROUP_CONCAT(user_name),',','|') AS NAME FROM user WHERE user_group='{$group}') AND weekly_report = 'Y' ORDER BY start_day DESC";

          //내용분할
          $select_row_array_sql2 = "SELECT tsl.seq, tsc.contents_num, tsl.group, tsl.work_name, tsl.customer, tsl.visit_company, tsc.contents, tsl.participant, tsl.title, tsl.start_day, tsl.end_day FROM tech_schedule_contents tsc JOIN tech_schedule_list tsl ON tsc.schedule_seq = tsl.seq WHERE tsc.weekly_report = 'Y' AND tsl.start_day BETWEEN '{$s_date2}' AND '{$e_date2}' AND tsl.participant REGEXP ( SELECT REPLACE(GROUP_CONCAT(us.user_name),',','|') AS NAME FROM user us WHERE us.user_group='{$group}') ORDER BY start_day DESC";
          $select_row_array_query2 = $this->db->query($select_row_array_sql2);
          $select_row_array2 = $select_row_array_query2->result_array();
          if(count($select_row_array2) > 0){
            for($j=0; $j<count($select_row_array2); $j++){
              if($group == '기술연구소'){

                $new_tech_report_seq_sql2 = "SELECT DISTINCT(
                    IFNULL(
                      (SELECT DISTINCT(c.tech_seq) FROM next_weekly_report_doc c WHERE c.schedule_seq = {$select_row_array2[$j]['seq']}),
                      (SELECT MIN(tech_seq)-1 FROM next_weekly_report_doc)
                    )
                  ) AS tech_seq
                  FROM next_weekly_report_doc";
                $new_tech_report_seq_query2 = $this->db->query($new_tech_report_seq_sql2);
                $new_tech_report_seq2 = $new_tech_report_seq_query2->row();
                $new_tech_report_seq2 = $new_tech_report_seq2->tech_seq;

                $insert_lab_data = array(
                  'report_seq' => $new_report_seq,
                  'tech_seq' => $new_tech_report_seq2,
                  'schedule_seq' => $select_row_array2[$j]['seq'],
                  'contents_num' => $select_row_array2[$j]['contents_num'],
                  'group_name' => $select_row_array2[$j]['group'],
                  'year' => $year,
                  'month' => $month,
                  'week' => $week,
                  'writer' => $select_row_array2[$j]['participant'],
                  'income_time' => $select_row_array2[$j]['start_day'],
                  'insert_time' => date("Y-m-d H:i:s")
                );

                $val_arr = explode(',,,',$select_row_array2[$j]['contents']);
                $val_arr_length = count($val_arr);
                for($p = 0; $p < $val_arr_length; $p++){

                    $val_arr2 = explode(':::', $val_arr[$p]);
                    $val_arr_key = $val_arr2[0];
                    $val_arr_value = $val_arr2[1];

                    if($val_arr_key == 'dev_type'){
                      $lab_work_name = $val_arr_value;
                    }else if($val_arr_key == 'dev_page'){
                      $lab_customer = $val_arr_value;
                    }else if($val_arr_key == 'dev_requester'){
                      $lab_type = $val_arr_value;
                    }else if($val_arr_key == 'dev_develop'){
                      $lab_subject = $val_arr_value;
                    }else if($val_arr_key == 'dev_complete'){
                      $lab_completion_time = $select_row_array2[$j]['end_day'];
                    };
                };
                $insert_lab_data2 = array(
                  'type' => $lab_type, //요청자
                  'work_name' => $lab_work_name, //작업구분
                  'produce' => $select_row_array2[$j]['title'], //요청사항
                  'customer' => $lab_customer, //페이지
                  'subject' => $lab_subject, //개발사항
                  'completion_time' => $lab_completion_time //예정일자
                );
                $insert_data = array_merge($insert_lab_data, $insert_lab_data2);

              }else{ //기술연구소 외

                $new_tech_report_seq_sql2 = "SELECT DISTINCT(
                    IFNULL(
                      (SELECT DISTINCT(c.tech_seq) FROM next_weekly_report_doc c WHERE c.schedule_seq = {$select_row_array2[$j]['seq']}),
                      (SELECT MIN(tech_seq)-1 FROM next_weekly_report_doc)
                    )
                  ) AS tech_seq
                  FROM next_weekly_report_doc";
                $new_tech_report_seq_query2 = $this->db->query($new_tech_report_seq_sql2);
                $new_tech_report_seq2 = $new_tech_report_seq_query2->row();
                $new_tech_report_seq2 = $new_tech_report_seq2->tech_seq;

                $insert_data = array(
                  'report_seq' => $new_report_seq,
                  'tech_seq' => $new_tech_report_seq2,
                  'schedule_seq' => $select_row_array2[$j]['seq'],
                  'contents_num' => $select_row_array2[$j]['contents_num'],
                  'group_name' => $select_row_array2[$j]['group'],
                  'year' => $year,
                  'month' => $month,
                  'week' => $week,
                  'work_name' => $select_row_array2[$j]['work_name'],
                  'customer' => $select_row_array2[$j]['customer'],
                  'visit_company' => $select_row_array2[$j]['visit_company'],
                  'subject' => $select_row_array2[$j]['contents'],
                  'writer' => $select_row_array2[$j]['participant'],
                  'income_time' => $select_row_array2[$j]['start_day'],
                  'insert_time' => date("Y-m-d H:i:s")
                );

              }
              // $new_tech_report_seq2 = $new_tech_report_seq2 -1;
              $query = $this->db->insert('next_weekly_report_doc', $insert_data);
            }
          }else{
            $query = 'true';
          }

        }
        return $query;
    }


    function weekly_report_doc_modify($data, $mode,$group_name) {
        if ($mode == 1) {//modify
            $result = $this->db->update('weekly_report_doc', $data, array('seq' => $data['seq']));

            if($group_name == "기술본부"){ //기술본부의 작업구분 수정했을때 기술팀들에서도 수정되게
                $sql ="SELECT wrd.seq FROM weekly_report_doc AS wrd JOIN weekly_report AS wr ON wrd.report_seq = wr.seq WHERE wrd.tech_seq = (SELECT * FROM (SELECT wrd2.tech_seq FROM weekly_report_doc AS wrd2 WHERE wrd2.seq={$data['seq']}) AS t1) AND (wr.group_name = '기술1팀' OR wr.group_name = '기술2팀' OR wr.group_name = '기술1팀-2')";
                $query = $this->db->query($sql);
                if($query->num_rows() > 0){
                    $update_seq = $query->result_array();

                    for($i=0; $i<count($update_seq); $i++){
                        $sql2 = "UPDATE weekly_report_doc SET work_name = '{$data['work_name']}' WHERE seq ={$update_seq[$i]['seq']}";
                        $result = $this->db->query($sql2);
                    }
                }
            }else if($group_name == "기술1팀" || $group_name == "기술2팀" || $group_name == "기술1팀-2"){ //이 팀들에서 수정이 이뤄졌을때 tech_seq 같은 것들 수정
            // }else if($group_name == "기술1팀" || $group_name == "기술2팀" || $group_name == "사업1부" || $group_name == "사업2부"){ //이 팀들에서 수정이 이뤄졌을때 tech_seq 같은 것들 수정
                $sql ="SELECT wrd.seq FROM weekly_report_doc AS wrd JOIN weekly_report AS wr ON wrd.report_seq = wr.seq WHERE wrd.tech_seq = (SELECT * FROM (SELECT wrd2.tech_seq FROM weekly_report_doc wrd2 WHERE wrd2.seq={$data['seq']}) AS t1) AND wrd.seq != {$data['seq']}";
                $query = $this->db->query($sql);
                if($query->num_rows() > 0){
                    $update_seq = $query->result_array();

                    for($i=0; $i<count($update_seq); $i++){
                        $data['seq']= $update_seq[$i]['seq'];
                        $result = $this->db->update('weekly_report_doc', $data, array('seq' => $update_seq[$i]['seq']));
                    }
                }
            }

        } else if ($mode == 0) {//insert
            $result = $this->db->insert('weekly_report_doc', $data);
            // if($group_name != '기술연구소' || $group_name != '경영지원실'){
            // if($result && (($group_name != '기술연구소') || ($group_name != '경영지원실'))){
              //이건 insert 할때 tech_seq가 없으니깐 - 붙여서 젤 작은 수로 tech_seq 만들어주는고(기지보에서 작성된 내용은 tech_seq를 가져오지만 주업보에서 바로 작성된 것은 tech_seq를 못가져온다. 그렇지만 기술본부 주업보와 하위그룹 주업보를 연결시켜주는 고리가 tech_seq이기 때문에 null값이 있으면 안되기 때문에 마이너스 값으로 넣어준다.)
                // $sql ="update weekly_report_doc wrd set wrd.tech_seq =(SELECT MIN(wrd2.tech_seq)-1 as m1 from weekly_report_doc as wrd2) where wrd.seq = (SELECT wrd3.seq FROM weekly_report_doc as wrd3 ORDER BY wrd3.seq DESC LIMIT 1)";
                //같은 테이블을 서브쿼리로 사용할 때는 한번 더 ()로 싸줘야 한다.
                $sql ="UPDATE weekly_report_doc AS wrd SET wrd.tech_seq = (SELECT * FROM (SELECT MIN(wrd2.tech_seq)-1 AS m1 FROM weekly_report_doc AS wrd2)AS t) WHERE wrd.seq = (SELECT * FROM (SELECT wrd3.seq FROM weekly_report_doc AS wrd3 ORDER BY wrd3.seq DESC LIMIT 1) AS t2)";
                $result = $this->db->query($sql);
            // }

            if($group_name == '기술본부' || $group_name == '기술1팀' || $group_name == '기술2팀' || $group_name == "기술1팀-2"){
                $sql = "SELECT wr.seq,nwrd.group_name,nwrd.tech_seq FROM weekly_report wr JOIN (SELECT * FROM weekly_report_doc ORDER BY seq DESC LIMIT 1) nwrd
                ON wr.year = nwrd.year AND wr.month = nwrd.month AND wr.week = nwrd.week
                WHERE wr.group_name = '기술본부' AND nwrd.group_name <> '기술본부'";

                $query = $this->db->query($sql);

                if ($query->num_rows() <= 0) { //마지막 입력이 기술본부 내용일 때 해당 주 기술본부 주간업무보고에 중복 입력되지 않도록 제외
                    return $result;
                } else { //기술1팀, 기술2팀의 입력일 때 해당 주 기술본부 주간업무보고에 입력되게 하는 부분
                    $add_report = $query->row_array();
                    $sql1 = "insert into weekly_report_doc(report_seq,tech_seq,group_name,year,month,week,work_name,produce,customer,subject,result,writer,income_time,insert_time)
                    values ({$add_report['seq']},{$add_report['tech_seq']},'{$add_report['group_name']}','{$data['year']}','{$data['month']}','{$data['week']}','{$data['work_name']}','{$data['produce']}','{$data['customer']}','{$data['subject']}','{$data['result']}','{$data['writer']}','{$data['income_time']}',now())";
                    $result = $this->db->query($sql1);
                }
            }else if(($group_name == '영업본부') || ($group_name == '사업1부') || ($group_name == '사업2부')){
              $sql = "SELECT wr.seq,nwrd.group_name,nwrd.tech_seq from weekly_report wr JOIN (SELECT * FROM weekly_report_doc ORDER BY seq DESC LIMIT 1) nwrd
              ON wr.year = nwrd.year AND wr.month = nwrd.month AND wr.week = nwrd.week
              WHERE wr.group_name = '영업본부' AND nwrd.group_name <> '영업본부'";

              $query = $this->db->query($sql);

              if ($query->num_rows() <= 0) { //마지막 입력이 영업본부 내용일 때 해당 주 영업본부 주간업무보고에 중복 입력되지 않도록 제외
                  return $result;
              } else { //사업1부, 사업2부 입력일 때 해당 주 영업본부 주간업무보고에 입력되게 하는 부분
                  $add_report = $query->row_array();
                  $sql1 = "insert into weekly_report_doc(report_seq,tech_seq,group_name,year,month,week,customer,subject,writer,income_time,insert_time)
                  values ({$add_report['seq']},{$add_report['tech_seq']},'{$add_report['group_name']}','{$data['year']}','{$data['month']}','{$data['week']}','{$data['customer']}','{$data['subject']}','{$data['writer']}','{$data['income_time']}',now())";
                  $result = $this->db->query($sql1);
              }
            }
        }
        return $result;
    }


    function next_weekly_report_doc_modify($data, $mode, $group_name) {
        if ($mode == 1) { //modify
            // echo "<script>alert('{$data['update_time']}')</script>";
            $result=$this->db->update('next_weekly_report_doc', $data, array('seq' => $data['seq']));

            if((isset($data['work_name'])) && ($data['work_name'] == "정기점검" || $data['work_name'] == "정기점검2")){ // 유지보수 점검여부 예정으로 수정
                // echo "<script>alert('{$data['customer']}');</script>";
                // $sql = "update sales_maintain SET maintain_result = '9',maintain_date = '{$data['income_time']}' where progress_step > '014' and (sub_project_add not REGEXP seq or sub_project_add IS NULL) AND customer_companyname='{$data['customer']}' AND maintain_cycle != 7 AND maintain_result !=2 AND exception_saledate3 >= NOW()";
                $sql = "update sales_maintain SET maintain_result = '9',maintain_date = '{$data['income_time']}' where customer_companyname='{$data['customer']}' AND maintain_cycle != 7 AND maintain_result !=2 AND CURDATE() between exception_saledate2 AND exception_saledate3";

                $result = $this->db->query($sql);
            }

            if($group_name == "기술본부"){ //기술본부의 작업구분 수정했을때 기술팀들에서도 수정되게
                $sql ="select wrd.seq from next_weekly_report_doc as wrd join weekly_report as wr on wrd.report_seq = wr.seq where wrd.tech_seq = (select tech_seq from next_weekly_report_doc where seq={$data['seq']}) AND wr.group_name <> '기술본부'";
                $query = $this->db->query($sql);
                if($query->num_rows() > 0){
                    $update_seq = $query->result_array();

                    for($i=0; $i<count($update_seq); $i++){
                        $sql2 = "UPDATE next_weekly_report_doc SET work_name = '{$data['work_name']}',update_time = now() WHERE seq ={$update_seq[$i]['seq']}";
                        $result = $this->db->query($sql2);
                    }
                }
            }else if($group_name == "기술1팀" || $group_name == "기술2팀" || $group_name == "기술1팀-2"){ //이 팀들에서 수정이 이뤄졌을때 tech_seq 같은 것들 수정
                $sql ="select wrd.seq from next_weekly_report_doc as wrd join weekly_report as wr on wrd.report_seq = wr.seq where wrd.tech_seq = (select tech_seq from next_weekly_report_doc where seq={$data['seq']}) and wrd.seq != {$data['seq']}";

                $query = $this->db->query($sql);
                if($query->num_rows() > 0){
                    $update_seq = $query->result_array();

                    for($i=0; $i<count($update_seq); $i++){
                        $data['seq']= $update_seq[$i]['seq'];
                        $result = $this->db->update('next_weekly_report_doc', $data, array('seq' => $update_seq[$i]['seq']));
                    }
                }
            }
        } else if ($mode == 0) {//insert
            $result=$this->db->insert('next_weekly_report_doc', $data);

            // if($result && (($group_name != '기술연구소') || ($group_name != '경영지원실'))){
              //이건 insert 할때 tech_seq가 없으니깐 - 붙여서 젤 작은 수로 tech_seq 만들어주는거(기지보에서 작성된 내용은 tech_seq를 가져오지만 주업보에서 바로 작성된 것은 tech_seq를 못가져온다. 그렇지만 기술본부 주업보와 하위그룹 주업보를 연결시켜주는 고리가 tech_seq이기 때문에 null값이 있으면 안되기 때문에 마이너스 값으로 넣어준다.)
                $sql = "update next_weekly_report_doc set tech_seq =(SELECT m1 FROM (SELECT MIN(tech_seq)-1 as m1 from next_weekly_report_doc) AS t1) where seq =(select seq from (SELECT seq FROM next_weekly_report_doc ORDER BY seq DESC LIMIT 1) as t2)";
                $result = $this->db->query($sql);
            // }

            if(isset($data['work_name']) && ($data['work_name'] == "정기점검" || $data['work_name'] == "정기점검2")){ // 유지보수 점검여부 예정으로 수정
                $sql = "update sales_maintain SET maintain_result = '9',maintain_date = '{$data['income_time']}' where progress_step > '014' and (sub_project_add not REGEXP seq or sub_project_add IS NULL) AND customer_companyname='{$data['customer']}' AND maintain_cycle != 7 AND maintain_result !=2 AND exception_saledate3 >= CURDATE()";
                $result = $this->db->query($sql);
            }

            if(($group_name == '기술본부') || ($group_name == '기술1팀') || ($group_name == '기술2팀') || ($group_name == '기술1팀-2')){
                $sql = "SELECT wr.seq,nwrd.group_name,nwrd.tech_seq from weekly_report wr JOIN (SELECT * FROM next_weekly_report_doc ORDER BY seq DESC LIMIT 1) nwrd
                ON wr.year = nwrd.year AND wr.month = nwrd.month AND wr.week = nwrd.week
                WHERE wr.group_name = '기술본부' AND nwrd.group_name <> '기술본부'";

                $query = $this->db->query($sql);

                if ($query->num_rows() <= 0) { //마지막 입력이 기술본부 내용일 때 차주 주 기술본부 주간업무보고에 중복 입력되지 않도록 제외
                    return $result;
                } else { //기술1팀, 기술2팀의 입력일 때 차주 주 기술본부 주간업무보고에 입력되게 하는 부분
                    $add_report = $query->row_array();
                    $sql1 = "insert into next_weekly_report_doc(report_seq,tech_seq,group_name,year,month,week,work_name,produce,customer,subject,preparations,writer,income_time,insert_time)
                    values ({$add_report['seq']},{$add_report['tech_seq']},'{$add_report['group_name']}','{$data['year']}','{$data['month']}','{$data['week']}','{$data['work_name']}','{$data['produce']}','{$data['customer']}','{$data['subject']}','{$data['preparations']}','{$data['writer']}','{$data['income_time']}',now())";
                    $result = $this->db->query($sql1);
                }
            }else if(($group_name == '영업본부') || ($group_name == '사업1부') || ($group_name == '사업2부')){
                $sql = "SELECT wr.seq,nwrd.group_name,nwrd.tech_seq from weekly_report wr JOIN (SELECT * FROM next_weekly_report_doc ORDER BY seq DESC LIMIT 1) nwrd
                ON wr.year = nwrd.year AND wr.month = nwrd.month AND wr.week = nwrd.week
                WHERE wr.group_name = '영업본부' AND nwrd.group_name <> '영업본부'";

                $query = $this->db->query($sql);

                if ($query->num_rows() <= 0) { //마지막 입력이 영업본부 내용일 때 차주 영업본부 주간업무보고에 중복 입력되지 않도록 제외
                    return $result;
                } else { //사업1부, 사업2부 입력일 때 차주 영업본부 주간업무보고에 입력되게 하는 부분
                    $add_report = $query->row_array();
                    $sql1 = "insert into next_weekly_report_doc(report_seq,tech_seq,group_name,year,month,week,customer,subject,writer,income_time,insert_time)
                    values ({$add_report['seq']},{$add_report['tech_seq']},'{$add_report['group_name']}','{$data['year']}','{$data['month']}','{$data['week']}','{$data['customer']}','{$data['subject']}','{$data['writer']}','{$data['income_time']}',now())";
                    $result = $this->db->query($sql1);
                }
            }
        }
        return $result;
    }

    //주간업무보고 코멘트 update
    function weekly_report_comment_modify($seq,$comment){
        $sql = "update weekly_report set comment='{$comment}' where seq = {$seq}";
        return $this->db->query($sql);
    }

    //금주,차주 doc delete
    function weekly_report_doc_delete($seq,$type,$group_name){
        if($group_name == "기술연구소" || $group_name == "경영지원실"){
            if($type == "current"){
                $sql = "delete from weekly_report_doc where seq = {$seq}";
                if( $group_name == "경영지원실"){
                  $find_sch_seq_sql = "SELECT schedule_seq FROM weekly_report_doc where seq = {$seq}";
                  $find_sch_seq_query = $this->db->query($find_sch_seq_sql)->row();
                  $sch_seq = $find_sch_seq_query->schedule_seq;

                  $find_contents_num_sql = "SELECT contents_num FROM weekly_report_doc where seq = {$seq}";
                  $find_contents_num_query = $this->db->query($find_contents_num_sql)->row();
                  $contents_num = $find_contents_num_query->contents_num;
// 내용분할
                  $sch_sql = "UPDATE tech_schedule_contents set weekly_report = 'N' WHERE schedule_seq = '{$sch_seq}' AND contents_num = '{$contents_num}'";
                  // $sch_sql = "UPDATE tech_schedule_list set weekly_report = 'N' WHERE seq = '{$sch_seq}'";
                  $this->db->query($sch_sql);
                }
            }else{
                $sql = "delete from next_weekly_report_doc where seq = {$seq}";
                // $sql2 = "delete from tech_schedule_list where seq =(select nwrd.schedule_seq from (SELECT schedule_seq from next_weekly_report_doc where seq = {$seq}) as nwrd)";
            }
        }else{
            if($group_name == "기술본부"){ //기술본부 삭제 반영안되게
            // if($group_name == "기술본부" || $group_name == "영업본부"){ //기술본부 삭제 반영안되게
                if($type == "current"){
                    $sql = "delete from weekly_report_doc where seq ={$seq}";
                }else{
                    $sql = "delete from next_weekly_report_doc where seq ={$seq}";
                    // $sql2 = "delete from tech_schedule_list where seq =(select nwrd.schedule_seq from (SELECT schedule_seq from next_weekly_report_doc where seq = {$seq}) as nwrd)";

                }
            }else{
                if($type == "current"){
                    $sql = "delete from weekly_report_doc where tech_seq =(select wrd.tech_seq from (SELECT tech_seq from weekly_report_doc where seq = {$seq}) as wrd)";

                    $find_sch_seq_sql = "SELECT schedule_seq FROM weekly_report_doc where seq = {$seq}";
                    $find_sch_seq_query = $this->db->query($find_sch_seq_sql)->row();
                    $sch_seq = $find_sch_seq_query->schedule_seq;

                    $find_contents_num_sql = "SELECT contents_num FROM weekly_report_doc where seq = {$seq}";
                    $find_contents_num_query = $this->db->query($find_contents_num_sql)->row();
                    $contents_num = $find_contents_num_query->contents_num;
//내용분할
                    $sch_sql = "UPDATE tech_schedule_contents set weekly_report = 'N' WHERE schedule_seq = '{$sch_seq}' AND contents_num = '{$contents_num}'";
                    // $sch_sql = "UPDATE tech_schedule_list set weekly_report = 'N' WHERE seq = '{$sch_seq}'";
                    $this->db->query($sch_sql);

                }else{
                    $sql = "delete from next_weekly_report_doc where tech_seq =(select nwrd.tech_seq from (SELECT tech_seq from next_weekly_report_doc where seq = {$seq}) as nwrd)";
                    // $sql2 = "delete from tech_schedule_list where seq =(select nwrd.schedule_seq from (SELECT schedule_seq from next_weekly_report_doc where seq = {$seq}) as nwrd)";
                }
            }
        }
        // if(isset($sql2)){
        //   $this->db->query($sql2);
        // }
        $this->db->query($sql);
    }

    //주간업무보고 삭제
    function weekly_report_delete( $seq ) {
        $sql = "delete from weekly_report where seq = {$seq}";
        $query = $this->db->query( $sql );
        $sql = "delete from weekly_report_doc where report_seq = {$seq}";
        $query = $this->db->query( $sql );
        $sql = "delete from next_weekly_report_doc where report_seq = {$seq}";
        $query = $this->db->query( $sql );

        return  $query;
    }

    //상위 그룹에 맞는 하위그룹 가져오기
    function childGroup($parentGroup){
        $sql = "select * from user_group where parentGroupName='{$parentGroup}' and groupName<>'{$parentGroup}'";
        $query = $this->db->query( $sql );

        if ($query->num_rows() <= 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }

    //기술지원부 그룹 가져오기
    //->수정: ceo와 영업본부를 제외한 그룹 가져오기
    function techGroup(){
        $sql = "SELECT * FROM user_group a INNER JOIN (SELECT DISTINCT user_group FROM user) b ON b.user_group = a.groupName WHERE a.groupName <> 'CEO' AND a.groupName <> '영업본부' ORDER BY a.parentGroupName";
        // SELECT * FROM user_group a INNER JOIN (SELECT * FROM user GROUP BY user_group HAVING user_group != 'CEO') b ON b.user_group = a.groupName ORDER BY a.seq
        // $sql = "select * from user_group where parentGroupName='기술본부' order by seq;";
        $query = $this->db->query( $sql );

        if ($query->num_rows() <= 0) {
            return false;
        } else {
            return $query->result_array();
        }
    }


    //작업명 가져오기
    function work_name_config(){
        $sql = "select * from work_name_config";
        $query = $this->db->query( $sql );

        if ($query->num_rows() <= 0) {
            return false;
        } else {
            return $query->result_array();
        }

    }

    //고객사 가져와
    function get_customer(){
        //첫번째 $sql = "select seq as forcasting_seq, customer_companyname as customer FROM sales_forcasting  GROUP BY customer order by binary(customer)";
        //두번째 $sql = "select seq as maintain_seq, customer_companyname as customer FROM sales_maintain  GROUP BY customer order by binary(customer)";
        $sql = "(SELECT sf.customer
                FROM (SELECT null AS maintain_seq, sf2.seq as forcasting_seq, sf2.customer_companyname as customer, sf2.customer_username, sf2.exception_saledate2 as maintain_start, sf2.exception_saledate3 as maintain_end , sf2.project_name from sales_forcasting sf2
                WHERE sf2.progress_step >= 015 AND warranty_end_date >= CURDATE()
                ORDER BY BINARY(customer_companyname)) sf
                left JOIN
                (SELECT sm2.seq AS maintain_seq2, sm2.forcasting_seq AS forcasting_seq2, sm2.customer_companyname AS customer2, sm2.customer_username AS customer_username2, sm2.exception_saledate2 AS maintain_start2, sm2.exception_saledate3 AS maintain_end2, sm2.project_name AS project_name2
                FROM sales_maintain sm2 WHERE CURDATE() BETWEEN sm2.exception_saledate2 AND sm2.exception_saledate3 order by binary(customer_companyname)) sm
                ON sf.forcasting_seq = sm.forcasting_seq2
                WHERE sm.maintain_seq2 IS NULL)
                UNION
                (SELECT customer_companyname AS customer
                FROM sales_maintain
                WHERE CURDATE() BETWEEN exception_saledate2 AND exception_saledate3
                ORDER BY BINARY(customer_companyname))
                UNION
                (SELECT customer_companyname AS customer
                FROM sales_forcasting GROUP BY customer order by binary(customer)
                )ORDER BY BINARY(customer)";
        $query = $this->db->query($sql);
		return $query->result_array();
    }

    //정기점검 일때 고객사
    //고객사 가져와
    function maintain_customer(){
        // $sql = "select seq as forcasting_seq, customer_companyname as customer FROM sales_forcasting  GROUP BY customer order by binary(customer)";
        $sql = "select t1.seq as maintain_seq,t1.forcasting_seq ,t1. customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_maintain AS t1,(select max(seq) as max_sort,forcasting_seq from sales_maintain WHERE CURDATE() between exception_saledate2 AND exception_saledate3 group by forcasting_seq) as t2
		where t1.seq = t2.max_sort order by binary(customer_companyname)";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    //차주 일정 불러 올게요 위클리 모델
    // function update_next_schedule($s_date, $e_date, $year, $month, $week, $writer, $insert_time, $group){
    //   $sql1 = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'weekly_report' AND table_schema = DATABASE( )";
    //   $query = $this->db->query($sql1)->row();
    //   $report_seq = $query->AUTO_INCREMENT-1;
    //   $next_s =  date("Y-m-d", strtotime($s_date." +7day"));
    //   $next_e =  date("Y-m-d", strtotime($e_date." +7day"));
    //
    //   // $sql2 = "UPDATE next_weekly_report_doc SET report_seq = $report_seq, year=$year, month=$month, week=$week, insert_time = '{$insert_time}' WHERE group_name = '{$group}' AND income_time BETWEEN '{$next_s}' AND '{$next_e}' AND report_seq IS NULL";
    //
    //
    //   $sql2= "UPDATE next_weekly_report_doc AS a, (SELECT * FROM next_weekly_report_doc WHERE income_time BETWEEN '{$next_s}' AND '{$next_e}' AND group_name = '{$group}' AND report_seq IS NULL GROUP BY schedule_seq) AS b SET a.report_seq = $report_seq, a.year=$year, a.month=$month, a.week=$week, a.insert_time = '{$insert_time}' WHERE a.seq = b.seq";
    //   $query = $this->db->query($sql2);
    //
    // }

    // 주간업무 gmp_test
    function schedule_list_insert($group,$year,$month,$week,$s_date,$e_date){

      $sql1 = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'weekly_report' AND table_schema = DATABASE( )";
      $query = $this->db->query($sql1)->row();
      $report_seq = $query->AUTO_INCREMENT-1;
      $next_s =  date("Y-m-d", strtotime($s_date." +7day"));
      $next_e =  date("Y-m-d", strtotime($e_date." +7day"));
      $next_s_date = $next_s." 00:00:00";
      $next_e_date = $next_e." 23:59:59";
      $sql2 = "SELECT MIN(tech_seq) as m1 from next_weekly_report_doc";
      $query = $this->db->query($sql2)->row();
      $tech_seq = $query->m1;
      $sql = "SELECT seq, work_name, customer, visit_company, participant, start_day FROM tech_schedule_list where start_day BETWEEN '{$next_s_date}' AND '{$next_e_date}' AND work_type = 'tech' and participant REGEXP (SELECT replace(GROUP_CONCAT(user_name),',','|') AS NAME FROM user WHERE user_group = '{$group}')";
      $query = $this->db->query($sql);

      $check_sql = "select * from weekly_report where year='{$year}' and month='{$month}' and week='{$week}' and group_name='기술본부'";
      $check_query = $this->db->query( $check_sql );
      $check_count = $check_query->num_rows();

      if ($query->num_rows() > 0 && $check_count == 0){
        $schedule = $query->result();
        foreach ($schedule as $sch) {
          // $dupl = "SELECT COUNT(*) FROM next_weekly_report_doc WHERE report_seq = {$report_seq} GROUP BY schedule_seq HAVING COUNT(*) > 1";
          $schedule_seq = $sch->seq;
          $dupl = "SELECT seq FROM next_weekly_report_doc WHERE report_seq = {$report_seq} AND schedule_seq = {$schedule_seq}";
          $query = $this->db->query($dupl);
          $count = $query->num_rows();
          if ($count == 0){
            $tech_seq--;
            $insert = array(
              'report_seq'=>$report_seq,
              'tech_seq'=> $tech_seq,
              'schedule_seq' => $schedule_seq,
              'group_name'=>$group,
              'year'=>$year,
              'month'=>$month,
              'week'=>$week,
              'work_name'=>$sch->work_name,
              'customer'=>$sch->customer,
              'visit_company'=>$sch->visit_company,
              'writer'=>$sch->participant,
              'income_time'=>$sch->start_day
            );
            $this->db->insert('next_weekly_report_doc', $insert);

          }

        }
      }
      if ($query->num_rows() > 0 && $check_count > 0){
        $schedule = $query->result();
        $head_seq = $check_query->row()->seq;
        foreach ($schedule as $sch) {
          // $dupl = "SELECT COUNT(*) FROM next_weekly_report_doc WHERE report_seq = {$report_seq} GROUP BY schedule_seq HAVING COUNT(*) > 1";
          $schedule_seq = $sch->seq;
          $dupl = "SELECT seq FROM next_weekly_report_doc WHERE report_seq = {$report_seq} AND schedule_seq = {$schedule_seq}";
          $query = $this->db->query($dupl);
          $count = $query->num_rows();
          if ($count == 0){
            $tech_seq--;
            $insert = array(
              'report_seq'=>$report_seq,
              'tech_seq'=> $tech_seq,
              'schedule_seq' => $schedule_seq,
              'group_name'=>$group,
              'year'=>$year,
              'month'=>$month,
              'week'=>$week,
              'work_name'=>$sch->work_name,
              'customer'=>$sch->customer,
              'visit_company'=>$sch->visit_company,
              'writer'=>$sch->participant,
              'income_time'=>$sch->start_day
            );

            $this->db->insert('next_weekly_report_doc', $insert);
          }
          $dupl = "SELECT seq FROM next_weekly_report_doc WHERE report_seq = {$head_seq} AND schedule_seq = {$schedule_seq}";
          $query = $this->db->query($dupl);
          $count = $query->num_rows();
          if ($count == 0){
            $insert = array(
              'report_seq'=>$head_seq,
              'tech_seq'=> $tech_seq,
              'schedule_seq' => $schedule_seq,
              'group_name'=>$group,
              'year'=>$year,
              'month'=>$month,
              'week'=>$week,
              'work_name'=>$sch->work_name,
              'customer'=>$sch->customer,
              'visit_company'=>$sch->visit_company,
              'writer'=>$sch->participant,
              'income_time'=>$sch->start_day
            );

            $this->db->insert('next_weekly_report_doc', $insert);
          }


        }
      }


      if($group=='기술본부'){
        $sql = "DELETE n1 FROM next_weekly_report_doc as n1, next_weekly_report_doc as n2 WHERE n1.report_seq = {$report_seq} AND n2.report_seq = {$report_seq} and n1.seq > n2.seq AND n1.schedule_seq = n2.schedule_seq";
        $query = $this->db->query($sql);
    }
    }


    function report_approval($data){
		$result = $this->db->update('weekly_report',$data,array('seq' => $data['seq']));
		return $result;
	}

    function report_file_attach($data) {
      $result = $this->db->update('weekly_report', $data, array('seq' => $data['seq']));

      return $result;
    }

    // function change_sch_report_N_action($seq){
    //   $find_sch_seq_sql = "SELECT schedule_seq FROM weekly_report_doc where seq = {$seq}";
    //   $find_sch_seq_query = $this->db->query($find_sch_seq_sql)->row();
    //   $sch_seq = $find_sch_seq_query->schedule_seq;
    //
    //   $sql = "UPDATE tech_schedule_list set weekly_report = 'N' WHERE seq = '{$sch_seq}'";
    //   $this->db->query($sql);
    // }



}
?>
