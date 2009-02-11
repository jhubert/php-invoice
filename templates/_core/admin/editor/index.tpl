<?=$message?>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td valign="top"> 
      <table class="content" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th><?=$lang['templates']?></th>
        </tr>
        <? 
        $x = 0;
        foreach($templates as $template):
        $cls = ($x % 2 == 0) ? 'odd' : 'even';
        $x++;
        ?>
        <tr class="<?=$cls?>" onmouseover="this.className='over'" onmouseout="this.className='<?=$cls?>'">
            <td><a href="pickfile.php?template=<?=$template?>"><b><?=$template?></b></a></td>
        </tr>
        <? endforeach; ?>
      </table>
    </td>
    <td valign="top"> 
      <table class="content" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th><?=$lang['languages']?></th>
        </tr>
        <? 
        $x = 0;
        foreach($languages as $language):
        $cls = ($x % 2 == 0) ? 'odd' : 'even';
        $x++;
        ?>
        <tr class="<?=$cls?>" onmouseover="this.className='over'" onmouseout="this.className='<?=$cls?>'">
            <td><a href="editlang.php?pass_lang=<?=$language?>"><b><?=$language?></b></a></td>
        </tr>
        <? endforeach; ?>
      </table>
    </td>
  </tr>
</table>
