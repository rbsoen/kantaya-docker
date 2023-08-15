<?php

session_start();


require("lib.inc.php");

session_register("arrdir");

$fields = array( "all" => "$rts_23", "filename" => "$datei_text3", "remark" => "$datei_text4" , "kat" => "$datei_text5" );

echo "<html><head><link rel=stylesheet type='text/css' href='$css_style'>$lang_cfg</head><body bgcolor=$bgcolor3>\n";

echo "&nbsp;<br>\n";



// reset number of elements

$treffer = 0;



// open and close directory

if ($action == "open") {

  $arrdir[$ID] = "1";

  $action = "";

}

elseif ($action == "close"){

  $arrdir[$ID] = "";

  $action = "";

}



//  category & access selection goes all types and update/new, too

if ($action and $action <> "view") {

  // access: manual selection or profile

  if ($acc == "4") {

    $result = db_query("select personen from profile where ID = '$profil'") or db_die();

    $row = db_fetch_row($result);

    $acc = $row[0];

  }

  elseif ($acc == "3") $acc = serialize($persons);

  if (!$kat) $kat = $kat2; // if no manual category is given, use the one from the select box

}



// database transactions

if ($action == "update") {

  // check authentification

  $result = db_query("select ID from dateien where ID = $ID and von = $user_ID") or db_die();

  $row = db_fetch_row($result);

  if (!$row[0]) { echo "You don't have the right to change the properties of this record!"; exit; }



  $dbTSnull = date("YmdHis");

  // check for same record name

  $result = db_query("select ID, filename, typ from dateien where $sql_user_group") or db_die();

  while ($row = db_fetch_row($result)) {

    if ($row[0] <> $ID and $row[1] == $filename and $row[2] == $typ) {

      echo "$datei_text19! <br><a href='dateien.php?PHPSESSID=$PHPSESSID&action=form'>$back</a>";

      exit;

    }

  }

  // copy record with new values

  if ($c_m == "c") {

    $result = db_query("select * from dateien where ID = '$ID'") or db_die(); // fetch missing values from old record

    $row = db_fetch_row($result);

    if ($typ == "f") $result = db_query("insert into dateien values($dbIDnull,'$user_ID','$row[2]','$remark','$kat','$acc','$dbTSnull','$row[7]','$row[8]','$row[9]','$row[10]','$parent',null)") or db_die();

    else $result = db_query("insert into dateien values($dbIDnull,'$user_ID','$filename','$remark','$kat','$acc','$dbTSnull','$row[7]','$row[8]','$row[9]','$row[10]','$parent',null)") or db_die();

  }

  // update record or move item

  else {

    if ($typ == "f") $result = db_query("update dateien set remark='$remark',kat='$kat',acc='$acc',div1='$parent' where ID=$ID") or db_die();

    else $result = db_query("update dateien set filename='$filename',remark='$remark',kat='$kat',acc='$acc',div1='$parent' where ID=$ID") or db_die();

  }

  $action = "";

}



// new link or dir

elseif ($action == "link" or $action == "dir") { //goes for link and dir as well

  if (!$filename) {  // filename doesn't exists?

    echo "$datei_text1";

    $action = "form";

  }

  // check for same record name

  $result = db_query("select filename, typ from dateien where $sql_user_group") or db_die();

  while ($row = db_fetch_row($result)) {

    if ($row[0] == $filename and $row[1] == $typ) {

      echo "$datei_text19! <br><a href='dateien.php?PHPSESSID=$PHPSESSID&action=form'>$back</a>";

      exit;

    }

  }



  $dbTSnull = date("YmdHis");

  $result = db_query("insert into dateien values($dbIDnull,'$user_ID','$filename','$remark','$kat','$acc','$dbTSnull',0,'$user_group','$filepath','$typ','$parent',null)") or db_die();

  $action = "";

}



// new file

elseif ($action == "upload") {

  if (!$userfile or !$userfile_size) { echo "$datei_text1! <br><a href='dateien.php?PHPSESSID=$PHPSESSID&kat=$kat&remark=$remark'>$back</a> ..."; footer();}

  $userfile_name = ereg_replace(" ","§",$userfile_name);



  //check whether there is already a file with this name

  $result = db_query("select filename, von, tempname, typ from dateien ") or db_die();

  while ($row = db_fetch_row($result)) {

    if ($row[0] == $userfile_name and $row[3] == $typ) {

      // overwrite not allowed -> error message

      if (!$overwrite) {

        echo "$datei_text2! <br><a href='dateien.php?PHPSESSID=$PHPSESSID&acc=$acc&kat=$kat&remark$remark'>$back</a>"; footer();

      }

      // overwrite yes -> delete old record

      else {

        // oops, you are not the owner? -> go to hell!

        if ( $row[1] <> $user_ID) { echo "$datei_text12 <br><a href='dateien.php?PHPSESSID=$PHPSESSID&acc=$acc&kat=$kat&remark=$remark'>$back</a>"; footer();}

        $result = db_query("delete from dateien where filename = '$userfile_name' and typ = '$typ' and von = '$user_ID'") or db_die();      }

    }

  }

  if (isset($userfile)) {

    if ($dat_crypt) {

      srand((double)microtime()*1000000);

      $char = "123456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMANOPQRSTUVWXYZ";

      while (strlen($filenewname) < 9) { $filenewname .= substr($char,(rand()%(strlen($char))),1);}

    }

    else { $filenewname = $userfile_name; }

    // fetch file from tmp directory and move it into specified dir

    copy($userfile, "$dateien/$filenewname");

    // check whether the file really went into the directory :-)

    if (!file_exists("$dat_rel/$filenewname")) { echo "Ups! Something went wrong ...<br>Please check whether the

    file exists in the target directory and<br> the variable dat_rel in the config has the correct value"; exit; }



    $dbTSnull = date("YmdHis");

    // write into db

    $result = db_query("insert into dateien values($dbIDnull,'$user_ID','$userfile_name','$remark','$kat','$acc','$dbTSnull','$userfile_size','$user_group','$filenewname','$typ','$parent',null)") or db_die();



  }

  $action = "";

}



elseif ($action == "delete") {



  // check authentification

  $result = db_query("select ID from dateien where ID = $delete_ID and von = $user_ID") or db_die();

  $row = db_fetch_row($result);

  if (!$row[0]) { echo "You don't have the right to change the properties of this record!"; exit; }



  $result = db_query("select ID, filename, tempname, typ, filesize from dateien where ID = $delete_ID") or db_die();

  $row = db_fetch_row($result);

  // only delete file when it is not a link

  if ($row[4] > 0) {

    if ($dat_crypt) { $path = "$dateien/$row[2]"; }

    else {$path = "$dateien/$row[1]"; }

    unlink($path);

  }

  $result2 = db_query("delete from dateien where ID = '$delete_ID'") or db_die();

  if ($row[3] == "d") del($row[0]); // look for files in the subdirectory

  $action = "";

}





//*******

// Dialog

//*******



if ($action == "form") {

  echo "<script language='JavaScript' src='lib/chkform.js' type='text/javascript'></script>\n"; //forces to enter a name

  echo "<table bgcolor=$bgcolor2 cellspacing=0 cellpadding=3 border=1 width=500>\n";

  echo "<td width=230><a href='$doc/files.html' target=_blank><b>$inst_text24</b></a></td>\n";

  echo "<td>$con_text4:</td>\n";

  echo "<td width=50><a href='dateien.php?PHPSESSID=$PHPSESSID&action=form&sort=$sort&up=$up&form=upload'>$datei_text7</a></td>\n";

  echo "<td width=50><a href='dateien.php?PHPSESSID=$PHPSESSID&action=form&sort=$sort&up=$up&form=dir'>$directory</a></td>\n";

  echo "<td width=50><a href='dateien.php?PHPSESSID=$PHPSESSID&action=form&sort=$sort&up=$up&form=link'>$datei_text15</a></td>\n";

  echo "</td></table><br>\n";



  // Formular - upload form

  echo "<table border=1 cellspacing=0 cellpadding=3 bgcolor=$bgcolor2 width=500>\n";



  if ($ID) {   // fetch data for editing and check authentification

    $result = db_query("select * from dateien where ID = $ID and von = $user_ID") or db_die();

    $row = db_fetch_row($result);

    if (!$row[0]) { echo "You don't have the right to change the properties of this record!"; exit; }

  }





  if ($form == "link") { // form for links

    echo "<form method=post action='dateien.php' name='frm' onSubmit=\"return chkForm('frm','filename','$opt_bm4!')\">\n";

    echo "<input type=hidden name='typ' value='l'>\n";

    echo "<tr><td colspan=3><b>$datei_text15</b><br>\n";

    echo "<tr><td>$datei_text3:</td><td colspan=2><input type=text name=filename value='$row[2]' size=20></td></tr>\n";

    if ($ID) {

      echo "<input type=hidden name='filepath' value='$row[9]'>\n";

      echo "<input type=hidden name='action' value='update'>\n";

      echo "<tr><td>$datei_text21:</td><td colspan=2>$row[9]&nbsp;</td></tr>\n";

    }

    else {

      echo "<input type=hidden name='action' value='link'>\n";

      echo "<tr><td>$datei_text16:</td><td colspan=2><input type=text name='filepath' value='$row[9]'></td></tr>\n";

    }

  }



  elseif ($form == "dir") {  // form for directories

    echo "<form method=post action='dateien.php' name='frm' onSubmit=\"return chkForm('frm','filename','$opt_bm4!')\">\n";

    echo "<input type=hidden name=typ value='d'>\n";

    if ($ID) echo "<input type=hidden name='action' value='update'>\n";

    else     echo "<input type=hidden name='action' value='dir'>\n";

    echo "<tr><td colspan=3><b>$directory</b><br>\n";

    echo "<tr><td>$datei_text3:</td><td colspan=2><input type=text name=filename size=20 value='$row[2]'></td></tr>\n";

  }



  else {    // for normal file uploads

    if ($ID) {

      echo "<form method=post action='dateien.php'>\n";

      echo "<tr><td colspan=3><b>$rts_39</b></td>\n";  // title update

      echo "<input type=hidden name='action' value='update'>\n";

      echo "<tr><td>$info_text6</td><td colspan=2>\n";

      $name = ereg_replace("§"," ",$row[2]); echo "$name\n";

    }

    else {

      echo "<form method=post enctype='multipart/form-data' action='dateien.php' name='frm' onSubmit=\"return chkForm('frm','userfile','$opt_bm4!')\">\n";

      echo "<tr><td colspan=3><b>$datei_text7</b>\n";  // title upload

      $maxsize = get_cfg_var(upload_max_filesize); //determine max file size

      if ($maxsize) echo " | ($datei_text20: $maxsize Byte)</td>\n"; // remark for max. filsize

      echo "<input type=hidden name='action' value=upload>\n";

      echo "<tr><td>$datei_text8:</td><td colspan=2>\n";

      echo "<input type=file name=userfile size=12>\n"; // new file -> upload form

    }

    echo "</td></tr>\n";

    echo "<input type=hidden name='typ' value='f'>\n";

  }



  // continue with rest of the form which applies to all three types of records



  // move or copy

  echo "<tr><td>$directory: </td><td>\n";

  if ($ID) { // show copy and move buttons only in case of alter data

    if ($form <> "dir") echo "<input type=radio name='c_m' value='c'>$copy_it\n"; // copying of dirs at the moment not possible

    echo " <input type=radio name='c_m' value='m'>$move_it<br>$datei_text17\n";

  }

  echo "&nbsp;</td><td><select name='parent'> <option value='0'>\n";

  $result2 = db_query("select * from dateien where typ='d' and (von=$user_ID or acc like '2' or acc like '%$user_kurz%') and $sql_user_group") or db_die();

  while ($row2 = db_fetch_row($result2)) {

    if ($form <> "dir" or $row[0] <> $row2[0]) {  // avoid that a dir will be subdir of itself

      echo "<option value='$row2[0]'";

      if ($row2[0] == $row[11]) echo " selected";

      echo ">$row2[2]\n";

    }

  }

  echo "</select><br></td></tr>\n";



  // category

  echo "<tr><td width=150>$datei_text5:</td>\n";

  echo "<td width=200>$con_text4: <br> <input type=text name=kat size=20></td>\n";

  // show different categories

  echo "<td width=150>$admin_text64:<br><select name=kat2>&nbsp;<option value=''>\n";

  $result2 = db_query("select distinct kat from dateien where ((acc like '1' and von = $user_ID) or acc like '%$user_kurz%' or acc like '2') and $sql_user_group") or db_die();

  while ($row2 = db_fetch_row($result2)) {

    echo "<option value='$row2[0]'";

    if ($row[4] == $row2[0]) echo " selected";

    echo ">$row2[0]\n";

  }

  echo "</select></td></tr>\n";



  // overwrite?

  if (!$ID) {

    echo "<tr><td>$datei_text10</td>\n";

    echo "<td colspan=2><input type=checkbox name=overwrite value='on' checked></td></tr>\n";

  }



  // access: 1 = alone, 2 = all, 3 = some

  echo "<tr><td>$datei_text11:<br>$admin_text16:</td>\n";

  // personal file

  echo "<td><input type=radio name=acc value=1";

  if ($row[5] == "1" or !$row[5]) echo " checked";

  echo ">$datei_text11a&nbsp;\n";

  // file for all

  echo "<input type=radio name=acc value=2";

  if ($row[5] == "2") echo " checked";

  echo ">$datei_text11b&nbsp;<br>\n";

  // choose profile

  if ($profile) {

    echo "<input type=radio name=acc value=4";

    if ($row[5] == "4") echo " checked";

    echo ">$l_text25: <select name=profil> <option value=>\n";

    $result2 = db_query("select ID, bezeichnung, personen from profile where von = $user_ID");

    while ($row2 = db_fetch_row($result2)) {

      echo "<option value=$row2[0]";

      if ($row[5] == $row2[2]) echo " selected";

      echo ">$row2[1]\n";

    }

    echo "</select></td>\n";

  }

  // choose users

  echo "<td rowspan=2><input type=radio name=acc value=3";

    if (ereg(";}",$row[5])) echo " checked";

  echo ">$datei_text11c:<br>\n";

  echo "<select name=persons[] multiple size=6>\n";

  // select user from this group

  if ($user_group) $result3 = db_query("select user_ID from grup_user where grup_ID = $user_group and user_ID <> $user_ID") or db_die();



  // if user is not assigned to a group or group system is not activated

  else $result3 = db_query("select ID from users where ID <> $user_ID") or db_die();

  while ($row3 = db_fetch_row($result3)) {

    $result4 = db_query("select nachname, kurz, vorname from users where ID = $row3[0]") or db_die();

    $row4 = db_fetch_row($result4);

    echo "<option value=$row4[1]";

    if (ereg($row4[1], $row[5])) { echo " selected"; }

    echo ">$row4[0], $row4[2]\n";

  }

  echo "</select></td></tr>\n";



  // remark

  echo "<tr><td colspan=2>$datei_text4:<br><textarea name=remark cols='37' rows='4'>$row[3]</textarea></td></tr>\n";

  echo "<input type=hidden name='name' value='$user_name'>\n";

  echo "<input type=hidden name='PHPSESSID' value='$PHPSESSID'>\n";

  echo "<input type=hidden name=sort value=$sort>\n";

  echo "<input type=hidden name=up value=$up>\n";

  echo "<input type=hidden name='ID' value='$ID'>\n";   // $ID set? -> comes from editing button -> only record update

  if ($ID) echo "<tr><td colspan=2><input name=update value='$rts_39' type=submit></form>\n";

  else echo "<tr><td><input type=submit name=upload value='$submit'></form> &nbsp; </td>\n";

  // back button

  echo "<td colspan=2><form action='dateien.php' method='post'>\n";

  echo "<input type=hidden name='PHPSESSID' value='$PHPSESSID'>\n";

  echo "<input type=hidden name=sort value=$sort>\n";

  echo "<input type=hidden name=up value=$up>\n";

  echo "<input type=submit value=$back></form></td>\n";

  echo "</form></td></tr></table>\n";

}



// ******

//view

// ******



if (!$action) {

  echo "<table border=0 cellspacing=0 cellpadding=3 rules=none bgcolor=$bgcolor2>";

  // link to help file

  echo "<tr><td><a href='$doc/files.html' target=_blank><b>$inst_text24</b></a>\n";

  // set filter

  echo "<form action='dateien.php' method=post>";

  echo "<input type=hidden name='PHPSESSID' value='$PHPSESSID'>\n";

  echo "<input type=hidden name='mode' value='liste'>\n";

  echo "<td>| $datei_text14:</td><td><input type=text size=15 name='keyword' value=$keyword></td><td>$rts_22</td>\n";

  echo "<td><select name='filter'>\n";

  while (list($field1, $field2) = each($fields)) {

    echo "<option value='$field1'";

    if ($field1 == $filter) { echo " selected"; }

    echo ">$field2\n";

  }

  echo "</select></td>\n";

  // define threads/page and expanded/collapsed tree

  // default:

  echo "<td> &nbsp; | &nbsp; <input type='radio' name='open' value='auf'";

  echo ">$forum_text10 &nbsp;";

  echo "<input type='radio' name='open' value='zu'";

  echo ">$forum_text11 &nbsp; | &nbsp; $items ";

  // unset the whole arary

  if ($open == "zu") $arrdir = $arr_empty;



  // items per page

  if (!$perpage) { $perpage = 30; } // set default per page

  echo "&nbsp;<select name='perpage'>\n";

  for ($c = 1; $c <= 5; $c++) {

    $j = $c * 10;

    echo "<option value='$j'";

    if ($j == $perpage) { echo " selected"; }

    echo ">$j\n";

  }

  echo "</select></td>\n";

  echo "<td>&nbsp;<input type=image src='img/los.gif' border=0>&nbsp;&nbsp;";

  echo "<input type=hidden value=$sort name=sort>\n";

  echo "<input type=hidden value=$up name=up></form></td>\n";

  // new file

  echo "<td><form action=dateien.php method=post>\n";

  echo "<input type=hidden name=PHPSESSID value=$PHPSESSID>\n";

  echo "<input type=hidden name=sort value=$sort>\n";

  echo "<input type=hidden name=up value=$up>\n";

  echo "<input type=hidden name='action' value='form'>\n";

  echo "<input type=submit name='neu' value='$con_text4'></form></td>\n";

  echo "</tr></table>\n";



    // define filter

    if ($keyword) {

      if ($filter == "all" or $filter == '') { $where = "(filename like '%$keyword%' or remark like '%$keyword%' or kat like '%$keyword%')"; }

      else { $where = "$filter like '%$keyword%'"; }

    }

    // no filter? -> straight list, begin with first level

    else $where = "div1 = 0";



    //  define 'next' & 'previous' button, look for max number

    $result = db_query("select count(ID) from dateien where $where and (von = $user_ID or acc like '2' or acc like '%$user_kurz%') and $sql_user_group") or db_die();

    $row = db_fetch_row($result);

    if ($row[0] > $perpage) { echo "<tr>\n"; }

    $page_n = $page + 1;

    $page_p = $page - 1;

    if ($page) {echo "<td><a href='dateien.php?PHPSESSID=$PHPSESSID&up=$up&sort=$sort&filter=$filter&keyword=$keyword&mode=$mode&open=$open&perpage=$perpage&page=$page_p'>$previous</a>&nbsp;&nbsp;</td>";}

    if ($row[0] > $page_n*$perpage) {

      echo "<td colspan=2><a href='dateien.php?PHPSESSID=$PHPSESSID&up=$up&sort=$sort&filter=$filter&keyword=$keyword&mode=$mode&open=$open&perpage=$perpage&page=$page_n'>$next</a></td>\n";

    }



  echo "<br><table border=0 cellpadding=3 cellspacing=0>";  // grosse Tabelle



  // default sorting

  if (!$sort) { $sort = "typ"; }

  // direction

  $up2 = $up;

  if (!$up) {

    $direction = "ASC";

    $up = 1;

  }

  else {

    $direction="DESC";

    $up = 0;

  }  // sort up & down



  echo "<td><b><a href='dateien.php?PHPSESSID=$PHPSESSID&filter=$filter&keyword=$keyword&sort=filename&up=$up&page=$page&perpage=$perpage'>$datei_text3</a></b></td>\n";

  echo "<td><b><a href='dateien.php?PHPSESSID=$PHPSESSID&filter=$filter&keyword=$keyword&sort=datum&up=$up&page=$page&perpage=$perpage'>$datei_text6</a></b></td>\n";

  echo "<td><b><a href='dateien.php?PHPSESSID=$PHPSESSID&filter=$filter&keyword=$keyword&sort=filesize&up=$up&page=$page&perpage=$perpage'>Byte</a></b></td>\n";

  echo "<td>&nbsp;</td>\n"; // table cell for buttons

  echo "<td><b><a href='dateien.php?PHPSESSID=$PHPSESSID&filter=$filter&keyword=$keyword&sort=kat&up=$up&page=$page&perpage=$perpage'>$datei_text5</a></b></td>\n";   // category

  echo "<td><b><a href='dateien.php?PHPSESSID=$PHPSESSID&filter=$filter&keyword=$keyword&sort=remark&up=$up&page=$page&perpage=$perpage'>$datei_text4</a></b></td>\n"; // remark

  if ($keyword) echo "<td><b>$datei_text8</b></td>"; // if keyword: additional display of the path

  echo "</tr>";

  $total_size = 0;



  // **********

  // real query

    $result = db_query("select * from dateien where $where and (von = $user_ID or acc like '2' or acc like '%$user_kurz%') and $sql_user_group order by $sort $direction") or db_die();

    $i = 0;

    while ($row = db_fetch_row($result)) {

      $liste[$i] = $row[0];

      $i++;

    }

    //find maximum nuber

    if (($page+1)*$perpage > count($liste)) { $max = count($liste); }

    else { $max = ($page+1)*$perpage; }

    for ($i=($page*$perpage); $i < $max; $i++) {

      $ID = $liste[$i];

      $result = db_query("SELECT * from dateien where ID='$ID'") or db_die();

      $row = db_fetch_row($result);

      $ID = $row[0];

      include('lib/filelist.php');

      // directory? if open, look for records below this level

      if ($dir == "d" and !$keyword and ($arrdir[$ID] or $open == "auf")) sub($ID);

    }



  echo "</table>\n";

  // show total file size

  if ($total_size > 1000000) { $total_size = floor($total_size/1000000)." M"; }

  elseif ($total_size > 1000) { $total_size = floor($total_size/1000)." k"; }

  echo " &nbsp;<img src='img/s.gif' width=100 height=1 vspace=2 border=0><br>";

  if (!$treffer) $treffer = "0";

  if (!$total_size) $total_size = "0";

  echo " &nbsp;<i>$sum: $treffer $datei_text22, $total_size Byte</i>\n";

}



function sub($ID) {

  global $PHPSESSID, $user_ID, $sql_user_group, $level, $user_access, $where, $projekte,

         $user_kurz, $admin_text7, $confirm, $datei_text18, $arrdir, $filter, $keyword, $sort, $direction,

         $up, $up2, $page, $perpage, $file_ID, $delete_it, $treffer, $total_size, $open, $datei_text13;



  $result2 = db_query("select * from dateien where div1 = '$ID' and (von = $user_ID or ((acc like '2' or acc like '%$user_kurz%') and $sql_user_group)) order by $sort $direction") or db_die();

  while ($row2 = db_fetch_row($result2)) {

    $result = db_query("SELECT * from dateien where ID=$row2[0]") or db_die();

    $ID = $row2[0];

    $level++;

    while ($row = db_fetch_row($result)) include('lib/filelist.php');

    if ($dir == "d" and ($arrdir[$ID] or $open == "auf")) {sub($ID);}

    $level--;

  }

}



function del($delete_ID) {

  global $PHPSESSID, $dateien;

  $result = db_query("select ID, filename, tempname, typ, filesize from dateien where div1 = $delete_ID") or db_die();

  while ($row = db_fetch_row($result)) {

    // only delete file when it is not a link

    if ($row[4] > 0) {

      if ($dat_crypt) { $path = "$dateien/$row[2]"; }

      else {$path = "$dateien/$row[1]"; }

      unlink($path);

    }

    $result2 = db_query("delete from dateien where ID = '$row[0]'") or db_die();

    if ($row[3] == "d") del($row[0]); // look for files/links etc. in the subdirectory

  }

}


?>

</body>

</html>