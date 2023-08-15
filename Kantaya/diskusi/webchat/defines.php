<?
/* 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */

if (!isset($WEBCHATPATH)) {
	 $WEBCHATPATH = './';
}
include ($WEBCHATPATH.'db_mysql.php');
include ($WEBCHATPATH.'language/english.php');

class DB_Chat extends DB_Sql {
  var $classname = "DB_Chat";
  var $Host     = "localhost";
  var $Database = "chat";
  var $User     = "chat_user";
  var $Password = "webpass";

  function haltmsg($msg) {
  echo "<script>
        alert(\"Database error:\\t".$msg."\\nPHP reported:\\t".$this->Error."\");
        </script> ";
   exit;
  }
}

#echo "Load succesfull... ";

 function copyright() {
 ?> 
 <br><br><center>
 <a href="http://http://www.webdev.ro/">
 <img src="img/webchat_logo.gif" alt="[ powered by WebChat ]" width=120 height=30 border="0">
 </a>
 </center>
 <?
} 

?>
