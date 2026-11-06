<?php
session_start();

// Set the page parameter, default to 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

echo "<html><body>";
echo "<h1>Internal Employee Portal</h1>";
echo "<p>Welcome to the internal portal. Please upload your profile picture.</p>";

// --- 1. THE FILE UPLOAD FORM (Triggers session.upload_progress) ---
echo "<h2>Upload Profile Picture</h2>";
echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" enctype="multipart/form-data">';
echo '  <input type="file" name="profile_pic" />';
echo '  <input type="submit" value="Upload" name="submit" />';
echo '</form>';

// --- 2. THE VULNERABLE SINK (Local File Inclusion) ---
// This is the vulnerable part. It blindly includes whatever file is passed in ?page=
if (isset($_GET['page'])) {
    echo "<h2>Viewing Page: " . htmlspecialchars($page) . "</h2>";
    // The sink: include() executes PHP code found in the file
    if (file_exists($page)) {
        include($page);
    } else {
        echo "<p>Page not found.</p>";
    }
}

// --- 3. DEBUG INFO (Helps the AI see what is happening) ---
echo "<h2>Session Debug Data</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "</body></html>";
?>
