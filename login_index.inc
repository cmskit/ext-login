<?php
/**
 *
 */


// if not needed you can delete the following Actions
//if ( !file_exists('composer.json') ){ header('location: inc/php/collectExternalRequirements.php'); } // redirect to System-Setup if not set





require 'inc/global_configuration.php';
require 'inc/php/functions.php';

$lang = !empty($_GET['lang']) ? $_GET['lang'] : browserLang(glob('inc/login/locales/*.php'), 'en');
include 'inc/login/locales/' . $lang . '.php';

function L($arr)
{
    global $LL;
    $m = array();
    foreach($arr as $e) {
        $m[$e] = (isset($LL[$e]) ? $LL[$e] : str_replace('_', ' ', $e));
    }
    return $m;
}


$data = array(
    'projectName' => $projectName,
    'projects' => $projects,
    'projectCount' => count($projects),
    'lang' => $lang,
    'servername' => $_SERVER['SERVER_NAME'],
    'jquerypath' => '../vendor/cmskit/jquery-ui',
    'error' => $_GET['error'],
    'logout'=> 'false',
    'timestamp' => time(),
    'localhost' => in_array($_SERVER['SERVER_NAME'], array('localhost', '127.0.0.1')),
    'L' => L(array(
            'javascript_not_activated',
            'your_version_of_internet_explorer_may_not_work',
            'please_wait',
            'login',
            'project_name',
            'user_name',
            'password',
            'register',
            'forgot_password',
            'bookmark',
        )
    ),
);

include_once 'extensions/login/tpl/indexTpl/tpl.php';
$tpl = new indexTpl();
?>
<!DOCTYPE html>
<html lang="<?php echo $lang?>">
<?php
echo $tpl->render_page($data);
?>
</html>
