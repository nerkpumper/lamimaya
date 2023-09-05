# README #

This README would normally document whatever steps are necessary to get your application up and running.


<IfModule mod_rewrite.c>
#Este es un comentario
	RewriteEngine on	
	
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
<Files 403.shtml>
order allow,deny
allow from all
</Files>