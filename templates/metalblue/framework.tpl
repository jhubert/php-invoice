<html>
<head>
<title>Typical Invoice :: <?=$page_title?></title>
<?=$this->fetch("css/style.css")?>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
    function setClassName(obj, className){
        getRef(obj).className= className;
    }
    function getRef(obj){
          if(typeof obj == "string")
             obj= document.getElementById(obj);
          return obj;
    }
//  End -->
</script>
</head>
<body LEFTMARGIN=10 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<p>&nbsp;</p>
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="754">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 1px #000000 solid; border-right: 0px; border-bottom: 0px">
              <tr> 
                <td width="100%"><img src="<?=$TEMPLATE_DIR?>images/logo.jpg" width="219" height="85" style="margin-left: 20px">
                </td>
              </tr>
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td background="<?=$TEMPLATE_DIR?>images/menu_button_down.jpg">
                        <?
                            if ($session['ses_access'] == 'client') {
                                 echo $this->fetch("client/menu.tpl");
                            } else {
                                 echo $this->fetch("admin/menu.tpl");
                            }
                        ?>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td background="<?=$TEMPLATE_DIR?>images/shdw_bottom.jpg"><img src="<?=$TEMPLATE_DIR?>images/shdw_left_corner.jpg" width=6 height=8 alt=""></td>
                <td background="<?=$TEMPLATE_DIR?>images/shdw_bottom.jpg"><img src="<?=$TEMPLATE_DIR?>images/spacer.gif" width="40" height="8"></td>
              </tr>
            </table>
	    </td>
        <td width="6" valign="bottom" background="<?=$TEMPLATE_DIR?>images/shdw_right.jpg"><img src="<?=$TEMPLATE_DIR?>images/shdw_right_corner.jpg" width="6" height="8"></td>
	</tr>
</table>
<br><br>
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 1px #000000 solid; border-right: 0px; border-bottom: 0px">
		  <tr> 
		    <td width="100%" align="center">
                <p>&nbsp;</p>
                <?=$this->fetch($tbody)?>
                <p>&nbsp;</p>
			</td>
		  </tr>
		</table>
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    	  <tr> 
        	<td background="<?=$TEMPLATE_DIR?>images/shdw_bottom.jpg"><img src="<?=$TEMPLATE_DIR?>images/shdw_left_corner.jpg" width=6 height=8 alt=""></td>
	        <td background="<?=$TEMPLATE_DIR?>images/shdw_bottom.jpg"><img src="<?=$TEMPLATE_DIR?>images/spacer.gif" width="40" height="8"></td>
        </tr>
      </table>
	  </td>
	  <td width="6" valign="bottom" background="<?=$TEMPLATE_DIR?>images/shdw_right.jpg"><img src="<?=$TEMPLATE_DIR?>images/shdw_right_corner.jpg" width="6" height="8"></td>
	</tr>
</table>
<p align="center">
<a href="http://www.typicalgeek.com">powered by typical<b>Invoice</b></a>
</p>
<!-- 
Copyright Notice:

THIS COPYWRITE NOTICE AND THE TEXT ABOVE IT MUST APPEAR ON ALL PAGES

This script was written by Jeremy Hubert, and is protected under copywrite laws. 
Any improvements, please email typicalinvoice@typicalgeek.com. 
-->
<p>&nbsp;</p>
</body>
</html>