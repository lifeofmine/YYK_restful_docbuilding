<?php
/*
 * 创建文档
 */
class buildFile{
    /*
     * 根据扫描出来的内容创建文档
     * array dirArr 扫描内容
     */
    public function checkFiles($dirArr){
        if(empty($dirArr)){
            echo "扫描目录失败\n";
            exit();
        }else{
            $menu = "";
            $menuList = "";
            $outFiles = array();
            foreach($dirArr as $key => $value){
                $url = $value['url'];
                $name = $key;
                $menu .= "<ul><li><a href='$url'>$name</a></li>";
                $hmenu = "";
                foreach($value['httpType'] as $hk => $hv){
                    $hmenu .= "<li>$hk</li><li>$hv</li><li>&nbsp;</li>";
                }
                $menu .= $hmenu."</ul>";
                $menuList .="<li><span class='left-menu-icon'>-</span><a href='$url' target='_parent'>$name</a></li>";
                $GetMethod = "";
                $PostMethod = "";
                $PutMethod = "";
                $DeleteMethod = "";
                foreach($value['class'] as $ck => $cv){
                    $method = "";
                    foreach($cv as $mk => $mv){
                        if($mk == "class"){
                            $method .= "<div style='border-bottom: 1px solid #e7e7e7;'>";
                            $method .= "<h4>$mv[title]</h4><ul><li>描述</li><li>$mv[info]</li></ul>";
                            if(isset($mv['author'])){
                                $method .= "<ul><li>作者</li><li>$mv[author]</li></ul>";
                            }
                            if(isset($mv['version'])){
                                $method .= "<ul><li>版本</li><li>$mv[version]</li></ul>";
                            }
                            $method .= "</div>";
                        }elseif($mk == "method"){
                            foreach($mv as $mmk => $mmv){
                                $method .= "<div style='border-bottom: 1px solid #e7e7e7;'>";
                                $method .= "<h4>$mmv[title]</h4><ul><li>描述</li><li>$mmv[info]</li></ul>";
                                if(isset($mmv['params'])){
                                    foreach($mmv['params'] as $tk => $tv){
                                        $params = explode(" ", $tv);
                                        $method .= "<ul><li>$params[1]</li><li>$params[0]</li><li>$params[2]</li></ul>";
                                    }
                                }
                                $method .= "</div>";
                            }
                        }
                    }
                    switch($ck){
                        case 'Get':
                            $GetMethod = $method;
                            break;
                        case 'Post':
                            $PostMethod = $method;
                            break;
                        case 'Put':
                            $PutMethod = $method;
                            break;
                        case 'Delete':
                            $DeleteMethod = $method;
                            break;
                    }
                }
                $temp['title'] = $name;
                $temp['GetMethod'] = $GetMethod;
                $temp['PostMethod'] = $PostMethod;
                $temp['PutMethod'] = $PutMethod;
                $temp['DeleteMethod'] = $DeleteMethod;
                $outFiles['info'][] = $temp;
            }
            $outFiles['menu'] = $menu;
            $outFiles['menuList'] = $menuList;
            return $outFiles;
        }
    }
}
