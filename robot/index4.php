<?php
	
	/*
		Scrap builder
		
		*/
	
require_once __DIR__.'/vendor/autoload.php';

use PHPHtmlParser\Dom;

$url = 'https://www.coinschedule.com/icos/e1870/clearcoin-ico.html';

$html = file_get_contents($url);
$dom = new Dom;
$dom->load($html);


foreach ($dom->find('div[class=socials-list-container]') as $result){
	$i++;
	foreach ($result->find('ul[class=socials-list]') as $r){
		foreach ($r->find('li') as $z){
			echo $z->find('a')[0]->href;
			echo " ";
			//echo $z->find('img')[0]->src;
			//echo "\n";
			echo $z->find('span[class=linkType]')->text();
			echo "\n";
			//echo $z->innerHtml()."\n\n";
		}
	}
		//echo $r->innerHtml()."\n";
	//$z = $result->find('div[class=avatar-container]');
	//foreach($z as $r){
	//	echo $r->src."\n";
	//}
}	

/*	'team' => ['find' => 'div[class=team-list]', 'callback' => 
					['find' => 'div[class=item]', 'callback' =>
						['find' => 'div[class=avatar-container] img', 'callback' => 'src'],		
						['find' => 'div[class=description-container]', 'callback' => 
							['find' => 'span[class=name]', 'callback' => 'text'],		
							['find' => 'span[class=position]', 'callback' => 'text'],		
							['find' => 'div[class=toggle-text]', 'callback' => 'text']	
						]
					]
			  ]*/