<?php
class scanFile{
    public function scanFiles($directory){
        $arr = scandir($directory);
        $scandirArr = array();
        foreach($arr as $key => $value){
            if($value != "." && $value != ".." && !strpos($value, ".class.php")){
                $scandirArr[$value]['url'] = $value.".html";
            }
        }
        // var_dump($scandirArr);
        // echo "<br>";
        $dn = @opendir($directory);
        while($file = readdir($dn)){
            if(is_file("$directory/$file")){
                continue;
            }
            $scanfileArr = scanDir("$directory/$file");
            foreach($scanfileArr as $key => $value){
                if($value != "." && $value != ".."){
                    $httpType = str_replace($file, "", substr($value, 0, strlen($value)-10));
                    $matches = array();
                    preg_match_all("/\/\*\*([\s\S]*?)\*\//", file_get_contents("$directory/$file/$value"), $matches);
                    foreach($matches[1] as $key => $value){
                        $params = array();
                        $param = explode("*", $value);
                        $paramTitle = trim($param[1]);
                        $paramInfo = trim($param[3]);
                        foreach($param as $k => $v){
                            if(strpos($v, "@")){
                                $tag = explode(" ", trim($v));
                                switch ($tag[0]) {
                                    case '@final':
                                        $final = $tag[1];
                                        break;
                                    case '@author':
                                        $author = $tag[1];
                                        break;
                                    case '@param':
                                        $params[] = substr(trim($v), 7);
                                        break;
                                    case '@version':
                                        $version = $tag[1];
                                        break;
                                }
                            }
                        }
                        if($final == "class"){
                            $scandirArr[$file]['httpType'][$httpType] = $paramTitle;
                            $scandirArr[$file]['class'][$httpType]['class']['author'] = isset($author) ? $author : '';
                            $scandirArr[$file]['class'][$httpType]['class']['title'] = $paramTitle;
                            $scandirArr[$file]['class'][$httpType]['class']['info'] = $paramInfo;
                            $scandirArr[$file]['class'][$httpType]['class']['final'] = $final;
                            $scandirArr[$file]['class'][$httpType]['class']['version'] = isset($version) ? $version : '';
                        }elseif($final == "function"){
                            $temp['title'] = $paramTitle;
                            $temp['info'] = $paramInfo;
                            $temp['final'] = $final;
                            $temp['params'] = $params;
                            $scandirArr[$file]['class'][$httpType]['method'][] = $temp;
                        }
                        // var_dump($param);
                        // exit();
                    }
                }
            }
        }

        return $scandirArr;
    }
}
