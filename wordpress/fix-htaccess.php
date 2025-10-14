<?php
// Script to fix .htaccess for permalinks

$htaccess_content = '# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress';

file_put_contents('/var/www/html/.htaccess', $htaccess_content);
chmod('/var/www/html/.htaccess', 0644);

echo "✓ .htaccess file has been created with proper rewrite rules\n";
echo "\nThe About Us page should now be accessible at:\n";
echo "http://localhost:8000/chung-toi/\n";
?>