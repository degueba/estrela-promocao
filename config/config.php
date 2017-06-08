<?php
session_start();

define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PASS', '' );
define( 'DB_NAME', 'original_promocao' );
//define( 'SEND_ERRORS_TO', 'fabiano.miranda@originalmedia.com.br' );
define( 'DISPLAY_DEBUG', false );

define( 'ROOT', __DIR__.'/../' );
define( 'ROOT_WEB', __DIR__.'/ ../public/' );
define( 'PATH_TEMPLATES', ROOT.'templates/');
define( 'PATH_BLOCKS', ROOT.'templates/blocks/');

define( 'TITLE_PAGE', 'Título');

// CONFIGS DA PROMOÇÃO
define( 'VALOR_GASTO_POR_CUPOM', 80);
