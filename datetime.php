<?php
date_default_timezone_set("Europe/Athens");
$CurrentTime=time();
//$DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
echo $DateTime;
?>