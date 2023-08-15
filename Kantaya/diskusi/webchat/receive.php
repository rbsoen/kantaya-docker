<?
/* 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 
?>

<html>
<body bgcolor="#FFFFFF">
<script>
function refresh() {
	time = new Date()
	window.location='receive.php?tstamp='+escape(time);
}
<?
    require './defines.php';
    require './txt2html.php';

    $q = new DB_Chat;
    $r = new DB_Chat;

    $que="select send_id, rcpt_id, message from message left join user on user.last< message.time
		where user.uid=$uid and message.rid=$rid and 
		(( message.rcpt_id <= 0 ) or ( message.rcpt_id = $uid ) or ( message.send_id = $uid ))";
    $q->query($que);
    while( $q->next_record() ) { 
#    $q->p('message');
      $message = txt2html(rawurldecode($q->f('message')));
      $rcpt_id = $q->f('rcpt_id');	
      $send_id = $q->f('send_id');

      $que="select name from chat.user where uid=$send_id";
      $r->query($que);
      $r->next_record(); 
      $name = $r->f('name');
      if ( $rcpt_id == 0 ) {
        $toOut = '<font color="red"><b>'.$name.'&gt;</b></font> '.$message.'<br>';
      } else if ( $rcpt_id == -1 ) {
        $toOut = '<font color="#222222">'.$name.' '.$message.'</font><br>';
      } else if ( $rcpt_id == $send_id ) {
        $toOut = '<font color="#BB6655"><b>(you)</b> '.$message.'</font><br>';
      } else if ( $send_id == $uid ) {
        $que="select name from chat.user where uid=$rcpt_id";
        $r->query($que);
        $r->next_record(); 
        $name = $r->f('name');
        $toOut = '<font color="#5566BB"><b>(to '.$name.')</b> '.$message.'</font><br>';
      } else  {
        $que="select name from chat.user where uid=$send_id";
        $r->query($que);
        $r->next_record(); 
        $name = $r->f('name');
        $toOut = '<font color="#5566BB"><b>(from '.$name.')</b> '.$message.'</font><br>';
      }
      ?>
      toOut = '<? echo $toOut ?>';
      if (document.all) {
        top.wOut.document.body.innerHTML+= toOut;
      } else {
        top.wOut.document.write("<html><style>BODY {font-family: Verdana, sans-serif; color: #000055; font-size: 12px;} </style><body bgcolor='#FFFFFF'>");
	top.wOut.document.write(toOut);
      }
      <?
    }
 
    $que="update user set last = null where uid=$uid";
    $q->query($que);
?>
setTimeout('refresh()',8000);
</script>
</html>
