<?php

$host = $_SERVER['HTTP_HOST'];
preg_match('/[^\.]+\.([^\.]{4}|[^\.]{3}|(co|or|pe|ac|ne)\.[^\.]{2}|[^\.]{2})$/i', $host, $matches);
$domain        = $matches[0];
$sub_domain    = ($host!=$domain)?str_replace(".{$domain}", "", $host):"";
$full_domain	= $sub_domain;

if(strlen($domain)>0){
	$full_domain	= $full_domain . '.'. $domain;
}

$_ThinQDomainArr = array(
    'qa-nthinq.developer.lge.com' ,
    'dv-nthinq.developer.lge.com' ,
    'nthinq.developer.lge.com' , 
    'dv-thinqapp.developer.lge.com' ,
    'qa-thinqapp.developer.lge.com' ,
    'thinqapp.developer.lge.com' ,
    'dv-ai.developer.lge.com' ,
    'qa-ai.developer.lge.com' ,
    'ai.developer.lge.com' ,
);

$_CloudDomainArr = array(
    'qa-thinq.developer.lge.com' ,
    'dv-thinq.developer.lge.com' ,
    'thinq.developer.lge.com' ,    
);


if(in_array( $full_domain , $_ThinQDomainArr)) {
	$URI = $_SERVER['REQUEST_URI'];
	if($URI == '' || $URI == '/'){
		$userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		switch($userLang) {
			case 'ko' :
				$tLang = 'ko';
				break;
			default :
				$tLang = 'en';
		}
		header("Location: /$tLang" . '/');
		exit;
	}
}
//thinq.cloud redirect 
if(in_array( $full_domain , $_CloudDomainArr)) {
    $URI = $_SERVER['REQUEST_URI'];
    $uris = explode('/',$URI);
    
    if(($uris[2] != 'cloud' && ($uris[1] == 'ko' || $uris[1] == 'en')) || $uris[1] == ''){
        
        if($uris[1] == 'ko' || $uris[1] == 'en'){
            $tLang = $uris[1];
        }else{
            $userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            switch($userLang) {
                case 'ko' :
                    $tLang = 'ko';
                    break;
                default :
                    $tLang = 'en';
            }
        }
        header("Location: /$tLang" . '/cloud/');
        exit;
    }
}


require('concrete/dispatcher.php');