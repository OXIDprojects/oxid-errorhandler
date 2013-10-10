<?php

$sMetadataVersion = '1.1';

$aModule = array(
    'id'           => 'agintraship',
    'title'        => 'Better Error Handler',
    'description'  => 'Shows better error messages',
    'version'      => '1.0',
    'author'       => 'Aggrosoft',
    'url'		   => 'http://www.ecomponents.de',
    'extend'      => array(
        'oxexceptionhandler' => 'agerrorhandler/extensions/agerrorhandler_oxexceptionhandler'
    ),
    'files'        =>  array(
        'errortest' => 'agerrorhandler/controllers/errortest.php',
        'geshi' => 'agerrorhandler/geshi.php'
    ),
    'templates'    => array(
        'error.tpl'  => 'agerrorhandler/out/azure/tpl/error.tpl',
        'traces.tpl'  => 'agerrorhandler/out/azure/tpl/traces.tpl',
        'trace.tpl'  => 'agerrorhandler/out/azure/tpl/trace.tpl'
    )
    
    
);
?>
