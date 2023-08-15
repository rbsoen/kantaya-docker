<?
/* Transform plain text to HTML
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 

function txt2html($txt) {
    $patterns = array ( "/(http\:\/\/[^\s]+)/i",
			"/(ftp\:\/\/[^\s]+)/i",	  
			"/(mailto\:([^\s]+))/i",
			"/\:\)+/i",
			"/\:\-\)+/i",
			"/\;\)+/i",
			"/\;\-\)+/i",
			"/\:\|/i",
			"/\:\-\|/i",
			"/\:\(+/i",
			"/\:\-\(+/i",
			"/\*(.+)\*/i",
			"/\_(.+)\_/i",
			"/\r/i");
    $replace =  array ( "<a href=\"\\1\" target=\"_blank\">\\1</a>", 
			"<a href=\"\\1\" target=\"_blank\">\\1</a>", 
			"<a href=\"\\1\" target=\"_blank\">\\2</a>", 
			"<img src=\"img/smile.gif\" width=\"11\" height=\"11\" alt=\":)\">",
			"<img src=\"img/smile.gif\" width=\"11\" height=\"11\" alt=\":)\">",
			"<img src=\"img/smile.gif\" width=\"11\" height=\"11\" alt=\":)\">",
			"<img src=\"img/smile.gif\" width=\"11\" height=\"11\" alt=\":)\">",
			"<img src=\"img/normal.gif\" width=\"11\" height=\"11\" alt=\":|\">",
			"<img src=\"img/normal.gif\" width=\"11\" height=\"11\" alt=\":|\">",
			"<img src=\"img/sad.gif\" width=\"11\" height=\"11\" alt=\":(\">",
			"<img src=\"img/sad.gif\" width=\"11\" height=\"11\" alt=\":(\">",
			"<b>\\1</b>",
			"<i>\\1</i>",
			"<br>\n");
    return preg_replace($patterns,$replace, $txt);
}
?>
