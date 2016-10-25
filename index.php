<?php
/*
 * 工具入口类
 */
class start{
    protected $targetDir;//目标目录
    protected $outDir;//输出目录

    /*
     * 初始化工具
     * 检查输入参数是否正确
     */
    public function startting($argv, $argc){
        if($argc != 3){
            echo "参数不符合要求\n";
            exit();
        }else{
            $this->targetDir = $argv[1];
            $this->outDir = $argv[2];
            $this->scanDir();
        }
    }

    /*
     * 开始执行函数
     * string 目标目录 默认为空
     * string 输出目录 默认为空
     */
    public function scanDir($directory = "", $outdirectory = ""){
        empty($directory) && $directory = $this->targetDir;
        empty($outdirectory) && $outdirectory = $this->outDir;
        if(is_dir($directory) && is_dir($outdirectory)){
            include_once dirname(__FILE__)."/control/scanFile.php";
            include_once dirname(__FILE__)."/control/buildFile.php";
            include_once dirname(__FILE__)."/control/writeFile.php";
            $dir = new scanFile();
            $dirArr = $dir->scanFiles($directory);
            $build = new buildFile();
            $checkArr = $build->checkFiles($dirArr);
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
//工具初始化(使用命令行运行)
$start = new start();
$start->startting($argv, $argc);
