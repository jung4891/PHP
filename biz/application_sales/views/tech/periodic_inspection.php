<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
?>
<body>
    <table width="90%" height="100%" cellspacing="0" cellpadding="0" style="margin-left:30px;">
        <tr>
            <td width="100%" align="center" valign="top">
                <!--내용-->
                <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
                    <!--타이틀-->
                    <tr>
                        <td class="title3">정기점검 미완료</td>
                    </tr>
                    <!--//타이틀-->
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <div>
                                <table  width="100%" border="1" cellspacing="0" cellpadding="0" style="font-weight:bold;font-size:13px;">
                                    <tr width="100%" height=30>
                                        <td align="center" width="20%" bgcolor="f8f8f9" >idx</td>
                                        <td align="center" width="20%" bgcolor="f8f8f9" >고객사</td>
                                        <td align="center" width="20%" bgcolor="f8f8f9" >점검주기</td>
                                        <td align="center" width="20%" bgcolor="f8f8f9" >마지막점검일</td>
                                        <td align="center" width="20%" bgcolor="f8f8f9" >점검자</td>
                                    </tr>

                                    <?php
                                    $idx=1; 
                                    foreach($view_val as $val){
                                        echo "<tr height=30 align='center'><td>{$idx}</td>";
                                        echo "<td>{$val['customer_companyname']}</td>";
                                        echo "<td>";
                                        if ($val['maintain_cycle'] == "1") {
                                            echo "월점검";
                                        }else if ($val['maintain_cycle'] == "3") {
                                            echo "분기점검";
                                        }else if ($val['maintain_cycle'] == "6") {
                                            echo "반기점검";
                                        }else if ($val['maintain_cycle'] == "0") {
                                            echo "장애시";
                                        }else if ($val['maintain_cycle'] == "7") {
                                            echo "미점검";
                                        }else{
                                            echo "점검주기 선택";
                                        }
                                        echo "</td>";
                                        echo "<td>{$val['maintain_date']}</td>";
                                        echo "<td>{$val['maintain_user']}</td></tr>";
                                        $idx=$idx+1;
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>

            </td>
            <td height="10"></td>
        </tr>
    </table>
</body>
</html>