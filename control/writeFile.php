<?php
/*
 * 将创建好的文档写入文件
 */
class writeFile{
    /*
     * 将创建好的文档写入文件
     * array Arr 创建好的文档
     * string dir 写入目录
     */
    public function writeContentsFiles($Arr, $dir){
        if(empty($Arr)){
            echo "替换失败\n";
            exit();
        }else{
            $this->dirToDir('./templates/css', $dir);
            $this->dirToDir('./templates/js', $dir);
            $tplMenu = 'templates/index.html';
            $indextpl = file_get_contents($tplMenu);//读取模板文件的内容
            $indextpl = str_replace('{$time}', date("Y-m-d H:i:s"), $indextpl);
            $indextpl = str_replace('{$menu}', $Arr['menu'], $indextpl); //用具体数据来替换模板标签
            file_put_contents($dir.'/index.html',$indextpl);//将替换后的内容写进html文件中

            $tplMenuList = 'templates/iframe.html';
            $iframetpl = file_get_contents($tplMenuList);
            $iframetpl = str_replace('{$menuList}', $Arr['menuList'], $iframetpl);
            file_put_contents($dir.'/iframe.html',$iframetpl);
            // var_dump($Arr['info']);
            // exit();
            foreach($Arr['info'] as $key => $value){
                $tplSencond = 'templates/sencond.html';
                $sencondtpl = file_get_contents($tplSencond);
                $sencondtpl = str_replace('{$title}', $value['title'], $sencondtpl);
                $sencondtpl = str_replace('{$GetMethod}', $value['GetMethod'], $sencondtpl);
                $sencondtpl = str_replace('{$PostMethod}', $value['PostMethod'], $sencondtpl);
                $sencondtpl = str_replace('{$PutMethod}', $value['PutMethod'], $sencondtpl);
                $sencondtpl = str_replace('{$DeleteMethod}', $value['DeleteMethod'], $sencondtpl);
                file_put_contents($dir.'/'.$value['title'].'.html',$sencondtpl);
            }
        }
    }

    public function fileToDir($sourcefile, $dir){
        if(is_dir($sourcefile)){
            return dir2dir($sourcefile, $dir);
        }
        if(!file_exists($sourcefile)){
            echo "目标目录不可写";
            exit();
        }
        $filename = basename($sourcefile);
        return copy($sourcefile, $dir.'/'.$filename);
    }
    public function dirToDir($sourcedir, $dir){
        if(!is_dir($sourcedir) || !is_dir($dir)){
            echo "目录不正确";
            exit();
        }
        // 要复制到新目录
        $newPath = $dir.'/'.basename($sourcedir);
        if(!realpath($newPath)){
            mkdir($newPath);
        }
        foreach(glob($sourcedir.'/*') as $filename){
            var_dump($this->fileToDir($filename, $newPath));
        }
    }
}
