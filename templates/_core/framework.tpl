<html>
<head>
<title>Typical Invoice :: <?=$page_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?=$SITE_ROOT?>templates/_core/css/style.css" rel="stylesheet" type="text/css" />
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
<body bgcolor="#FFFFFF" alink="#1F4862" link="#1F4862" vlink="#1F4862" text="#1F4862">
<img src="<?=$SITE_ROOT?>images/site_logo.jpg" width="219" height="85" border="0" style="margin:10px" />
<table width="100%"  border="0" cellspacing="10" cellpadding="0">
  <tr>
    <? if (isset($session['ses_client_id'])) : ?>
    <td width="150" valign="top"><table width="150" border="0" cellpadding="2" cellspacing="0" bgcolor="#6298BA" class="frame">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="inner">
            <tr>
              <td valign="top">
                <?
                    if ($session['ses_access'] == 'client') {
                         echo $this->fetch("client/menu.tpl");
                    } else {
                         echo $this->fetch("admin/menu.tpl");
                    }
                ?>
                </td>
            </tr>
        </table></td>
      </tr>
    </table>
    </td>
    <? endif; ?>
<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2" class="frame">
  <tr>
    <td bgcolor="#6298BA"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="inner">
        <tr>
          <td>
            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="innertop">
              <tr>
                <th width="150"><?=$page_title?></th>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table>
            <table class="contentbox">
            <tr><td class="contentbox">
            <?=$this->fetch($tbody)?>
            </td></tr>
            </table>
            <br /></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<p align="center" class="copyright">
powered by <a href="http://www.typicalgeek.com" style="font-weight:normal">typical<b>Invoice</b></a><br />
template designed by <a href="http://www.typicalgeek.com" style="font-weight:normal">TypicalGeek</a> </p>
<!-- 
Copyright Notice:

THIS COPYWRITE NOTICE AND THE TEXT ABOVE IT MUST APPEAR ON ALL PAGES

This script was written by Jeremy Hubert, and is protected under copywrite laws. 
Any improvements, please email typicalinvoice@typicalgeek.com. 
-->
<p>&nbsp;</p>
</body>
</html>