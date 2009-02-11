<html>
<head>
<title>Invoice <?=$client['ref']?> / <?=$invoice['invoiceid']?></title>
<link href="<?=$HTTP_ROOT.str_replace('../','',$TEMPLATE_DIR)?>css/style.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" text="#000000">
    <?=$this->fetch('forms/invoice.tpl')?>
</body>
<html>
