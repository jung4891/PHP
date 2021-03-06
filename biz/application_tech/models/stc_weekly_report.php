<?php
header("Content-type: text/html; charset=utf-8");

class STC_weekly_report extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->user_id = $this->phpsession->get( 'id', 'stc' );
    }

    function weekly_report_insert($data) {
        $check_sql = "SELECT * FROM weekly_report WHERE year ='{$data['year']}' and month ='{$data['month']}' AND week ='{$data['week']}' AND group_name ='{$data['group_name']}'";
        $query = $this->db->query( $check_sql );

        if ($query->num_rows() <= 0){
            return $this->db->insert('weekly_report', $data );
        }else{
            return false;
        }
    }

    function weekly_report_list( $searchkeyword,$search_keyword2, $search1, $start_limit = 0, $offset = 0) {
        $keyword = $searchkeyword;
        $tmp="";

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

        $sql = "select * from weekly_report".$searchstring." order by seq desc"; //  수정포인트

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

        $sql = "select count(seq) as ucount from weekly_report".$searchstring." order by seq desc"; //  수정포인트

        if  ( $searchkeyword != "" )
            $query = $this->db->query( $sql);
        else
            $query = $this->db->query( $sql );

        return $query->row();
    }

    //주간업무보고
    function weekly_report_view( $seq  ) {
        $sql = "select * from weekly_report where seq = ?";
        $query = $this->db->query( $sql, $seq );

        if ($query->num_rows() <= 0) {
                return false;
        } else {
                return $query->row_array() ;
        }
    }

    //주간업무보고 금주
    function weekly_report_doc_view($seq){
        $sql = "select * from weekly_report_doc where report_seq in ({$seq}) order by FIELD(work_name,'납품설치','설치지원','기술지원','장애지원','정기점검','정기점검2','데모(BMT)지원','미팅','교육지원','교육참석'), income_time";

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
            $sql = "select t1.work_name,t2.cnt from work_name_config as t1 left join (select work_name, count(*) as cnt from next_weekly_report_doc WHERE report_seq IN ({$seq}) group by work_name) as t2  on  t1.work_name=t2.work_name order by t1.value;";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() <= 0) {
                return false;
        } else {
                return $query->result_array() ;
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
            SELECT (select seq from weekly_report order by seq desc limit 1) AS report_seq ,tech_seq AS tech_seq,
            group_name AS group_name ,
            work_name AS work_name ,
            produce AS produce,
            year AS year,
            month AS month ,
            week AS week,
            type AS type,
            customer AS customer,
            subject AS subject ,
            result AS result,
            writer AS writer,
            income_time AS income_time,
            NOW() AS insert_time
            FROM weekly_report_doc WHERE YEAR =? and MONTH=? and WEEK=? AND group_name <> '기술연구소' group BY tech_seq order by seq;";

            $query = $this->db->query($sql1,array($year,$month,$week));

            $sql2 = "insert into next_weekly_report_doc (report_seq,tech_seq,schedule_seq,group_name,work_name,produce,year,month,week,type,customer,subject,preparations,writer,income_time,insert_time)
            SELECT (select seq from weekly_report order by seq desc limit 1) AS report_seq ,tech_seq AS tech_seq, schedule_seq As schedule_seq,
            group_name AS group_name ,
            work_name AS work_name ,
            produce AS produce,
            year AS year,
            month AS month ,
            week AS week,
            type AS type,
            customer AS customer,
            subject AS subject ,
            preparations AS preparations ,
            writer AS writer,
            income_time AS income_time,
            NOW() AS insert_time
            FROM next_weekly_report_doc WHERE YEAR =? and MONTH=? and WEEK=? AND group_name <> '기술연구소' group BY tech_seq order by seq;";
            $query = $this->db->query($sql2,array($year,$month,$week));

            // $sql = "insert into weekly_report_doc (report_seq,tech_seq,group_name,work_name,produce,year,month,week,type,customer,subject,writer,income_time,insert_time)
            // select (select seq from weekly_report order by seq desc limit 1) as report_seq,tech.seq, ? as group_name ,tech.work_name, tech.produce, ? as year, ? as month , ? as week , '0' as type, tech.customer, tech.subject, tech.engineer, tech.income_time ,sysdate() as insert_time
            // from tech_doc_basic AS tech where income_time >= ? and income_time <= ? AND engineer REGEXP (SELECT replace(GROUP_CONCAT(user_name),',','|') AS NAME FROM user WHERE user_group=?) and engineer not like '%,%'  order by income_time DESC";

            $doc_cnt_sql = "SELECT COUNT(*) as cnt FROM tech_doc_basic where income_time >= '{$tmp_s_date}' and income_time <= '{$tmp_e_date}' AND engineer REGEXP (SELECT replace(GROUP_CONCAT(user_name),',','|') AS NAME FROM user WHERE user_group = '{$group}') and engineer not like '%,%' order by income_time DESC";
            $doc_cnt_query = $this->db->query( $doc_cnt_sql );
            $doc_cnt = $doc_cnt_query->row_array();

            $sql ="call insert_weekly_report_doc({$doc_cnt['cnt']},'{$group}','{$tmp_s_date}','{$tmp_e_date}',{$year},{$month},{$week},{$report_seq['seq']},2)";
            $query = $this->db->query($sql);


        }else{
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
                // $sql2 = "insert into weekly_report_doc (report_seq,tech_seq,group_name,work_name,produce,year,month,week,type,customer,subject,writer,income_time,insert_time)
                // select {$weekly_report_tech['seq']} as report_seq,tech.seq, ? as group_name ,tech.work_name, tech.produce, ? as year, ? as month , ? as week , '0' as type, tech.customer, tech.subject, tech.engineer, tech.income_time,sysdate() as insert_time
                // from tech_doc_basic AS tech where income_time >= ? and income_time <= ? AND engineer REGEXP (SELECT replace(GROUP_CONCAT(user_name),',','|') AS NAME FROM user WHERE user_group=?)
                // AND (SELECT COUNT(*) from weekly_report_doc WHERE tech_seq = tech.seq and report_seq = {$weekly_report_tech['seq']}) = 0
                // order by income_time DESC";
                $sql2 ="call insert_weekly_report_doc({$doc_cnt['cnt']},'{$group}','{$tmp_s_date}','{$tmp_e_date}',{$year},{$month},{$week},{$weekly_report_tech['seq']},2)";
                $query = $this->db->query($sql2);
            }
        }
        return $query;
    }


    function weekly_report_doc_modify($data, $mode,$group_name) {
        if ($mode == 1) {//modify
            $result = $this->db->update('weekly_report_doc', $data, array('seq' => $data['seq']));

            if($group_name == "기술본부"){ //기술본부의 작업구분 수정했을때 기술팀들에서도 수정되게
                $sql ="select wrd.seq from weekly_report_doc as wrd join weekly_report as wr on wrd.report_seq = wr.seq where wrd.tech_seq = (select tech_seq from weekly_report_doc where seq={$data['seq']}) AND wr.group_name <> '기술본부'";
                $query = $this->db->query($sql);
                if($query->num_rows() > 0){
                    $update_seq = $query->result_array();

                    for($i=0; $i<count($update_seq); $i++){
                        $sql2 = "UPDATE weekly_report_doc SET work_name = '{$data['work_name']}' WHERE seq ={$update_seq[$i]['seq']}";
                        $result = $this->db->query($sql2);
                    }
                }
            }else if($group_name == "기술1팀" || $group_name == "기술2팀"){ //이 팀들에서 수정이 이뤄졌을때 tech_seq 같은 것들 수정
                $sql ="select wrd.seq from weekly_report_doc as wrd join weekly_report as wr on wrd.report_seq = wr.seq where wrd.tech_seq = (select tech_seq from weekly_report_doc where seq={$data['seq']}) and wrd.seq != {$data['seq']}";
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
            if($result){//이건 insert 할때 tech_seq가 없으니깐 - 붙여서 젤 작은 수로 tech_seq 만들어주는고
                $sql ="update weekly_report_doc set tech_seq =(SELECT m1 FROM (SELECT MIN(tech_seq)-1 as m1 from weekly_report_doc) AS t1) where seq =(select seq from (SELECT seq FROM weekly_report_doc ORDER BY seq DESC LIMIT 1) as t2)";
                $result = $this->db->query($sql);
            }

            if($group_name != '기술연구소'){
                $sql = "SELECT wr.seq,nwrd.group_name,nwrd.tech_seq from weekly_report wr JOIN (SELECT * FROM weekly_report_doc ORDER BY seq DESC LIMIT 1) nwrd
                ON wr.year = nwrd.year AND wr.month = nwrd.month AND wr.week = nwrd.week
                WHERE wr.group_name = '기술본부' AND nwrd.group_name <> '기술본부'";

                $query = $this->db->query($sql);

                if ($query->num_rows() <= 0) {
                    return $result;
                } else {
                    $add_report = $query->row_array();
                    $sql1 = "insert into weekly_report_doc(report_seq,tech_seq,group_name,year,month,week,work_name,produce,customer,subject,result,writer,income_time,insert_time)
                    values ({$add_report['seq']},{$add_report['tech_seq']},'{$add_report['group_name']}','{$data['year']}','{$data['month']}','{$data['week']}','{$data['work_name']}','{$data['produce']}','{$data['customer']}','{$data['subject']}','{$data['result']}','{$data['writer']}','{$data['income_time']}',now())";
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

            if($data['work_name'] == "정기점검" || $data['work_name'] == "정기점검2"){ // 유지보수 점검여부 예정으로 수정
                // echo "<script>alert('{$data['customer']}');</script>";
                // $sql = "update sales_maintain SET maintain_result = '9',maintain_date = '{$data['income_time']}' where progress_step > '014' and (sub_project_add not REGEXP seq or sub_project_add IS NULL) AND customer_companyname='{$data['customer']}' AND maintain_cycle != 7 AND maintain_result !=2 AND exception_saledate3 >= NOW()";
                $sql = "update sales_maintain SET maintain_result = '9',maintain_date = '{$data['income_time']}' where customer_companyname='{$data['customer']}' AND maintain_cycle != 7 AND maintain_result !=2 AND NOW() between exception_saledate2 AND exception_saledate3";
                
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
            }else if($group_name == "기술1팀" || $group_name == "기술2팀"){ //이 팀들에서 수정이 이뤄졌을때 tech_seq 같은 것들 수정
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

            if($result){//이건 insert 할때 tech_seq가 없으니깐 - 붙여서 젤 작은 수로 tech_seq 만들어주는고
                $sql = "update next_weekly_report_doc set tech_seq =(SELECT m1 FROM (SELECT MIN(tech_seq)-1 as m1 from next_weekly_report_doc) AS t1) where seq =(select seq from (SELECT seq FROM next_weekly_report_doc ORDER BY seq DESC LIMIT 1) as t2)";
                $result = $this->db->query($sql);
            }

            if($data['work_name'] == "정기점검" || $data['work_name'] == "정기점검2"){ // 유지보수 점검여부 예정으로 수정
                $sql = "update sales_maintain SET maintain_result = '9',maintain_date = '{$data['income_time']}' where progress_step > '014' and (sub_project_add not REGEXP seq or sub_project_add IS NULL) AND customer_companyname='{$data['customer']}' AND maintain_cycle != 7 AND maintain_result !=2 AND exception_saledate3 >= NOW()";
                $result = $this->db->query($sql);
            }

            if($group_name  != '기술연구소'){
                $sql = "SELECT wr.seq,nwrd.group_name,nwrd.tech_seq from weekly_report wr JOIN (SELECT * FROM next_weekly_report_doc ORDER BY seq DESC LIMIT 1) nwrd
                ON wr.year = nwrd.year AND wr.month = nwrd.month AND wr.week = nwrd.week
                WHERE wr.group_name = '기술본부' AND nwrd.group_name <> '기술본부'";

                $query = $this->db->query($sql);

                if ($query->num_rows() <= 0) {
                    return $result;
                } else {
                    $add_report = $query->row_array();
                    $sql1 = "insert into next_weekly_report_doc(report_seq,tech_seq,group_name,year,month,week,work_name,produce,customer,subject,preparations,writer,income_time,insert_time)
                    values ({$add_report['seq']},{$add_report['tech_seq']},'{$add_report['group_name']}','{$data['year']}','{$data['month']}','{$data['week']}','{$data['work_name']}','{$data['produce']}','{$data['customer']}','{$data['subject']}','{$data['preparations']}','{$data['writer']}','{$data['income_time']}',now())";
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
        if($group_name == "기술연구소"){
            if($type == "current"){
                $sql = "delete from weekly_report_doc where seq = {$seq}";
            }else{
                $sql = "delete from next_weekly_report_doc where seq = {$seq}";
                $sql2 = "delete from tech_schedule_list where seq =(select nwrd.schedule_seq from (SELECT schedule_seq from next_weekly_report_doc where seq = {$seq}) as nwrd)";
            }
        }else{
            if($group_name == "기술본부"){ //기술본부 삭제 반영안되게
                if($type == "current"){
                    $sql = "delete from weekly_report_doc where seq ={$seq}";
                }else{
                    $sql = "delete from next_weekly_report_doc where seq ={$seq}";
                    $sql2 = "delete from tech_schedule_list where seq =(select nwrd.schedule_seq from (SELECT schedule_seq from next_weekly_report_doc where seq = {$seq}) as nwrd)";

                }
            }else{
                if($type == "current"){
                    $sql = "delete from weekly_report_doc where tech_seq =(select wrd.tech_seq from (SELECT tech_seq from weekly_report_doc where seq = {$seq}) as wrd)";
                }else{
                    $sql = "delete from next_weekly_report_doc where tech_seq =(select nwrd.tech_seq from (SELECT tech_seq from next_weekly_report_doc where seq = {$seq}) as nwrd)";
                    $sql2 = "delete from tech_schedule_list where seq =(select nwrd.schedule_seq from (SELECT schedule_seq from next_weekly_report_doc where seq = {$seq}) as nwrd)";
                }
            }
        }
        if(isset($sql2)){
          $this->db->query($sql2);
        }
        $this->db->query($sql);
    }

    //주간보고업무 삭제
    function weekly_report_delete( $seq ) {
        $sql = "delete from weekly_report where seq = ?";
        $query = $this->db->query( $sql, $seq );
        $sql = "delete from weekly_report_doc where report_seq = ?";
        $query = $this->db->query( $sql, $seq );
        $sql = "delete from next_weekly_report_doc where report_seq = ?";
        $query = $this->db->query( $sql, $seq );

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
    function techGroup(){
        $sql = "select * from user_group where parentGroupName='기술본부' order by seq;";
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
        // $sql = "select seq as forcasting_seq, customer_companyname as customer FROM sales_forcasting  GROUP BY customer order by binary(customer)";
        $sql = "select seq as maintain_seq, customer_companyname as customer FROM sales_maintain  GROUP BY customer order by binary(customer)";
        $query = $this->db->query($sql);
		return $query->result_array();
    }

    //정기점검 일때 고객사
    //고객사 가져와
    function maintain_customer(){
        // $sql = "select seq as forcasting_seq, customer_companyname as customer FROM sales_forcasting  GROUP BY customer order by binary(customer)";
        $sql = "select t1.seq as maintain_seq,t1.forcasting_seq ,t1. customer_companyname as customer,t1.customer_username, t1.exception_saledate2 as maintain_start, t1.exception_saledate3 as maintain_end , t1.project_name from sales_maintain AS t1,(select max(seq) as max_sort,forcasting_seq from sales_maintain WHERE NOW() between exception_saledate2 AND exception_saledate3 group by forcasting_seq) as t2 
		where t1.seq = t2.max_sort order by binary(customer_companyname)";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    //차주 일정 불러 올게요 위클리 모델
    function update_next_schedule($s_date, $e_date, $year, $month, $week, $writer, $insert_time){
      $sql1 = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'weekly_report' AND table_schema = DATABASE( )";
      $query = $this->db->query($sql1)->row();
      $report_seq = $query->AUTO_INCREMENT-1;
      $next_s =  date("Y-m-d", strtotime($s_date." +7day"));
      $next_e =  date("Y-m-d", strtotime($e_date." +7day"));
      $sql2 = "UPDATE next_weekly_report_doc SET report_seq = $report_seq, year=$year, month=$month, week=$week, insert_time = '{$insert_time}' WHERE linker = '{$writer}' AND income_time BETWEEN '{$next_s}' AND '{$next_e}' AND report_seq IS NULL";

      $query = $this->db->query($sql2);

    }

}
?>
