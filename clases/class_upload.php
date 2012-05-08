<?php

class Upload_Files {

    var $temp_file_name;
    var $file_name;
    var $upload_dir;
    var $upload_log_dir;
    var $max_file_size;
    var $banned_array;
    var $ext_array;

    function validate_extension() {

        $file_name = trim($this->file_name);
        $extension = strtolower(strrchr($file_name, "."));
        $ext_array = $this->ext_array;
        $ext_count = count($ext_array);

        if (!$file_name) {
            return false;
        } else {
            if (!$ext_array) {
                return true;
            } else {
                foreach ($ext_array as $value) {
                    $first_char = substr($value, 0, 1);
                    if ($first_char <> ".") {
                        $extensions[] = "." . strtolower($value);
                    } else {
                        $extensions[] = strtolower($value);
                    }
                }

                foreach ($extensions as $value) {
                    if ($value == $extension) {
                        $valid_extension = "TRUE";
                    }
                }

                if ($valid_extension) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    function validate_size() {
        //--echo '<br>entro a esta funcion ';
        $temp_file_name = trim($this->temp_file_name);
        $max_file_size = trim($this->max_file_size);

        if ($temp_file_name != '') {
            $size = filesize($temp_file_name);
            
            //--echo '<br>la comprobacion es '.$size.' > '.$max_file_size;
            if ($size > $max_file_size) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function existing_file() {
        $file_name = trim($this->file_name);
        $upload_dir = $this->get_upload_directory();

        if ($upload_dir == "ERROR") {
            return true;
        } else {
            $file = $upload_dir . $file_name;
            if (file_exists($file)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function get_file_size() {
        $temp_file_name = trim($this->temp_file_name);
        $kb = 1024;
        $mb = 1024 * $kb;
        $gb = 1024 * $mb;
        $tb = 1024 * $gb;

        if ($temp_file_name) {
            $size = filesize($temp_file_name);
            if ($size < $kb) {
                $file_size = "$size Bytes";
            } elseif ($size < $mb) {
                $final = round($size / $kb, 2);
                $file_size = "$final KB";
            } elseif ($size < $gb) {
                $final = round($size / $mb, 2);
                $file_size = "$final MB";
            } elseif ($size < $tb) {
                $final = round($size / $gb, 2);
                $file_size = "$final GB";
            } else {
                $final = round($size / $tb, 2);
                $file_size = "$final TB";
            }
        } else {
            $file_size = "ERROR: NO FILE PASSED TO get_file_size()";
        }
        return $file_size;
    }

    function get_max_size() {
        $max_file_size = trim($this->max_file_size);
        $kb = 1024;
        $mb = 1024 * $kb;
        $gb = 1024 * $mb;
        $tb = 1024 * $gb;

        if ($max_file_size) {
            if ($max_file_size < $kb) {
                $max_file_size = "max_file_size Bytes";
            } elseif ($max_file_size < $mb) {
                $final = round($max_file_size / $kb, 2);
                $max_file_size = "$final KB";
            } elseif ($max_file_size < $gb) {
                $final = round($max_file_size / $mb, 2);
                $max_file_size = "$final MB";
            } elseif ($max_file_size < $tb) {
                $final = round($max_file_size / $gb, 2);
                $max_file_size = "$final GB";
            } else {
                $final = round($max_file_size / $tb, 2);
                $max_file_size = "$final TB";
            }
        } else {
            $max_file_size = "ERROR: NO SIZE PARAMETER PASSED TO  get_max_size()";
        }
        return $max_file_size;
    }

    function validate_user() {
        $banned_array = $this->banned_array;
        $ip = trim($_SERVER['REMOTE_ADDR']);
        $cpu = gethostbyaddr($ip);
        $count = count($banned_array);

        if ($count < 1) {
            return true;
        } else {
            foreach ($banned_array as $key => $value) {
                if ($value == $ip . "-" . $cpu) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    function get_upload_directory() {
        $upload_dir = trim($this->upload_dir);
        if ($upload_dir) {
            $ud_len = strlen($upload_dir);
            $last_slash = substr($upload_dir, $ud_len - 1, 1);
            if ($last_slash <> "/") {
                $upload_dir = $upload_dir . "/";
            } else {
                $upload_dir = $upload_dir;
            }

            $handle = @opendir($upload_dir);

            if ($handle) {
                $upload_dir = $upload_dir;
                closedir($handle);
            } else {
                $upload_dir = "ERROR";
            }
        } else {
            $upload_dir = "ERROR";
        }
        return $upload_dir;
    }

    function get_upload_log_directory() {
        $upload_log_dir = trim($this->upload_log_dir);
        
        if ($upload_log_dir) {
            $ud_len = strlen($upload_log_dir);
            $last_slash = substr($upload_log_dir, $ud_len - 1, 1);
            
            if ($last_slash <> "/") {
                $upload_log_dir = $upload_log_dir . "/";
            } else {
                $upload_log_dir = $upload_log_dir;
            }
            
            $handle = opendir($upload_log_dir);

            if ($handle) {
                $upload_log_dir = $upload_log_dir;
                closedir($handle);
            } else {
                $upload_log_dir = "ERROR";
            }
        } else {
            $upload_log_dir = "ERROR";
        }
        return $upload_log_dir;
    }

    function upload_file_no_validation() {
        $temp_file_name = trim($this->temp_file_name);
        $file_name = trim(strtolower($this->file_name));
        $upload_dir = $this->get_upload_directory();
        $upload_log_dir = $this->get_upload_log_directory();
        $file_size = $this->get_file_size();
        $ip = trim($_SERVER['REMOTE_ADDR']);
        $cpu = gethostbyaddr($ip);
        $m = date("m");
        $d = date("d");
        $y = date("Y");
        $date = date("m/d/Y");
        $time = date("h:i:s A");

        if (($upload_dir == "ERROR") OR ($upload_log_dir == "ERROR")) {
            return false;
        } else {
            if (is_uploaded_file($temp_file_name)) {
                if (move_uploaded_file($temp_file_name, $upload_dir . $file_name)) {
                    $log = $upload_log_dir . $y . "_" . $m . "_" . $d . ".txt";
                    $fp = fopen($log, "a+");
                    fwrite($fp, "$ip-$cpu | $file_name | $file_size | $date | $time");
                    fclose($fp);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    function upload_file_with_validation() {
        $temp_file_name = trim($this->temp_file_name);
        $file_name = trim(strtolower($this->file_name));
        
        $unsafeCharacters = array(" ","(", ")", "á", "é", "í", "ó", "ú");
        $safeCharacters =   array("", "_", "_", "a", "e", "i", "o", "u");
        
        $file_name = str_replace( $unsafeCharacters , $safeCharacters , $file_name );
        
        $upload_dir = $this->get_upload_directory();
        $upload_log_dir = $this->get_upload_log_directory();
        $file_size = $this->get_file_size();
        $ip = trim($_SERVER['REMOTE_ADDR']);
        $cpu = gethostbyaddr($ip);
        $m = date("m");
        $d = date("d");
        $y = date("Y");
        $date = date("m/d/Y");
        $time = date("h:i:s A");
        $existing_file = $this->existing_file();    //<-Add On 
        $valid_user = $this->validate_user();        //<-Add On 
        $valid_size = $this->validate_size();        //<-Add On 
        $valid_ext = $this->validate_extension();    //<-Add On 	
        //--echo '<br>entramos aqui 222 '.$valid_user.' OR '.$valid_size.' oR '.$valid_ext.'  OR '.$existing_file;
        
        if (($upload_dir == "ERROR") OR ($upload_log_dir == "ERROR")) {
            return false;
        } elseif ((((!$valid_user) OR (!$valid_size) OR (!$valid_ext) OR ($existing_file)))) {
            return false;
        } else {
            
            if (is_uploaded_file($temp_file_name)) {
                if (move_uploaded_file($temp_file_name, $upload_dir . $file_name)) {
                    
                    # realizamos la redimencion de la imagen
                    include_once('plugins/resize-class.php');
                    include_once('define/config_img.php');
                    
                    # load image
                    $resizeObj = new resize($upload_dir . $file_name);

                    # Resize image (options: exact, portrait, landscape, auto, crop)
                    $resizeObj->resizeImage( ImageConfig::$ImageSizes['large'][0] , ImageConfig::$ImageSizes['large'][1] , 'landscape' );

                    # Save image
                    $resizeObj -> saveImage($upload_dir . 'large_'.$file_name, 100);
                    
                    
                    # Resize image (options: exact, portrait, landscape, auto, crop)
                    $resizeObj->resizeImage( ImageConfig::$ImageSizes['medium'][0] , ImageConfig::$ImageSizes['medium'][1] , 'landscape' );

                    # Save image
                    $resizeObj->saveImage( $upload_dir . 'medium_' . $file_name , 100 );
                    
                    
                    $log = $upload_log_dir . $y . "_" . $m . "_" . $d . ".txt";
                    $fp = fopen($log, "a+");
                    fwrite($fp, "$ip-$cpu | $file_name | $file_size | $date | $time");
                    fclose($fp);
                    
                    # ponemos el nuvo nombre de la imagen en la variable $this -> file_name
                    $this -> file_name = $file_name;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

}

/* $upload_class = new Upload_Files; 
  $upload_class->temp_file_name = trim($_FILES['upload']['tmp_name']);
  $upload_class->file_name = trim(strtolower($_FILES['upload']['name']));
  $upload_class->upload_dir = "uploads/";
  $upload_class->upload_log_dir = "uploads/upload_logs/";
  $upload_class->max_file_size = 524288;
  $upload_class->banned_array = array("");
  $upload_class->ext_array = array(".jpg",".gif",".jpeg",".png");


  $valid_ext = $upload_class->validate_extension();
  $valid_size = $upload_class->validate_size();
  $valid_user = $upload_class->validate_user();
  $max_size = $upload_class->get_max_size();
  $file_size = $upload_class->get_file_size();
  $upload_directory = $upload_class->get_upload_directory();
  $upload_log_directory = $upload_class->get_upload_log_directory();
  $upload_file = $upload_class->upload_file_with_validation(); */
?> 
