<?php
$mySql = "SELECT * FROM petugas WHERE kd_petugas='".$_SESSION['SES_LOGIN']."'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query petugas salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);
?> <br><br>
<table width="600" border="0" class="table-list">
  <tr>
    <td colspan="3"><strong>INFO LOGIN </strong></td>
  </tr>
  <tr>
    <td>Nama Anda </td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['nm_petugas']; ?></td>
  </tr>
  <tr>
    <td width="195">Username</td>
    <td width="10"><strong>:</strong></td>
    <td width="381"><?php echo $myData['username']; ?></td>
  </tr>
  <tr>
    <td>Level</td>
    <td><strong>:</strong></td>
    <td><?php echo $myData['level']; ?></td>
  </tr>
</table>
