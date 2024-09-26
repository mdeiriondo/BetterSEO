<?php
function debug_log($message)
{
    // if the $message is an object write to the log with pretty print
    if (is_array($message)) {
        $message = json_encode($message, JSON_PRETTY_PRINT);
    }
    // if the $message is json, then decode it and encode it again with the JSON_PRETTY_PRINT option
    else if (is_string($message) && is_array(json_decode($message, true)) && (json_last_error() == JSON_ERROR_NONE)) {
        $message = json_encode(json_decode($message, true), JSON_PRETTY_PRINT);
    }
    $log = fopen("debug.log", "a");
    fwrite($log, $message . "\n");
    fclose($log);
}
if (isset($_GET['file'])) {
    $filename = $_GET['file'];

    // Validate the file path to prevent directory traversal
    $allowedDirectory = dirname(__FILE__); // Get the directory of the current file
    $fullPath = realpath($allowedDirectory . '/' . $filename);

    if ($fullPath && is_file($fullPath) && pathinfo($filename, PATHINFO_EXTENSION) === 'php') {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fullPath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fullPath));
        readfile($fullPath);
        exit;
    } else {
        echo "File not found or not a PHP file.";
        debug_log("File not found or not a PHP file");
    }
} else {
    echo "Invalid request.";
    debug_log("Invalid request");
}
