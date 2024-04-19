<?php 
$dirPath = 'output/';
$files = scandir($dirPath, SCANDIR_SORT_DESCENDING);
$files = array_diff($files, array('.', '..'));

usort($files, function($a, $b) use ($dirPath) {
  return filemtime($dirPath . $b) - filemtime($dirPath . $a);
});

$files = array_slice($files, 0, 12);
$filePaths = [];
foreach($files as $file) {
    $filePath = $dirPath . $file;
    $filePaths[] = $filePath;
}

echo json_encode($filePaths);