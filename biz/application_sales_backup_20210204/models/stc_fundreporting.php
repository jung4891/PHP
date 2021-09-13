<?php
  class STC_Fundreporting extends CI_Model {
    function __construct(){
      parent::__construct();
    }

    public function count($company){
      $sql = "SELECT COUNT(*) as cnt FROM fund_list where company = '{$company}'";

      $row = $this->db->query($sql);

      $result = $row->row_array();

      return $result['cnt'];
    }



    public function bankbook($company){
     return $this->db->query("select a.* from (select a.idx, a.type, a.bank, a.banktype, a.account, a.breakdown,
      b.yesbalance, b.todaydeposit, b.todaywithdraw, b.balance from fund_bankbook a
      left join (select a.banktype, ifnull(a.balance,0)-ifnull(b.todaydeposit,0)+ifnull(b.todaywithdraw,0) as yesbalance,
      ifnull(b.todaydeposit,0) as todaydeposit, ifnull(b.todaywithdraw,0) as todaywithdraw,
      a.balance from (select banktype, IFNULL(SUM(deposit),0) - IFNULL(SUM(withdraw),0) as balance
      from fund_list where banktype is not null and company = '{$company}' group BY banktype) a
      left join (SELECT banktype, IFNULL(SUM(deposit),0) AS todayDeposit, IFNULL(SUM(withdraw),0) AS todayWithdraw
      from fund_list WHERE company = '{$company}' and banktype is NOT NULL and duedate = CURDATE() GROUP BY banktype) b
      ON a.banktype = b.banktype) b on a.banktype = b.banktype where type='보통예금' and company ='{$company}' order by idx) a union select idx, type, bank, banktype, account, breakdown, null as yesbalance, null as todaydeposit, null as todaywithdraw, balance from fund_bankbook where type!= '보통예금' and company = '{$company}';")->result();
    }

    public function bankbookupdate($company){

      $result = $this->db->query("update fund_bankbook a, ( select a.banktype, ifnull(b.balance,0) as balance from fund_bankbook a left join (select banktype, ifnull(sum(deposit),0) - ifnull(sum(withdraw),0) as balance from fund_list group by banktype) b on a.banktype = b.banktype where company = '{$company}' ) b SET a.balance = b.balance WHERE a.banktype = b.banktype;");
      if($result){
        return "true";
      }else{
        return "false";
      }
    }

    public function accountlist($start, $limit, $company){

      $limit_query=' LIMIT '. $start .', '. $limit ;
      return $this->db->query("SELECT * FROM fund_list where company = '{$company}' ORDER BY idx DESC". $limit_query)->result();
      // return $this->db->query("SELECT * FROM test WHERE idx = 1 OR month(dueDate) = month(curDate()) ORDER BY idx")->result();
    }

    public function pagingbalance($start,$company){
      $limit = $start;
      // echo "<script>alert('{$start}')</script>";
      return $this->db->query("select ifnull(sum(a.deposit),0)-ifnull(sum(a.withdraw),0) as pagingBalance from (select * from fund_list where company = '{$company}' order by idx limit {$limit}) a;")->result();
    }

    public function sortpagingbalance($limit,$company){
      // echo "<script>alert('{$start}')</script>";
      return $this->db->query("select ifnull(sum(a.deposit),0)-ifnull(sum(a.withdraw),0) as pagingBalance from (SELECT * FROM fund_list where company = '{$company}' ORDER BY dueDate is null DESC, dueDate ASC, idx ASC limit {$limit}) a;")->result();
    }

    public function enduserpagingbalance($start,$company){
      $limit = $start;

      return $this->db->query("select ifnull(sum(a.deposit),0)-ifnull(sum(a.withdraw),0) as pagingBalance from  (SELECT * FROM fund_list where company = '{$company}' ORDER BY endUser is null DESC, endUser DESC, dueDate is null DESC, dueDate ASC, idx ASC limit {$limit}) a;")->result();
    }

    public function sort($start, $limit, $company){
    $limit_query=' LIMIT '. $start .', '. $limit ;
    // return $this->db->query("SELECT * FROM fund_list where company = '{$company}' ORDER BY  dueDate is null ASC, dueDate ASC, idx ASC". $limit_query)->result();
    return $this->db->query("SELECT * FROM fund_list where company = '{$company}' ORDER BY dueDate is null ASC, dueDate DESC, idx DESC". $limit_query)->result();
  }


  public function enduser($start, $limit, $company){
   $limit_query=' LIMIT '. $start .', '. $limit ;
   return $this->db->query("SELECT * FROM fund_list where company = '{$company}' ORDER BY endUser is null ASC, endUser ASC, dueDate is null ASC, dueDate DESC, idx DESC". $limit_query)->result();
 }

    public function bond($company){
      return $this->db->query("SELECT IFNULL(SUM(deposit),0) as bond from fund_list where type = '매출채권' and company = '{$company}' and banktype is null;")->result();
    }

    public function debt($company){
      return $this->db->query("SELECT IFNULL(SUM(withdraw),0) as debt from fund_list where type = '매입채무' and company = '{$company}' and banktype is null;")->result();
    }

    public function delete($data){
        $result = $this->db->delete('fund_list', $data);
        //echo $result;
        if($result){
          return "$result";
        }else{
          return "false";
        }
      }

    public function update($data, $idx){
      // $this->db->where('idx', 1);
      // $this->db->update('accountlist2', $data);
      $where = "idx = '{$idx}'";
      $result=$this->db->update('fund_list',$data,$where);
      //echo $result;
      if($result){
        return "true";
      }else{
        return "false";
      }
    }

    public function deltrigger($trg){
      $idx = $trg['idx'];
      $id = $trg['id'];
      $result = $this->db->query("UPDATE fund_list_log SET modifyer = '".$id."' WHERE old_seq='".$idx."' AND modifytype = '삭제'");
      // echo $sql;
      // $query = $this->db->query($sql);
      if($result){
        return "true";
      }else{
        return "false";
      }
    }

    public function trigger($trg){
      $idx = $trg['idx'];
      $id = $trg['id'];
      $sql = "UPDATE fund_list_log SET modifyer = '".$id."' WHERE old_seq=".$idx;
      $query = $this->db->query($sql);
      $result = $query->result();
    }
    // 쿠키 필요
    public function insert($data){
      $result = $this->db->insert('fund_list',$data);
      if($result){
        return "true";
      }else{
        return "false";
      }
    }

    public function insertbankbook($data){
          $result = $this->db->insert('fund_bankbook',$data);
          if($result){
            return true;
          }else{
            return false;
          }
        }

    public function updatebankbook($data,$updateIdx){
      $where = "idx = '{$updateIdx}'";
      $result = $this->db->update('fund_bankbook',$data,$where);
      //echo $result;
      if($result){
        return "true";
      }else{
        return "false";
      }
    }

    public function deletebankbook($data){
        $result = $this->db->delete('fund_bankbook', $data);
        //echo $result;
        if($result){
          return true;
        }else{
          return false;
        }
      }

    public function deluser($data,$delidx){
      $where = "old_idx = '{$delidx}' AND cud='delete'";
      $result = $this->db->update('fund_bankbook_log',$data, $where);
      // $result = $this->db->update('fund_bankbook_log',$data);
      if($result){
        return true;
      }else{
        return false;
      }
    }


    public function selectbankbook($company){
      // return $this->db->query("SELECT * FROM fund_bankbook WHERE type='보통예금' and company = '{$company}' ORDER BY idx ASC")->result();
      return $this->db->query("SELECT * FROM fund_bankbook WHERE company = '{$company}' ORDER BY idx ASC")->result();
    }

    public function bankList($company){
      return $this->db->query("SELECT DISTINCT bank FROM fund_bankbook WHERE company = '{$company}' AND bank != '' ORDER BY bank")->result();
    }

    // public function selectBalance(){
    //   return $this->db->query("SELECT balance FROM fund_bankbook ORDER BY idx ASC")->result();
    // }

    public function selectloanaccount($company){
      return $this->db->query("SELECT * FROM fund_bankbook WHERE type='대출' and company = '{$company}' ORDER BY idx ASC")->result();
    }

    public function seachlist($selectDate, $fromDate = null, $toDate = null, $search1, $keyword1 = null, $search2, $keyword2 = null, $search3, $keyword3 = null, $company){
  if($fromDate==null && $toDate){
    $this->db->select_min($selectDate, 'MinDate');
    $query = $this->db->get('fund_list');
    $row = $query->row();

    $fromDate = $row->MinDate;
  }

  if($toDate==null && $fromDate){
    $this->db->select_max($selectDate, 'MaxDate');
    $query = $this->db->get('fund_list');
    $row = $query->row();

    $toDate = $row->MaxDate;
  }

      $result['fromDate'] = $fromDate;
      $result['toDate'] = $toDate;

      $term = '';
      if($fromDate && $toDate){
        $term = " AND $selectDate BETWEEN '".$fromDate. "' AND '".$toDate."'";
      }

    $key1 = '';
    if($keyword1){
      $key1 = " AND $search1 LIKE '%".$keyword1."%'";
    }

    $key2 ='';
    if($keyword2){
      $key2 = " AND $search2 LIKE '%".$keyword2."%'";
    }

    $key3 ='';
    if($keyword3){
      $key3 = " AND $search3 LIKE '%".$keyword3."%'";
    }

    $comkey = " AND company = '$company'";



    $sql = "SELECT * FROM fund_list WHERE 1=1 ".$term.$key1.$key2.$comkey;

    // echo $sql;
    $query = $this->db->query($sql);
    $result['num_rows'] = $query->num_rows();

    $sql2 = "SELECT IFNULL(sum(deposit),0) as sumDeposit, IFNULL(sum(withdraw),0) as sumWithdraw FROM fund_list WHERE 1=1 ".$term.$key1.$key2.$key3.$comkey." AND bankType IS NOT NULL";
    $query2 = $this->db->query($sql2);
    $row = $query2->row();
    $result['sumDeposit'] = $row->sumDeposit;
    $result['sumWithdraw']= $row->sumWithdraw;
    // echo $resultRow;
    // $result['list'] = $query->result();
    // $result['row'] = $query->num_rows();
    $sql3 = "SELECT IFNULL(sum(deposit),0) as nsDeposit, IFNULL(sum(withdraw),0) as nsWithdraw FROM fund_list WHERE 1=1 ".$term.$key1.$key2.$key3.$comkey." AND bankType IS NULL";
    $query3 = $this->db->query($sql3);
    $row = $query3->row();
    $result['nsDeposit'] = $row->nsDeposit;
    $result['nsWithdraw'] = $row->nsWithdraw;
    return $result;
  }

  public function searchpaging($selectDate, $fromDate = null, $toDate = null, $search1, $keyword1 = null, $search2, $keyword2 = null, $search3, $keyword3 = null, $start, $limit, $company){
    if($fromDate==null && $toDate){
      $this->db->select_min($selectDate, 'MinDate');
      $query = $this->db->get('fund_list');
      $row = $query->row();

      $fromDate = $row->MinDate;
    }

    if($toDate==null && $fromDate){
      $this->db->select_max($selectDate, 'MaxDate');
      $query = $this->db->get('fund_list');
      $row = $query->row();

      $toDate = $row->MaxDate;
    }

    $term = '';
    if($fromDate && $toDate){
      $term = " AND $selectDate BETWEEN '".$fromDate. "' AND '".$toDate."'";
    }

    $key1 = '';
    if($keyword1){
      $key1 = " AND $search1 LIKE '%".$keyword1."%'";
    }

    $key2 ='';
    if($keyword2){
      $key2 = " AND $search2 LIKE '%".$keyword2."%'";
    }

    $key3 ='';
    if($keyword3){
      $key3 = " AND $search3 LIKE '%".$keyword3."%'";
    }

    $comkey = " AND company = '$company'";

    // $limitQuery ='';
    // if($start !='' && $limit !=''){
      $limitQuery=' LIMIT '. $start .', '. $limit ;
    // }
    //echo "---".$limitQuery."---";
    $sort = " order by idx desc";

    $sql = "SELECT * FROM fund_list WHERE 1=1 ".$term.$key1.$key2.$key3.$comkey.$sort.$limitQuery;

    $query = $this->db->query($sql);

    // $resultRow = $query->num_rows();
    // echo $resultRow;
    $result = $query->result();
    // $result['row'] = $query->num_rows();

    return $result;
  }

  public function selectbanktypelist($company){
    return $this->db->query("SELECT distinct banktype from fund_bankbook where company = '{$company}' and type = '보통예금' and banktype is not null ORDER BY banktype;")->result();
  }

      public function history($count, $start, $limit){
      if($start == '' && $limit == ''){
        $limitQuery = '';
      }else{
        $limitQuery=' LIMIT '. $start .', '. $limit ;
      }
        $sql="select a.*, b.* from (
(select old_seq as seq, old_dateofissue as dateofissue, old_fixeddate as fixeddate, old_duedate as duedate, old_type as type, old_banktype as banktype, old_customer as customer, old_enduser as enduser, old_breakdown as breakdown, old_requisition as requisition, old_deposit as deposit, old_withdraw as withdraw, modifyer as new_id, company, old_id as id, modifytype, modifydate, lastdate
from fund_list_log)
union
(select idx as seq, dateofissue, fixeddate, duedate, type, banktype, customer, enduser, breakdown, requisition, deposit, withdraw, null as new_id, company, id, '입력' as modifytype, ifnull(modifydate, insertdate) as modifydate, null as lastdate from fund_list where modifydate is null)
union
(select c.old_seq as seq, c.old_dateofissue as dateofissue, c.old_fixeddate as fixeddate, c.old_duedate as duedate, c.old_type as type, c.old_banktype as banktype, c.old_customer as customer, c.old_enduser as enduser, old_breakdown as breakdown, c.old_requisition as requisition, c.old_deposit as deposit, c.old_withdraw as withedraw, c.modifyer as new_id, c.company, c.old_id as id, '입력' as modifytype, c.lastdate as modifydate, c.lastdate from
(select * from fund_list_log as a, (select old_seq as old_seq2, min(modifydate) as modifydate2 from fund_list_log group by old_seq) as b where a.old_seq = b.old_seq2 and a.modifydate = b.modifydate2) c) ) a
left join
(select old_seq as seq, new_dateofissue, new_fixeddate, new_duedate, new_type, new_banktype, new_customer, new_enduser, new_breakdown, new_requisition, new_deposit, new_withdraw, modifydate as modifydate2, lastdate
from fund_list_log where modifytype = '수정') b on a.seq = b.seq and a.modifydate = b.modifydate2 order by a.modifydate desc {$limitQuery};";
    $query = $this->db->query($sql);
    if($count != ''){
      $result = $query->num_rows();
    }else{
      $result = $query->result();
    }
    return $result;
    }



  public function hisbankbook($count, $start, $limit){
    if($start == '' && $limit == ''){
      $limitQuery = '';
    }else{
      $limitQuery=' LIMIT '. $start .', '. $limit ;
    }
    $sql = "SELECT * FROM fund_bankbook_log order by insertdate desc {$limitQuery}";
    $query = $this->db->query($sql);
    if($count != ''){
      $result = $query->num_rows();
    }else{
      $result = $query->result();
    }
    return $result;
    }


    public function history_searchlist($count, $start, $limit, $modifyType, $company, $fromModify = null, $toModify = null, $selectDate, $fromDate = null, $toDate = null, $search1, $keyword1 = null, $search2, $keyword2 = null){
  if($start == '' && $limit == ''){
    $limitQuery = '';
  }else{
    $limitQuery=' LIMIT '. $start .', '. $limit ;
  }


    $modifyTerm = '';
    if($fromModify && $toModify){
      $modifyTerm = " AND (modifydate BETWEEN '".$fromModify. "' AND '".$toModify."' OR a.lastdate BETWEEN '".$fromModify."' AND '".$toModify."')";
    }

    $term = '';
    if($fromDate && $toDate){
      $term = " AND ($selectDate BETWEEN '".$fromDate. "' AND '".$toDate."' OR new_$selectDate BETWEEN '".$fromDate."' AND '".$toDate."')";
    }

    $type = '';
    if($modifyType != ''){
      $type = " AND (modifytype= '".$modifyType."')";
    }

    $com = '';
    if($company != ''){
      $com = " AND (company= '".$company."')";
    }

    $key1 = '';
    if($keyword1){
      $key1 = " AND ($search1 LIKE '%".$keyword1."%' OR new_$search1 LIKE '%".$keyword1."%')";
    }

    $key2 ='';
    if($keyword2){
      $key2 = " AND ($search2 LIKE '%".$keyword2."%' OR new_$search2 LIKE '%".$keyword2."%')";
    }


    $sql="select a.*, b.* from (
(select old_seq as seq, old_dateofissue as dateofissue, old_fixeddate as fixeddate, old_duedate as duedate, old_type as type, old_banktype as banktype, old_customer as customer, old_enduser as enduser, old_breakdown as breakdown, old_requisition as requisition, old_deposit as deposit, old_withdraw as withdraw, modifyer as new_id, company, old_id as id, modifytype, modifydate, lastdate
from fund_list_log)
union
(select idx as seq, dateofissue, fixeddate, duedate, type, banktype, customer, enduser, breakdown, requisition, deposit, withdraw, null as new_id, company, id, '입력' as modifytype, ifnull(modifydate, insertdate) as modifydate, null as lastdate from fund_list where modifydate is null)
union
(select c.old_seq as seq, c.old_dateofissue as dateofissue, c.old_fixeddate as fixeddate, c.old_duedate as duedate, c.old_type as type, c.old_banktype as banktype, c.old_customer as customer, c.old_enduser as enduser, old_breakdown as breakdown, c.old_requisition as requisition, c.old_deposit as deposit, c.old_withdraw as withedraw, c.modifyer as new_id, c.company, c.old_id as id, '입력' as modifytype, c.lastdate as modifydate, c.lastdate from
(select * from fund_list_log as a, (select old_seq as old_seq2, min(modifydate) as modifydate2 from fund_list_log group by old_seq) as b where a.old_seq = b.old_seq2 and a.modifydate = b.modifydate2) c) ) a
left join
(select old_seq as seq, new_dateofissue, new_fixeddate, new_duedate, new_type, new_banktype, new_customer, new_enduser, new_breakdown, new_requisition, new_deposit, new_withdraw, modifydate as modifydate2, lastdate
from fund_list_log where modifytype = '수정') b on a.seq = b.seq and a.modifydate = b.modifydate2 WHERE 1=1 ".$modifyTerm.$term.$type.$com.$key1.$key2." order by a.modifydate DESC {$limitQuery};";

$query = $this->db->query($sql);
if($count != ''){
  $result = $query->num_rows();
}else{
  $result = $query->result();
}
return $result;
}

public function banksearch($count, $start, $limit, $cud, $old_company, $fromModify = null, $toModify = null, $search1, $keyword1 = null, $search2, $keyword2 = null){
  if($start == '' && $limit == ''){
    $limitQuery = '';
  }else{
    $limitQuery=' LIMIT '. $start .', '. $limit ;
  }


    $modifyTerm = '';
    if($fromModify && $toModify){
      $modifyTerm = " AND (old_modifydate BETWEEN '".$fromModify. "' AND '".$toModify."' OR insertdate BETWEEN '".$fromModify."' AND '".$toModify."')";
    }


    $type = '';
    if($cud != ''){
      $type = " AND (cud= '".$cud."')";
    }

    $com = '';
    if($old_company != ''){
      $com = " AND (old_company= '".$old_company."')";
    }

    $key1 = '';
    if($keyword1){
      $key1 = " AND (old_$search1 LIKE '%".$keyword1."%' OR new_$search1 LIKE '%".$keyword1."%')";
    }

    $key2 ='';
    if($keyword2){
      $key2 = " AND (old_$search2 LIKE '%".$keyword2."%' OR new_$search2 LIKE '%".$keyword2."%')";
    }


    $sql="SELECT * FROM fund_bankbook_log WHERE 1=1 ".$modifyTerm.$type.$com.$key1.$key2." order by insertdate desc {$limitQuery}";

    $query = $this->db->query($sql);
    if($count != ''){
      $result = $query->num_rows();
    }else{
      $result = $query->result();
    }

    return $result;
    }

    public function pagelog($count, $start, $limit){
      if($start == '' && $limit == ''){
        $limitQuery = '';
      }else{
        $limitQuery=' LIMIT '. $start .', '. $limit ;
      }
      $sql = "SELECT * FROM fund_list_user_log order by idx desc {$limitQuery}";
      $query = $this->db->query($sql);
      if($count != ''){
        $result = $query->num_rows();
      }else{
        $result = $query->result();
      }
      return $result;
      }

      public function logsearch($count, $start, $limit, $fromModify = null, $toModify = null, $search1, $keyword1 = null, $search2, $keyword2 = null){
        if($start == '' && $limit == ''){
          $limitQuery = '';
        }else{
          $limitQuery=' LIMIT '. $start .', '. $limit ;
        }

          $modifyTerm = '';
          if($fromModify && $toModify){
            $modifyTerm = " AND (login_time BETWEEN '".$fromModify."' AND '".$toModify."') OR (logout_time BETWEEN '".$fromModify."' AND '".$toModify."') OR (login_time < '".$fromModify."' AND logout_time > '".$toModify."')";
          }
          $key1 = '';
          if($keyword1){
            $key1 = " AND $search1 = '$keyword1'";
          }

          $key2 ='';
          if($keyword2){
            $key2 = " AND $search2 = '$keyword2'";
          }

          // $sql="SELECT * FROM fund_list_user_log WHERE 1=1 ".$modifyTerm.$key1.$key2." order by login_time dsdesc {$limitQuery}";
          $sql="SELECT a.* FROM"." (SELECT * FROM fund_list_user_log WHERE 1=1 ".$modifyTerm.")a WHERE 1=1 ".$key1.$key2." order by login_time desc {$limitQuery}";

          $query = $this->db->query($sql);
          if($count != ''){
            $result = $query->num_rows();
          }else{
            $result = $query->result();
          }

          return $result;
          }

      public function user(){
       return $this->db->query("SELECT user_id,user_name from user order by seq ASC;")->result();
      }

    public function login($data){
      $id = $data['id'];
      $page = $data['page'];
      $con = '비정상 로그아웃';
      $sql = "SELECT COUNT(*) as cnt FROM fund_list_user_log where id = '{$id}' and con = '{$con}' and page = '{$page}'";
      echo $sql;
      $row = $this->db->query($sql);
      var_dump($row->row_array());

      $result = $this->db->insert('fund_list_user_log',$data);
      if($result){
        return $result;
      }else{
        return "false";
      }
    }

    public function logout($data){
      $id = $data['id'];
      $login_time = $data['login_time'];
      $where = "id = '{$id}' and login_time = '{$login_time}'";
      $result = $this->db->update('fund_list_user_log',$data, $where);
      echo $this->db->update('fund_list_user_log',$data, $where);
      if($result){
        return $result;
      }else{
        return "false";
      }
    }

    public function logout_close($data, $login_time,$id){
      $where = "id = '{$id}' and login_time = '{$login_time}'";
      $result = $this->db->update('fund_list_user_log',$data, $where);
      echo $this->db->update('fund_list_user_log',$data, $where);
      if($result){
        return $result;
      }else{
        return "false";
      }
    }

    public function userIdx($id){
     return $this->db->query("select idx from fund_list_user_log where id = '{$id}' order by idx desc limit 1;")->result();
    }

    public function noreq($data){
      $id = $data['id'];
      $login_time = $data['login_time'];
      $logout_time = $data['logout_time'];
      $con = $data['con'];

      // $sql = "UPDATE fund_list_user_log SET logout_time = '{$logout_time}', con = '{$con}' WHERE id = '{$id}' ORDER BY idx DESC LIMIT 1";
      $sql = "UPDATE fund_list_user_log SET logout_time = '{$logout_time}', con='{$con}' WHERE id='{$id}' AND login_time = '{$login_time}'";
      $result = $this->db->query($sql);
      if($result){
        return $result;
      }else{
        return "false";
      }
    }

    public function firstPage($company){
      $sql = "SELECT min(c.ROWNUM) as rownum from (select @ROWNUM := @ROWNUM + 1 AS ROWNUM, a.* FROM (SELECT * FROM fund_list where company = '{$company}' ORDER BY dueDate is null ASC, dueDate DESC, idx DESC) a, (SELECT @ROWNUM := 0 ) b) c where bankType is not null and bankType != ' '";

      $row = $this->db->query($sql);

      $result = $row->row_array();

      return $result['rownum'];
    }

    public function sum_botong($company) {
      $sql = "SELECT SUM(balance) FROM fund_bankbook WHERE TYPE = '보통예금' AND company = '{$company}'";

      $row = $this->db->query($sql);

      $result = $row->row_array();

      return $result['SUM(balance)'];
    }

    public function sum_not_botong($company) {
      $sql = "SELECT SUM(balance) FROM fund_bankbook WHERE TYPE != '보통예금' AND company = '{$company}'";

      $row = $this->db->query($sql);

      $result = $row->row_array();

      return $result['SUM(balance)'];
    }

    public function sum_list_banktype($company) {
      $sql = "SELECT COUNT(*) as cnt FROM fund_list where company = '{$company}'";
      $row = $this->db->query($sql);
      $result = $row->row_array();

      $sql2 = "SELECT min(c.ROWNUM) as rownum from (select @ROWNUM := @ROWNUM + 1 AS ROWNUM, a.* FROM (SELECT * FROM fund_list where company = '{$company}' ORDER BY dueDate is null ASC, dueDate DESC, idx DESC) a, (SELECT @ROWNUM := 0 ) b) c where bankType is not null and bankType != ' '";
      $row2 = $this->db->query($sql2);
      $result2 = $row2->row_array();

      $limit = $result['cnt'] - $result2['rownum'] + 1;

      $sql3 = "SELECT IFNULL(SUM(deposit),0)-IFNULL(SUM(withdraw),0) AS balance FROM (SELECT * FROM fund_list where company = 'duit' ORDER BY dueDate is null DESC, dueDate ASC, idx ASC LIMIT {$limit}) a;";

      $row3 = $this->db->query($sql3);

      $result3 = $row3->row_array();

      return $result3['balance'];
    }

    // 일괄 수정
    // public function search_modify($selectDate, $fromDate = null, $toDate = null, $search1, $keyword1 = null, $search2, $keyword2 = null, $modify_col, $modify_before, $modify_after, $company){
    //
    //   if($fromDate==null && $toDate){
    //     $this->db->select_min($selectDate, 'MinDate');
    //     $query = $this->db->get('fund_list');
    //     $row = $query->row();
    //
    //     $fromDate = $row->MinDate;
    //   }
    //
    //   if($toDate==null && $fromDate){
    //     $this->db->select_max($selectDate, 'MaxDate');
    //     $query = $this->db->get('fund_list');
    //     $row = $query->row();
    //
    //     $toDate = $row->MaxDate;
    //   }
    //
    //       $result['fromDate'] = $fromDate;
    //       $result['toDate'] = $toDate;
    //
    //       $term = '';
    //       if($fromDate && $toDate){
    //         $term = " AND $selectDate BETWEEN '".$fromDate. "' AND '".$toDate."'";
    //       }
    //
    //     $key1 = '';
    //     if($keyword1){
    //       $key1 = " AND $search1 LIKE '%".$keyword1."%'";
    //     }
    //
    //     $key2 ='';
    //     if($keyword2){
    //       $key2 = " AND $search2 LIKE '%".$keyword2."%'";
    //     }
    //
    //     $comkey = " AND company = '$company'";
    //
    //     $sql = "UPDATE fund_list SET ".$modify_col." = REPLACE(".$modify_col.", '".$modify_before."','".$modify_after."') WHERE 1=1".$term.$key1.$key2.$comkey;
    //
    //     $result = $this->db->query($sql);
    //
    //     echo $result;
    // }
      public function search_modify($idx, $modify_col, $modify_before, $modify_after) {
        if ($modify_col == 'dueDate' && $modify_after == ''){
          $sql = "UPDATE fund_list SET ".$modify_col." = REPLACE(".$modify_col.", '".$modify_before."', NULL) WHERE 1=1 and idx = ".$idx;
        } else {
          $sql = "UPDATE fund_list SET ".$modify_col." = REPLACE(".$modify_col.", '".$modify_before."', '".$modify_after."') WHERE 1=1 and idx = ".$idx;
        }
        $result = $this->db->query($sql);

        echo $result;
      }

    }
 ?>