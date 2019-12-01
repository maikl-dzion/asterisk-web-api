<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$siteUrl   = setSiteUrl();
$routeName = getRoute();
// lg($routeName, $siteUrl);

define('ROOT_DIR' , __DIR__);
define('INC_DIR'  , ROOT_DIR . '/inc');
define('SITE_URL' , $siteUrl);
define('DIR_SRC'  , __DIR__ . '/src');

define('JS_EXP'   , 'js');
define('TEMPLATE_EXP'   , 'html');

function setSiteUrl() {
    $request = explode('/', $_SERVER['REQUEST_URI']);
    array_pop($request);
    $siteUrl = implode('/', $request);
    return $siteUrl;
}

function getRoute() {
    $route = 'main';

    /***
    if(!empty($_SERVER['PATH_INFO'])) {
        $request = explode('/', $_SERVER['PATH_INFO']);
        $route = array_pop($request);
    }
     ***/

    if(!empty($_GET['page'])) {
        $route = $_GET['page'];
    }

    return $route;
}


function lg(){

    $out = '';
    $get = false;
    $style = 'margin:10px; padding:10px; border:3px red solid;';
    $args = func_get_args();
    foreach ($args as $key => $value) {
        $itemArr = array();
        $itemStr = '';
        is_array($value) ? $itemArr = $value : $itemStr = $value;
        if ($itemStr == 'get') $get = true;
        $line = print_r($value, true);
        $out .= '<div style="' . $style . '" ><pre>' . $line . '</pre></div>';
    }

    if ($get)return $out;
    print $out; exit;

}

function postLg($arr = '')
{
    if (!empty($_POST)) lg($_POST, $arr);
}

function getLg($arr = '')
{
    if (!empty($_GET)) lg($_GET, $arr);
}



class SetVueComponentsPrint {

    public $templates = array();
    public $js = array();
    public $items = array();
    public $rootDir = '';
    public $srcDir  = '';
    public $webDir  = '';
    public $viewsDir = 'views';
    public $jsExt = 'js';
    public $viewExt = 'php';


    public function __construct($items, $webDir = 'admin-lte', $srcDir = 'src') {
        $this->items  = $items;
        $this->srcDir = $srcDir;
        $this->rootDir = __DIR__ .'/'. $this->srcDir;
        $this->webDir  = $webDir . '/' . $this->srcDir;

        $this->run();
    }

    public function run() {
        $result  = array();
        foreach ($this->items as $name => $values) {
            $dirName = $values['dir'];
            $jsFile    = $this->rootDir .'/'. $dirName .'/'. $name;
            $viewFile  = $this->rootDir .'/'. $dirName .'/'. $this->viewsDir .'/'. $name;
            $this->fileCheck($jsFile  , $name, $dirName, $this->jsExt);
            $this->fileCheck($viewFile, $name, $dirName, $this->viewExt);
        }
        return $result;
    }

    public function fileCheck($file, $name, $dirName, $ext) {
        $fileName = $file .'.'. $ext;
        if(file_exists($fileName)) {
            $this->setFile($fileName, $name, $dirName, $ext);
        }
        else {
            // lg($file .'.'.$ext);
        }
    }

    public function setFile($file, $name, $dirName, $ext) {

        switch($ext) {
            case $this->jsExt :
                $file = '/' . $this->webDir .'/'. $dirName .'/'. $name .'.'. $ext;
                $this->js[] = $file;
                break;

            case $this->viewExt :
                $arr = array(
                    'file' => $file,
                    'name' => $name,
                    'dir'  => $dirName,
                );
                $this->template[] = $arr;
                break;
        }
    }

    public function setJs() {
        $jsString = '';
        foreach ($this->js as $key => $fileName) {
            $jsString .= '<script src="' .$fileName. '"></script>';
        }
        return $jsString;
    }

    public function setTemplate() {
        // lg($this->template);
        foreach ($this->template as $key => $value) {
            $fileName = $value['name'];
            $templateFile = $value['file'];
            switch ($value['dir']) {
                case 'components' : $suff= '-com'  ; break;
                default           : $suff = '-page'; break;
            }
            $fileName = $fileName . $suff;
            ?><template id="<?php echo $fileName ?>"><?php include $templateFile; ?></template><?php
        }
    }
}



class IncludedAssetsResources {

    public $rootDir;
    public $currentDir;
    public $srcUrl;
    public $srcPath;
    public $webSrcDir   = 'src';

    public function __construct($dir){
        $this->rootDir = $dir;
    }

    public function scandir($dir, $ext = '', $params = array()) {
        // SCANDIR_SORT_DESCENDING
        // SCANDIR_SORT_NONE
        switch ($dir) {
            case 'jsPlum' :
                $files =  scandir($this->rootDir .'/'. $dir, SCANDIR_SORT_NONE);
                break;
            default :
                $files =  scandir($this->rootDir .'/'. $dir);
                break;
        }

        return $files;
    }

    public function render($dir, $ext, $params = array()) {
        $files = $this->scandir($dir, $ext);
        $this->currentDir = $dir;
        $this->setSrcUrl();
        $this->setSrcPath();

        // if($dir == 'jsPlum') lg($files);

        foreach ($files as $key => $file) {
            if($file == '.' || $file == '..') continue;
            $extFile = pathinfo($file, PATHINFO_EXTENSION);
            if($extFile != $ext) continue;

            switch($ext) {
                case JS_EXP :
                     $this->setJsScript($file);
                     break;

                case TEMPLATE_EXP :
                     //lg($this->rootDir, $dir, $file);
                     $this->setTemplate($file);
                     break;
            }
        }
    }

    private function setJsScript($file) {
        $fileUrl = $this->srcUrl .'/'. $file;
        ?> <script src="<?php echo $fileUrl; ?>"></script> <?php
    }

    private function setTemplate($file) {
        $templatePath = $this->srcPath . '/' . $file;
        $fArr = explode('.', $file);
        $fileName = $fArr[0];
        // lg($templatePath, $fileName);
        ?><template id="<?php echo $fileName; ?>"><?php include $templatePath; ?></template><?php
    }

    public function setSrcUrl() {
        $this->srcUrl = $this->webSrcDir .'/'.$this->currentDir;
    }

    public function setSrcPath() {
        $this->srcPath = $this->rootDir .'/'.$this->currentDir;
    }

}


//function includeResource($dir, $ext) {
//    $files =  scandir($dir);
//    lg($files);
//}