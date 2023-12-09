<?php
function set_active($path, $active = 'border-indigo-500 text-white', $inactive = 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700') {
    // Get the current URI
    $currentUri = service('request')->uri->getPath();

    // Debug output
    log_message('error', 'Current URI: ' . $currentUri . ' | Expected path: ' . $path);

    // Check if the current URI matches the path
    if ($currentUri == $path) {
        return $active;
    } else {
        return $inactive;
    }
}
