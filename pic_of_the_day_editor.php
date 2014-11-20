<?php
/**
* 
* PIC of the Day - Editor
* 
* Flickr-Examples can be found on: http://www.flickr.com/explore/interesting/7days
* Source of a Flickr-Link looks like this:
* <a 
*   href="http://www.flickr.com/photos/58621196@N05/7078838757/" 
*   title="on the verge von brdonovan bei Flickr">
*   <img src="http://farm8.staticflickr.com/7106/7078838757_cc616aed30_b.jpg" width="1024" height="683" alt="on the verge">
* </a>
* 
* use your own Sources here but please respect the copyright of the Images!
*/
$backend = dirname(dirname(__DIR__));
require_once $backend . '/inc/php/session.php';
require_once $backend . '/inc/global_configuration.php';

// only superroots can do this
if(	isset($_GET['project'])
    && isset($_SESSION[$_GET['project']]['root'])
    && $_SESSION[$_GET['project']]['root'] == md5($_SERVER['REMOTE_ADDR'] . $super[1])
){



$projectName = $_GET['project'];
$savePath = __DIR__;


if(!is_writable($savePath.'/login_src.php')) exit($savePath.'/login_src.php is not writable!');

$get = '?project='.$projectName;

// Save to File
$out = array();
$msg = '';
if(isset($_POST['i']))
{
	foreach($_POST['i'] as $a)
	{
		if( 
			strlen($a['link']) > 0 &&
			strlen($a['src']) > 0 &&
			strlen($a['title']) > 0 
		){

$out[] = "	array (
		'linkcolor' => '".$a['linkcolor']."',		// link-color
		'src' => '".$a['src']."', 			// image-source
		'link' => '".$a['link']."', 			// back-reference
		'title' => '".$a['title']."', 			// link-title
		'author' => '".$a['author']."', 		// author
		'copyright' => '".$a['copyright']."' 		// copyright-notice
	)
";
		}
	}
	
	$str = '<?'."php\n\n\$loginpics = array(\n" . implode(",\n", $out) . "\n);\n";
	file_put_contents($savePath.'/login_src.php', $str);
	$msg = '<h3 style="color:green">List saved</h3>';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>PIC of the day - editor</title>
<style>
body{
	font-family: sans-serif;
}
a, a:visited{text-decoration:underline;color:#00f;}
label{
	display: inline-block;
	width: 150px;
}
input{
	width: 550px;
}
div{
	padding: 5px;
	border-bottom: 1px solid #333;
}
</style>

</head>
<body>



<h3>PIC of the day - editor</h3>

<p>
	Add infos below and save.
	The first block is always empty to add a new item.
	To remove an item simply clear all fields (via [x]) and save.
</p>

<form action="pic_of_the_day_editor.php<?php echo $get?>" method="post">
<?php

include $savePath . '/login_src.php';

// calculate the actual Image-Number
$bgNo = (date('z') % count($loginpics))+1;

array_unshift($loginpics,

array (
	'linkcolor' => '',		// link-color above the Background
	'src' => '', 			// image-source
	'link' => '', 			// back-reference
	'title' => '', 			// link-title
	'author' => '', 		// author
	'copyright' => '' 		// copyright-notice
)

);

$placeholder = array (
	'linkcolor' => 'Link-color above the background',
	'src' => 'Image-source *',
	'link' => 'Back-reference *',
	'title' => 'Image-title *',
	'author' => 'Author name',
	'copyright' => 'Copyright-notice (eg. CC-BY)'
);

echo $msg;
$c = 0;
foreach($loginpics as $loginpic)
{
	echo '<div id="p'.$c.'">
	<button type="button" style="float:right;color:red" onclick="clearMe(this)" title="Clear fields">x</button>
	<button type="button" onclick="move(this,1)"  title="move up">&uArr;</button> 
	<button type="button" onclick="move(this,-1)" title="move down">&dArr;</button>
	';
	
	foreach($loginpic as $k => $v)
	{
		echo '
		<p>
			<label>'.$k.'</label><input type="text" placeholder="'.$placeholder[$k].'" name="i['.$c.']['.$k.']" value="'.$v.'" />
		</p>
		';
	}
	
	echo '</div>';
	$c++;
}


?>

<button type="submit" >save</button>
</form>
<script src="../../../vendor/cmskit/jquery-ui/jquery.min.js"></script>
<script>

// highlight actual Inmage
$('#p<?php echo $bgNo?>').css('background-color','#eee');

function move (el, dir)
{
	var current = $(el).parent();
	if(dir==1)  current.prev().before(current);
	if(dir==-1) current.next().after(current);
}
function clearMe (el)
{
	$(el).parent().children('p').children('input').val('');
}

</script>
</body>
</html>


<?php
}
?>