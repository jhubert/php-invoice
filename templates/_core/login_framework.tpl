<html>
<head>
<title>Typical Invoice :: <?=$page_title?></title>
<link href="<?=$SITE_ROOT?>templates/_core/css/login_style.css" rel="stylesheet" type="text/css" />
</head>
<body LEFTMARGIN=10 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<p>&nbsp;</p>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><img src="<?=$SITE_ROOT?>images/site_logo.jpg" width="219" height="85">
    </td>
  </tr>
</table>
<br>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="border: 1px #000000 solid; border-right: 0px; border-bottom: 0px">
          <tr>
            <td style="background-color: #3C5D72; padding: 5px; color: #fff; font-weight: bold;">
                <?=@$toptext?>&nbsp;
            </td>
          </tr>
          <tr> 
            <td width="100%" align="center">
            <p>&nbsp;</p>
            <blockquote>
            <?=$this->fetch($tbody)?>
            </blockquote>
            <p>&nbsp;</p>
        </td>
      </tr>
      <tr>
        <td style="background-color: #9FC0D5; padding: 5px; color: #fff; font-weight: bold; text-decoration: none;">
            <?=@$bottomtext?>&nbsp;
        </td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td background="<?=$SITE_ROOT?>images/shdw_bottom.jpg"><img src="<?=$SITE_ROOT?>images/shdw_left_corner.jpg" width=6 height=8 alt=""></td>
        <td background="<?=$SITE_ROOT?>images/shdw_bottom.jpg"><img src="<?=$SITE_ROOT?>images/spacer.gif" width="40" height="8"></td>
    </tr>
    </table>
	  </td>
	  <td width="6" valign="bottom" background="<?=$SITE_ROOT?>images/shdw_right.jpg"><img src="<?=$SITE_ROOT?>images/shdw_right_corner.jpg" width="6" height="8"></td>
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