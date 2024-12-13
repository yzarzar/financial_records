<?php
function include_view($filename)
{
    $filePath = __DIR__ . '/../View/' . $filename;
    if (file_exists($filePath)) {
        include($filePath);
    } else {
        return 'Error: File not found.';
    }
}
?>
