<?php
session_start();

define( 'DB_HOST', 'om1-cluster.cluster-cgqxoedczlj5.us-east-1.rds.amazonaws.com' );
define( 'DB_USER', 'estrela' );
define( 'DB_PASS', ').02f74qz+20PRF' );
define( 'DB_NAME', 'estrela80anos' );
//define( 'SEND_ERRORS_TO', 'fabiano.miranda@originalmedia.com.br' );
define( 'DISPLAY_DEBUG', false );

define( 'ROOT', __DIR__.'/../' );
define( 'ROOT_WEB', __DIR__.'/ ../public/' );
define( 'PATH_TEMPLATES', ROOT.'templates/');
define( 'PATH_BLOCKS', ROOT.'templates/blocks/');

define( 'TITLE_PAGE', 'Título');

// CONFIGS DA PROMOÇÃO
define( 'VALOR_GASTO_POR_CUPOM', 80);
