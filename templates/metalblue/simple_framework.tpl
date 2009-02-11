<html>
<head>
<title>Invoice <?=$client['ref']?> / <?=$invoice['invoiceid']?></title>
<link rel="stylesheet" href="<?=$TEMPLATE_ROOT?>css/style.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000">
    <?=$this->fetch($tbody)?>
</body>
<html>