<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
  	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<style>
	.menu_div {
		margin-top:10px;
		padding: 10px;
		border-bottom: thin #EFEFEF solid;
		overflow-x: scroll;
		white-space:nowrap;
	}
	.menu_div::-webkit-scrollbar {
		display: none;
	}
	.menu_list {
		cursor:pointer;margin:10px;font-weight:bold;font-size:15px;
	}
	.content_list {
		width:100%;
	 display: inline-block;
	 padding-top:20px;
	 padding-bottom:20px;
	}
	.content_list_tbl {
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.content_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}

	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
    box-sizing : border-box !important;
	}
  .basic_table{
		width:100%;
		 border-collapse:collapse;
		 /* border:1px solid; */
		 border-color:#DEDEDE;
		 table-layout: auto !important;
		 border-left:none;
		 border-right:none;
	}

	.basic_table td{
		height:35px;
		 padding:0px 10px 0px 10px;
		 border:1px solid;
		 border-color:#DEDEDE;
	}
	.border_n {
		border:none;
	}
	.border_n td {
		border:none;
	}
	.basic_table tr > td:first-child {
		border-left:none;
	}
	.basic_table tr > td:last-child {
		border-right:none;
	}
	.select_category {
		background-color: rgb(5, 117, 230, 0.6);
	}
	</style>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
  <div class="menu_div">
    <a class="menu_list" onclick ="movePage('electronic_approval_list?type=admin')" style='color:#B0B0B0'>결재문서관리</a>
		<a class="menu_list" onclick ="movePage('electronic_approval_form_list?mode=admin')" style='color:#B0B0B0'>양식관리</a>
		<a class="menu_list" style='color:#0575E6'>서식함관리</a>
		<a class="menu_list" onclick ="movePage('electronic_approver_line_list')" style='color:#B0B0B0'>결재선관리</a>
	</div>

  <div style="width:90%;margin: 0 auto;margin-top:10px;">
    <table id="category_table" class="basic_table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:16px;">
      <colgroup>
        <col width="30%">
        <col width="40%">
        <col width="15%">
        <col width="15%">
      </colgroup>
      <tr>
        <td colspan="2" style="font-weight:bold;font-size:18px;">서식함</td>
        <td align="center" colspan="2"><img src="<?php echo $misc; ?>img/mobile/btn_plus_big.svg" height="100%" onclick="categoryBtn(0);"></td>
      </tr>
      <tbody class="category_list">
      <?php
      $i = 0;
      foreach($category as $ct) {
        ?>
        <tr>
          <td class="category" colspan="2" seq='<?php echo $ct['seq']; ?>' onclick="category_select(this,'<?php echo $ct['seq']; ?>')"><?php echo $ct['category_name']; ?></td>
          <td><img class="btn_up" src="<?php echo $misc; ?>img/mobile/allow_up.svg" onclick="move_updown(this, 'up');"></td>
          <td><img class="btn_down" src="<?php echo $misc; ?>img/mobile/allow_down.svg"  onclick="move_updown(this, 'down');"></td>
        </tr>
      <?php
      $i++;
      }?>
      </tbody>
      <tr height="40" class="input_tr" style="display:none;">
      <tr class="input_tr" style="display:none;">
        <td>서식함명</td>
        <td colspan="3">
          <input type="hidden" id="save_type" name="save_type" value="" />
          <input type="hidden" id="category_seq" name="category_name" value="" />
          <input type="text" id="category_name" name="category_name" class="input-common" value="" style="width:100%;border:none;" placeholder="서식함명 입력">
        </td>
      </tr>
      <tr class="input_tr" style="display:none;">
        <td align="center" colspan="4" style="border:none;">
          <input type="button" class="btn-common btn-color2" value="저장" onclick="categorySave();" style="width:90%;">
        </td>
      </tr>
    </table>
		<div class="btn_div" style="margin-top:10px;text-align:center;display:none;">
			<input type="button" class="btn-common btn-color1" value="수정" onclick="categoryBtn(1);" style="width:45%">
			<input type="button" class="btn-common btn-color2" value="삭제" onclick="categoryBtn(2);" style="width:45%">
		</div>
		<div class="order_save_div" style="margin-top:10px;text-align:center;display:none">
			<input type="button" class="btn-common btn-color1" value="취소" onclick="location.reload()" style="width:45%;">
			<input type="button" class="btn-common btn-color2" value="순서 저장" onclick="orderSave();" style="width:45%;">
		</div>
  </div>
  <div style="padding-bottom:60px;width:90%;margin:0 auto;">
		<p style="margin-top:40px;">
			<span style="color:#1C1C1C">서식함 생성 방법 : </span>
			<span style="color:#A1A1A1">우측 상단의 +버튼을 누르고 생성되는 입력창에 서식함명을 입력하고 저장 버튼을 선택합니다.</span>
		</p>
		<p style="">
			<span style="color:#1C1C1C">서식함 수정 방법 : </span>
			<span style="color:#A1A1A1">수정할 서식함을 선택 후 수정 버튼을 누른 뒤 수정할 보관함명을 입력하고 저장 버튼을 선택합니다.</span>
		</p>
		<p style="">
			<span style="color:#1C1C1C">서식함 삭제 방법 : </span>
			<span style="color:#A1A1A1">삭제할 서식함을 선택 후 삭제 버튼을 선택합니다.</span>
		</p>
		<p style="">
			<span style="color:#1C1C1C">서식함 이동 방법 : </span>
			<span style="color:#A1A1A1">순서를 변경할 서식함의 우측 화살표 버튼을 선택하여 순서를 변경한 뒤 순서 저장 버튼을 선택합니다.</span>
		</p>
	</div>

	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>

</body>

<script type="text/javascript">
  function movePage(page) {
    location.href = "<?php echo site_url(); ?>/biz/approval/" + page;
  }

  function category_select(el, seq) {
    if (order_modify) {
      if(confirm('서식함 순서가 변경되었습니다.\n순서 저장을 하시겠습니까?')) {

      } else {
        location.reload();
      }
    }
    $('.input_tr').hide();
    $('.btn_div').hide();
    if($(el).hasClass('select_category')) {
      $(el).removeClass('select_category');
    } else {
      $('.select_category').each(function() {
        $(this).removeClass('select_category');
      })
      $(el).addClass('select_category');
      $('#category_seq').val($(el).attr('seq'));
      $('#category_name').val($.trim($(el).text()));
      $('.btn_div').show();
    }
  }

var order_modify = false;
  function move_updown(el, type) {
    $('.select_category').each(function() {
      $(this).removeClass('select_category');
    })
    $('.btn_div').hide();
    $('.input_tr').hide();
    var idx = $(el).closest('tr').index();
    var tr_count = $('.category_list > tr').length - 1;
    if (type == 'up') {
      if (idx == 0) {
        alert('첫번째 순서입니다.');
        return false;
      }
      order_modify = true;
      $('.order_save_div').show();
      var $tr = $(el).parent().parent();
      $tr.prev().before($tr);
    } else if (type == 'down') {
      if (idx == tr_count) {
        alert('마지막 순서입니다.');
        return false;
      }
      order_modify = true;
      $('.order_save_div').show();
      var $tr = $(el).parent().parent();
      $tr.next().after($tr);
    }
  }

  function categoryBtn(type){
		$(".btn_div").hide();
		if(type != 3) {
			$('.save_div').show();
		}
		var seq = $('.select_category').attr('seq');
		var category_name = $.trim($('.select_category').text());
		console.log(seq);
		console.log(category_name);

    if(type == 0) { // 추가
      $('.select_category').each(function() {
        $(this).removeClass('select_category');
      })
      $("#save_type").val(0);
      $("#category_name").val('');
      $(".input_tr").show();
    } else if(type == 1){ //수정버튼 클뤽
			 if ($('.select_category').length == 0) {
				 alert('수정할 보관함을 선택해주세요.');
				 return false;
			 }
				$("#save_type").val(type);
				$("#category_seq").val(seq);
				$("#category_name").val(category_name);
				$(".input_tr").show();
		 } else { // 삭제
			 $('#save_type').val(2);
			 $('#category_seq').val(seq);
			 categorySave();
		 }
	}

  function orderSave() {
    var result = false;
    for (i = 0; i < $('.category').length; i++) {
      var seq = $('.category').eq(i).attr('seq');
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/biz/approval/format_category_modify",
        dataType: "json",
        async: false,
        data: {
          type: 3,
          seq: seq,
          idx: i
        },
        success: function (data) {
          if(data) {
            result = true;
          } else {
            result = false;
          }
        }
      });
    }
    if(result) {
      alert('변경되었습니다.');
      location.reload();
    } else {
      alert('변경 실패.');
    }
  }

  function categorySave() {
    var type = $('#save_type').val();

    if (type == 0) { // 추가
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/biz/approval/format_category_modify",
        dataType: "json",
        async: false,
        data: {
          type: type,
          category_name: $('#category_name').val()
        },
        success: function(data) {
          if(data) {
            alert('서식함명 추가 완료');
            location.reload();
          } else {
            alert('서식함명 추가 실패');
          }
        }
      })
    } else if (type == 1) { // 수정
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/biz/approval/format_category_modify",
        dataType: "json",
        async: false,
        data: {
          type: type,
          seq: $('#category_seq').val(),
          category_name: $('#category_name').val()
        },
        success: function (data) {
          if(data){
            alert('서식함명 수정 완료');
            location.reload();
          } else {
            alert('서식함명 수정 실패');
          }
        }
      })
    } else if (type == 2) { // 삭제
      if(confirm('서식함을 삭제하시겠습니까?')) {
        $.ajax({
          type: "POST",
          cache: false,
          url: "<?php echo site_url(); ?>/biz/approval/format_category_modify",
          dataType: 'json',
          async: false,
          data: {
            type: type,
            seq: $('#category_seq').val(),
          },
          success: function(data) {
            if(data) {
              alert('서식함 삭제 완료');
              location.reload();
            } else {
              alert('서식함 삭제 실패');
            }
          }
        });
      }
    }
  }
</script>
