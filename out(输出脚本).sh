#!/bin/bash
outDir=/home/wwwroot/default/onpsApi/doc
scanDir=/home/wwwroot/default/onpsApi/Rest
phpDoc=/home/wwwroot/default/document
cd ${phpDoc}
/usr/bin/php index.php ${scanDir} ${outDir} 

