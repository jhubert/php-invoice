<?=$message?>
<table width="300" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td> 
      <table class="content" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th>Select File</th>
        </tr>
        <? 
        $x = 0;
        foreach($files as $file):
        $cls = ($x % 2 == 0) ? 'odd' : 'even';
        $x++;
        ?>
        <tr class="<?=$cls?>" onmouseover="this.className='over'" onmouseout="this.className='<?=$cls?>'">
            <td><a href="editfile.php?page=<?=$file?>&template=<?=$template?>"><b><?=$file?></b></a></td>
        </tr>
        <? endforeach; ?>
      </table>
    </td>
  </tr>
</table>
