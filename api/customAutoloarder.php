<?php

class Autoloader {

        const debug      = true;
		const RootDir    = ROOT_DIR;
		const ClassesDir = 'classes';
		
        public function __construct(){}

         /**
         * Функция прямого подключения класса или файла.<br/>
         * В случае неудачи, вызывает функцию рекурсивного поиска.
         * @param string $file имя файла(без расширения)
         * @param string $ext расширение файла(без точки)
         * @param string $dir директория для поиска(без первого и последнего слешей)
         */
        public static function autoload($file, $ext = FALSE, $dir = FALSE) {      
          $file       = str_replace('\\', '/', $file);
		  $rootDir    = self::RootDir;
		  $classesDir = self::ClassesDir;
          if($ext === FALSE) {
             $path = $rootDir . '/' . $classesDir;
             $filepath = $path . '/' . $file . '.php';
          }
          else{
             $path = $rootDir . (($dir) ? '/' . $dir : '');
             $filepath = $path . '/' . $file . '.' . $ext;
          }
          
          if (file_exists($filepath)){
              
				if($ext === FALSE) {
				  if(Autoloader::debug) Autoloader::StPutFile(('подключили ' .$filepath));
				  require_once($filepath);
				}
				else{
				  if(Autoloader::debug) Autoloader::StPutFile(('нашли файл в ' .$filepath));
				  return $filepath;
				}
          }
          else{
				$flag = true;
				if(Autoloader::debug) Autoloader::StPutFile(('начинаем рекурсивный поиск файла <b>' . $file . '</b> в <b>' . $path . '</b>'));
				return Autoloader::recursiveAtoload($file, $path, $ext, $flag);
          }
        }
    
         /**
         * Функция рекурсивного подключения класса или файла. 
         * @param string $file имя файла(без расширения)
         * @param string $path путь где ищем
         * @param string $ext расширение файла
         * @param string $flag необходим для прерывания поиска если искомый файл найден
         */
        public static function recursiveAtoload($file, $path, $ext, &$flag){
		
          $rootDir    = self::RootDir; 
          $classesDir = self::ClassesDir;
          $res = false;		  
		  
          if(FALSE !== ($handle = opendir($path)) && $flag) {
		  
            while (FAlSE !== ($dir = readdir($handle)) && $flag){
				  if(strpos($dir, '.') === FALSE) {
						$path2 = $path .'/' . $dir;
						$filepath = $path2 . '/' . $file .(($ext === FALSE) ? '.php' : '.' . $ext);
						if(Autoloader::debug) Autoloader::StPutFile(('ищем файл <b>' .$file .'</b> in ' .$filepath));
			
						if (file_exists($filepath)){
							  $flag = FALSE;
							  if($ext === FALSE){
									if(Autoloader::debug) Autoloader::StPutFile(('подключили ' .$filepath ));
									require_once($filepath);
									break;
							  }
							  else{
									if(Autoloader::debug) Autoloader::StPutFile(('нашли файл в ' .$filepath ));
									return $filepath;
							  }
						}
						
						$res = Autoloader::recursiveAtoload($file, $path2, $ext, $flag); 
				  }
            }
			
            closedir($handle);
			
          }
		  
          return $res;
		  
        }
    
        /*** Функция логирования
           * @param string $data данные для записи  ***/
       private static function StPutFile($data) {

//			  $rootDir = self::RootDir;
//              // die($rootDir);
//			  $dir = $rootDir .'/log/LogAutoloader.html';
//			  $file = fopen($dir, 'a');
//			  flock($file, LOCK_EX);
//			  fwrite($file, ('¦' .$data .'=>' .date('d.m.Y H:i:s') .'<br/>¦<br/>' .PHP_EOL));
//			  flock($file, LOCK_UN);
//			  fclose ($file);
       }

}

spl_autoload_register('Autoloader::autoload');

