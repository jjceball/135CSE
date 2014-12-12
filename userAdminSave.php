<?php
        define('DB_USER','root');
        define('DB_PASSWORD','');
        define('DB_HOST','localhost');
        define('DB_NAME','userDB');
        $dbc = mysql_connect(localhost, root) OR die('Could not connect to MySQL: '.mysql_error());
        @mysql_select_db(DB_NAME) OR die('Could not select database: '.mysql_error());

        //username and password sent from form
        print "<html><head><title>userAdminSave.php</title>"
        +"<script></script>"
        +"</head><body>";
        $num = $_POST['intValue'];
        print "Length: ";
        print $num;
        print "<div>";
        $firstName = mysql_real_escape_string($_POST['namef']);
        $lastName = mysql_real_escape_string($_POST['namel']);
        $position = mysql_real_escape_string($_POST['position']);
        $username = mysql_real_escape_string($_POST['username']);
        $sql = "UPDATE People SET NameF = '$firstName', NameL = '$lastName', Position='stud', username='$username' WHERE pID = '$num' ;";
        $result = mysql_query($sql) or die( mysql_error());
        print"</div>";
        print "</body></html>";
?>
