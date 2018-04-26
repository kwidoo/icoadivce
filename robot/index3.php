<?php
/*
	
	Coinscedule.com parser to database	
	
	*/	
	
	
require_once __DIR__.'/vendor/autoload.php';

$url = 'https://www.coinschedule.com/?live_view=2';

use PHPHtmlParser\Dom;

// Using Medoo namespace
use Medoo\Medoo;

$database = new Medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'icolist',
	'server' => '172.20.0.4',
	'port' => 3306,
	'username' => 'icolist',
	'password' => 'AuSkaKyXNFPAkTad',
	'logging' => true

]);

$parser = [
	'name' => ['find' => 'h1[class=prj-title]', 'callback' => 'extractText'],
//	'logo' => ['find' => 'div[class=logo-container] img', 'callback' => 'extractImg'],
	'start-date' => ['find' => 'div[class=start-date] span[class=date-text]', 'callback' => 'extractText'],
	'end-date' => ['find' => 'div[class=end-date] span[class=date-text]', 'callback' => 'extractText'],
	'details' => ['find' => 'p[class=project-detail]', 'callback' => 'extractText'],
	'characteristics' => ['find' => 'ul[class=characteristics-list]', 'callback' => 'extractList'],
	'links' => ['find' => 'div[class=socials-list-container]', 'callback' => 'extractLinks'],	
	'team' => ['find' => 'div[class=team-list]', 'callback' => "extractTeam"]

	];


function extractText($dom){
	//return $dom->text();
}
function extractImg($dom){
	return $dom->src;
}

function extractList($dom) {
	if (count($dom->find('li')) > 0){
		foreach ($dom->find('li') as $result)
		{
			$children = $result->getChildren();
			foreach ($children as $child){
				if (count($child->find('a')) > 0) 
					foreach ($child->find('a') as $link) echo $link->href;
				echo $child->text()." ";	
			}
			echo "\n";
		}
	}
	return ;
}

function extractLinks($dom) {
		foreach ($dom->find('ul[class=socials-list]') as $r){
			foreach ($r->find('li') as $z){
				echo $z->find('a')[0]->href;
				echo " ";
				//echo $z->find('img')[0]->src;
				//echo "\n";
				echo $z->find('span[class=linkType]')->text();
				echo "\n";
			}
		}
	
}

function extractTeam($dom){
	echo $dom->innerHtml();
}
	
function makeParse($dom, $key, $value){
	if (count($dom->find($value['find'])) > 0){
		echo $key."\n";
		foreach ($dom->find($value['find']) as $result)	{	
			$z = $value['callback']($result);
			echo $z."\n";
		}
		
	}	
}

function parseICO($url, $db, $parser) {

	$html = file_get_contents($url);
	$dom = new Dom;
	$dom->load($html);
	if ($dom) {
		foreach ($parser as $key => $value) {
			makeParse($dom, $key, $value);
		}
	}
}



$html = file_get_contents($url);
$dom = new Dom;
$dom->load($html);

// читаем основную страницу, весь список
foreach ($dom->find('div[class=list-container]') as $container){
	$table = $container->find('td');
	foreach ($table as $row){
		$a = $row->find('a')[0];
		if ($a) { 
			parseICO($a->href, $database, $parser);
		}
	}
}

