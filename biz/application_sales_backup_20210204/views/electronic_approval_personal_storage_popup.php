<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style>
   p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
   
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }
   ul{
      list-style:none;
      padding-left:0px;
   }

   li{
      list-style:none;
      padding-left:0px;
   }
</style>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">     
<body>
    <table width="90%" height="100%" cellspacing="0" cellpadding="0" style="margin-left:30px;">
        <tr>
            <td width="100%" align="center" valign="top">
                <!--내용-->
                <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
                    <!--타이틀-->
                    <tr>
                        <td class="title3">개인보관함</td>
                    </tr>
                    <!--//타이틀-->
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <!--작성-->
                    <tr>
                        <td>
                            <input type="hidden" id="choice_storage" name="choice_storage" value="" />
                            <div style="font-size:16px;margin-left:50px;margin-top:30px;">
                                <ul>
                                    <li>
                                    <span style="cursor:pointer;" id="category">
                                        CATEGORY
                                    </span>
                                    <table class="basic_table">
                                        <tr><td class="basic_td categoryBtn" onclick="storageBtn(1,0,'');" style="cursor:pointer;display:none;width:120px;">추가</td></tr>
                                    </table>
                                    <ul>
                                        <?php 
                                        foreach($view_val as $val){
                                            if($val['parent_id'] == 0 && $val['cnt'] == 0){ ?>
                                                <div id="<?php echo $val['storage_name']; ?>">
                                                <li onclick="storageClick(this,'<?php echo $val['seq']; ?>')" style='cursor:pointer;'>
                                                    <ins>&nbsp;</ins>
                                                    <span><ins>&nbsp;</ins>&nbsp;&nbsp;<?php echo $val['storage_name']; ?></span>
                                                </li>
                                                </div>
                                        <?php 
                                            }else if($val['parent_id'] == 0 && $val['cnt'] > 0){ ?>
                                                <div id="<?php echo $val['storage_name']; ?>" >
                                                <li onclick="storageClick(this,'<?php echo $val['seq']; ?>')" style='cursor:pointer;'>
                                                    <img src="<?php echo $misc; ?>img/btn_add.jpg" class="Btn" width="13" style="cursor:pointer;" onclick="viewMore('<?php echo $val['seq']; ?>','<?php echo $val['storage_name']; ?>',this)">
                                                    <span><?php echo $val['storage_name']; ?></span>
                                                </li>
                                            </div>
                                        <?php
                                            }
                                        } 
                                        ?>
                                    </ul>
                                    </li>
                                </ul>
                            </div>
                            <div style="float:right;margin-top:50px;">
                                <input type="button" class="basicBtn" value="적용" onclick="saveToPersonalStorage();"/>
                                <input type="button" class="basicBtn" value="닫기" onclick="self.close();"/>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
<script>
   //보관함 전체열어!!!!!!!!
   $(".Btn").trigger("click");

   //개인보관함 열기 +버튼 눌러서 하위 목록 보기
   function viewMore(seq,id,obj){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $(obj).attr('src', src);
      $(obj).attr('onclick',"viewHide('"+id+"',this)"); 
      $.ajax({
         type: "POST",
         cache: false,
         url: "<?php echo site_url(); ?>/approval/storageView",
         dataType: "json",
         async :false,
         data: {
            seq:seq
         },
         success: function (result) {
            var html = "<ul style='margin-left:20px;'>";
            for(i=0; i<result.length; i++){
               if(result[i].cnt > 0){
                  html += "<div id='"+result[i].storage_name+"'>"
                  html += "<li onclick='storageClick(this,"+'"'+result[i].seq+'"'+");' style='cursor:pointer;'>";
                  html += "<img src='<?php echo $misc; ?>img/btn_add.jpg' class='Btn' width='13' style='cursor:pointer;' onclick='viewMore("+result[i].seq+","+'"'+result[i].storage_name+'"'+",this)'>";
                  html += "<span>"+result[i].storage_name+"</span></li>";
                  html += "</div>";
               }else{
                  html += "<div id='"+result[i].storage_name+"'>"
                  html += "<li onclick='storageClick(this,"+'"'+result[i].seq+'"'+");' style='cursor:pointer;'>";
                  html += "<ins>&nbsp;</ins>";
                  html += "<span><ins>&nbsp;</ins>&nbsp;&nbsp;"+result[i].storage_name+"</span></li>";
                  html += "</div>";
               }
            }
            html += "</ul>"
            $("#"+id).html($("#"+id).html()+html);
            for(i=0; i<$("#"+id).find($("img")).length; i++){
               if($("#"+id).find($("img")).eq(i).attr('src') == '<?php echo $misc; ?>img/btn_add.jpg'){
                  $("#"+id).find($("img")).eq(i).trigger("click");
               }
            }
         }
      });
   }

   //개인보관함 숨기기
   function viewHide(id,obj){
      var src = "<?php echo $misc; ?>img/btn_add.jpg";
      $(obj).attr('src', src);
      $(obj).attr('onclick',"viewShow('"+id+"',this)"); 
      $("#"+id).find($("div")).hide();
   }

   //개인보관함 다시열어!
   function viewShow(id,obj){
      var src = "<?php echo $misc; ?>img/btn_del0.jpg";
      $(obj).attr('src', src);
      $(obj).attr('onclick',"viewHide('"+id+"',this)"); 
      $("#"+id).find($("div")).show();
   }

   //보관함 클릭
   function storageClick(obj,seq){
       $("#choice_storage").val(seq);
       $("li").css('backgroundColor','');
       $(obj).css('backgroundColor', '#f8f8f9');
   }

   //보관함에 저장!
   function saveToPersonalStorage() {
       if (confirm("저장하시겠습니까?")) {
           if("<?php echo $_GET['seq']; ?>".indexOf(',') == -1){
                var save_doc_seq = "," + "<?php echo $_GET['seq']; ?>";
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: "<?php echo site_url(); ?>/approval/saveToPersonalStorage",
                    dataType: "json",
                    async: false,
                    data: {
                        seq: $("#choice_storage").val(),
                        save_doc_seq: save_doc_seq
                    },
                    success: function (result) {
                        if (result == true) {
                            alert("폴더에 정상적으로 보관 되었습니다.");
                            opener.location.reload();
                            self.close();
                        } else if (result == "duplicate") {
                            alert("폴더에 이미 저장된 문서 입니다.")
                        } else {
                            alert("폴더에 보관 실패하였습니다.");
                        }
                    }
                });
           }else{
                var save_doc_seq = "<?php echo $_GET['seq']; ?>".split(',');
                var result_value =''
                for (i = 0; i < save_doc_seq.length; i++) {
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: "<?php echo site_url(); ?>/approval/saveToPersonalStorage",
                        dataType: "json",
                        async: false,
                        data: {
                            seq: $("#choice_storage").val(),
                            save_doc_seq: ','+save_doc_seq[i]
                        },
                        success: function (result) {
                            result_value = result;
                        }
                    });
                }
                if(result_value == true){
                    alert("이동 성공!");
                }
                opener.location.reload();
                self.close();
           }
       }
   }
    
</script>
</html>
