<?php

    class Fonksiyon {
        //Category
        public function categoriesList($id=0){
            $db = new Database();
            $categories = array();
            $sql = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_CATEGORIES");

            foreach ($sql as $row)
            {
                $parent = intval($row['PARENTID']);
                if (!isset($categories[$parent]))
                {
                    $categories[$parent] = array();
                }
                $categories[$parent][] = $row;
            }

            $category_string = "";
            function build_categories_options($parent, $categories, $level,$id)
            {
                global $category_string;
                if (isset($categories[$parent]) && count($categories[$parent])) {
                    $level .= " -> ";
                    foreach ($categories[$parent] as $category)
                    {
                        $opt_value = substr($level.$category['TITLE'],3);
                        //$category_string .= '<option value="'.$category['ID'].'">'.$opt_value.'</option>';
                        if ($category['ID'] != $id)
                        {
                            $category_string .= '<option value="'.$category['ID'].'">'.$opt_value.'</option>';
                        }else
                        {
                            $category_string .= '<option value="'.$category['ID'].'" selected>'.$opt_value.'</option>';
                        }
                        build_categories_options($category['ID'], $categories, $level,$id);
                    }
                    $level = substr($level, -3);
                }
                return $category_string;
            }
            $category_options = build_categories_options(0, $categories, '',$id);
            //$category_options = '<select class="form-control" name="parentId"><option value="0">Select</option>'.$category_options.'</select>';

            echo $category_options;

            $db->Disconnect();
        }
        //Email Control
        public function emailControl($email)
        {
            if (!preg_match ("/^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$/", $email))
            {
                return false;
            } else {
                return true;
            }
        }

        //Only a-z, A-Z and number
        public function passwordControl($password)
        {
            if (!preg_match('/[\"|\'|\s\<\>]/',$password))
                return true;
            else
                return false;
        }

        //Only a-z, A-Z and Allows Turkish Characters
        public function usernameControl($username)
        {
            if (preg_match('/[^a-zA-ZÇĞİÖŞÜçğıöşü]/',$username))
            {
                return false;
            } else {
                return true;
            }
        }

        //Only a-z ve A-Z Allows Characters and empty
        public function charactersControl($namesurname)
        {
            if (preg_match('/[^a-zA-ZZÇĞİÖŞÜçğıöşü ]/',$namesurname))
            {
                return false;
            } else {
                return true;
            }
        }

        //Perma link
        public function sef_link($link)
        {
            $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
            $do = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
            $perma = strtolower(str_replace($find, $do, $link));
            $perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
            $perma = trim(preg_replace('/\s+/', ' ', $perma));
            $perma = str_replace(' ', '-', $perma);
            return $perma;
        }

        public function trUpper($str) {
            $str = strtr($str, 'ğşıöüçi', 'ĞŞIÖÜÇİ');
            return strtoupper($str);
        }

        public function trLower($str) {
            $str = strtr($str, 'ĞŞIÖÜÇİ', 'ğşıöüçi');
            return strtolower($str);
        }

        public function directoryList(){
            $dizin = '../theme';
            $dizinAc = opendir($dizin) or die ("Dizin Bulunamadı!");
            while ($dosya = readdir($dizinAc)){
                if (is_dir($dizin."/".$dosya) && $dosya != '.' && $dosya != '..'){
                    echo "<option ";
                    echo $dosya == THEME_DIR ? 'selected' : null;
                    echo " value='{$dosya}'>{$dosya}</option>";
                }
            }

        }

        //Web-Site Url Control
        public function websiteUrlControl($siteUrl)
        {
            if (filter_var($siteUrl, FILTER_VALIDATE_URL))
            {
                return true;
            } else {
                return false;
            }
        }


        function sweetalert($title, $text, $process, $url, $time)
        {
            echo "<script>
							swal({
										title: '$title',
										text: '$text',
										type:	'$process',
										showConfirmButton: false
									});
									window.setTimeout(function() {
									window.location.href = '$url';
							}, $time);
					</script>";
        }


    }



    function post_edit($giris)
    {
        $degistir = array('`' => "'");
        $giris = strtr($giris, $degistir);
        $giris = trim(strip_tags(htmlspecialchars($giris)));
        if (!get_magic_quotes_gpc())
            $giris = addslashes($giris);
        return $giris;
    }

    function write_edit($giris)
    {
        if (!get_magic_quotes_gpc())
            $giris = stripslashes($giris);
        return stripslashes($giris);
    }
//========================================================================================================

//========================================================================================================
    function GetIP()
    {
        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if (strstr($ip, ',')) {
                $tmp = explode(',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv("REMOTE_ADDR");
        }
        return $ip;
    }

//========================================================================================================
    function p($par, $st = false)
    {
        if ($st) {
            return htmlspecialchars(addslashes(trim($_POST[$par])));
        } else {
            return addslashes(trim($_POST[$par]));
        }
    }

//========================================================================================================
    function g($par)
    {
        return strip_tags(trim(addslashes($_GET[$par])));
    }

//========================================================================================================
    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'Yıl',
            'm' => 'Ay',
            'w' => 'Hafta',
            'd' => 'Gün',
            'h' => 'Saat',
            'i' => 'Dakika',
            's' => 'Saniye',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' önce' : 'şimdi';
    }

//========================================================================================================
    function timeAgo($date)
    {
        $timestamp = strtotime($date);
        $currentDate = new DateTime('@' . $timestamp);
        $nowDate = new DateTime('@' . time());
        return $currentDate
            ->diff($nowDate)
            ->format(' %y yıl %m ay %d gün %h saat %i dakika %s saniye önce..');
    }

//========================================================================================================



//========================================================================================================
    function getAy($ay)
    {
        if ($ay == "1") {
            $ay = "Ocak";
        } elseif ($ay == "2") {
            $ay = "Şubat";
        } elseif ($ay == "3") {
            $ay = "Mart";
        } elseif ($ay == "4") {
            $ay = "Nisan";
        } elseif ($ay == "5") {
            $ay = "Mayıs";
        } elseif ($ay == "6") {
            $ay = "Haziran";
        } elseif ($ay == "7") {
            $ay = "Temmuz";
        } elseif ($ay == "8") {
            $ay = "Ağustos";
        } elseif ($ay == "9") {
            $ay = "Eylül";
        } elseif ($ay == "10") {
            $ay = "Ekim";
        } elseif ($ay == "11") {
            $ay = "Kasım";
        } elseif ($ay == "12") {
            $ay = "Aralık";
        }
        return $ay;
    }

//========================================================================================================
    function sweetalert($title, $text, $islem, $url, $time)
    {
        echo "<script>
							swal({
										title: '$title',
										text: '$text',
										type:	'$islem',
										showConfirmButton: false
									});
									window.setTimeout(function() {
									window.location.href = '$url';
							}, $time);
					</script>";
    }

    function infoAlert(){
        return "<script>
                $(document).ready(function() {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 14000
                        };
                        toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');
            
                    }, 1300);
            
            
            
            
                });
            </script>";
    }
//========================================================================================================
    /*Youtube Video Link Format*/
    function YoutubeAutoLink($Url)
    {
        // force http: on www.
        $Url = str_ireplace("www.", "http://www.", $Url);
        // eliminate duplicates after force
        $Url = str_ireplace("http://http://www.", "http://www.", $Url);
        $Url = str_ireplace("https://http://www.", "https://www.", $Url);

        // The Regular Expression filter
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        // Check if there is a url in the text

        $m = preg_match_all($reg_exUrl, $Url, $match);

        if ($m) {
            $links = $match[0];
            for ($j = 0; $j < $m; $j++) {

                if (substr($links[$j], 0, 19) == 'http://www.youtube') {

                    //$Url=str_replace($links[$j],'<a href="'.$links[$j].'" rel="nofollow" target="_blank">'.$links[$j].'</a>',$Url).'<br /><iframe title="YouTube video player" class="youtube-player" type="text/html" width="320" height="185" src="http://www.youtube.com/embed/'.substr($links[$j], -11).'" frameborder="0" allowFullScreen></iframe><br />';
                    return true;

                } else {

                    return false;
                    //$Url=str_replace($links[$j],'<a href="'.$links[$j].'" rel="nofollow" target="_blank">'.$links[$j].'</a>',$Url);

                }

            }
        }
        return ($Url);
    }
//========================================================================================================

    function youtubeLinkShort($url){
        $youtubeUrl = explode("https://youtu.be/","$url");
        echo $youtubeUrl;
        //return ($youtubeUrl);
    }

//========================================================================================================
