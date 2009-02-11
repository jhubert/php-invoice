<html>
<head>
<title>Invoice <?=$client['ref']?> / <?=$invoice['invoiceid']?></title>
<link rel="stylesheet" href="<?=$TEMPLATE_DIR?>css/style.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" onLoad="window.print(); window.close();">
<center>
<?=$this->fetch('forms/invoice.tpl')?>
</center>
</body>
</html>