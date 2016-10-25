<?php
class start{
    protected $targetDir;
    protected $outDir;

    public function startting($argv, $argc){
        if($argc != 3){
            echo "参数不符合要求\n";
            exit();
        }else{
            $this->targetDir = $argv[1];//dirname(dirname(__FILE__))."/onpsApi/Rest";
            $this->outDir = $argv[2];//dirname(dirname(__FILE__))."/onpsApi/doc";
            $this->scanDir();
        }
    }

    public function scanDir($directory = "", $outdirectory = ""){
        empty($directory) && $directory = $this->targetDir;
        empty($outdirectory) && $outdirectory = $this->outDir;
        if(is_dir($directory) && is_dir($outdirectory)){
            include_once dirname(__FILE__)."/control/scanFile.php";
            include_once dirname(__FILE__)."/control/buildFile.php";
            include_once dirname(__FILE__)."/control/writeFile.php";
            $dir = new scanFile();
            $dirArr = $dir->scanFiles($directory);
            // var_dump($dirArr['campusNewsType']);
            // exit();
            $build = new buildFile();
            $checkArr = $build->checkFiles($dirArr);//array("campusNewsType" => $dirArr['campusNewsType'], "adminMenu" => $dirArr['adminMenu'])
            $write = new writeFile();
            $write->writeContentsFiles($checkArr, $outdirectory);
        }elseif(is_dir($directory)){
            echo "输出目录不存在\n";
            exit();
        }else{
            echo "扫描目录不存在\n";
            exit();
        }
    }
}
$start = new start();
$start->startting($argv, $argc);
