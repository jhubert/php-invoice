<html>
<head>
<title>Invoice <?=$client['ref']?> / <?=$invoice['invoiceid']?></title>
<link href="<?=$TEMPLATE_DIR?>css/style.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#6298BA" text="#000000">
<br>
    <?=$this->fetch($tbody)?>
</body>
<html>