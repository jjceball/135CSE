<html>
<head>
<title>DBOutput</title>
</head>
<body>
<?php

        $dbc = mysql_connect(localhost, root) OR die('Could not connect to MySQL: '.mysql_error());
        @mysql_select_db(userDB) OR die('Could not select database: '.mysql_error());

        //username and password sent from form
        $username = mysql_real_escape_string("admin");
        $password = mysql_real_escape_string("admin");

        $userQuery = "SELECT * FROM People";

        $result = mysql_query($userQuery);
        mysql_close();
        $num=mysql_numrows($result);

        $i=1;while ($i < $num) {
        $f1=mysql_result($result,$i, "NameF");
        $f2=mysql_result($result,$i, "NameL");
        $f3=mysql_result($result,$i, "Position");
        $f4=mysql_result($result,$i, "username");
?>
<tr>
<td>
<div>
<form action="userAdminSave.php" method="POST">
<?php echo $i; ?>:
<input name="namef" value="<?php echo $f1; ?>"></input>
<input name="namel" value="<?php echo $f2; ?>"></input>
<select name="position">
        <option>Professor</option>
        <option <?php if($f3=="grad"){ echo "selected=\"selected\"";}?>>Grader</option>
        <option <?php if($f3=="stud"){ echo "selected=\"selected\"";}?>>Student</option>
</select>
<input name="username" value="<?php echo $f4; ?>"></input>
<input hidden name="intValue" value="<?php print $i ?>"></input>
<input type="submit" value="Save Person"></input>
</form>
</div>
<?php
                   $i++;
        }
?>
</body>
</html>
