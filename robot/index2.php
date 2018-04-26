<?php
/**
  *
  * Coinscedule base scrap
  *
  **/

require_once __DIR__.'/vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

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

//var_dump($database);

/*



project_base
id
name
description
project_type
platform
category
total_supply
start_date
end_date

CREATE TABLE project_base (id INTEGER AUTO_INCREMENT, PRIMARY KEY(id), name TEXT, description TEXT, project_type TEXT, platform TEXT, category TEXT, total_supply TEXT, start_date TIMESTAMP NULL DEFAULT NULL, end_date TIMESTAMP NULL default NULL);


project_links
id
project_id
link_name
link_url

CREATE TABLE project_links (id INTEGER AUTO_INCREMENT, PRIMARY KEY(id), project_id INTEGER NOT NULL, link_name TEXT, link_url TEXT);

project_team
id
project_id
name
position

CREATE TABLE project_team (id INTEGER AUTO_INCREMENT, PRIMARY KEY(id), project_id INTEGER NOT NULL, name TEXT, position TEXT);

project_team_links
id
team_id
link_name
link_url

CREATE TABLE project_team_links (id INTEGER AUTO_INCREMENT, PRIMARY KEY(id), team_id INTEGER NOT NULL, link_name TEXT, link_url TEXT);
*/



function parseICO($url, $db){
	$html = file_get_contents($url);
	$dom = HtmlDomParser::str_get_html($html);

	echo '<br />';
	echo '<img src="'.$dom->find('div[class=project-heading] img')[0]->src.'" height="48px" width="48px" />';
	echo 'Name: '.$dom->find('h1[class=inline]')[0]->text().'<br />';
	$project_base['name'] = $dom->find('h1[class=inline]')[0]->text();

	$r = explode(' (', $project_base['name']);
	$r[1] = str_replace(')', '', $r[1]);
	$project_base['name'] = $r[0];
	$project_base['tiker'] = $r[1];


	$project_base['image'] = $dom->find('div[class=project-heading] img')[0]->src;


	echo 'Description: '.$dom->find('div[class=project-desc]')[0]->innertext.'<br />';
	$project_base['description'] = $dom->find('div[class=project-desc]')[0]->innertext;

	foreach ($dom->find('div[class=projectinfo] div[class=infoitem]') as $t){
		if ($t->find('div[class=infolabel]')){
			$z = $t->find('div[class=infolabel]')[0]->text();
			$z = strtolower($z);
			$z = str_replace(' ', '_', $z);
		}
		if (!in_array($z,['distribution','details'])){
			echo $z.': ';
			if ($t->find('div[class=infovalue]')[0]) {
				if (in_array($z, ['website', 'whitepaper', 'bitcoin_talk'])){
					$r = $t->find('div[class=infovalue]')[0]->find('a');
					if ($r) echo '<a href="'.$r[0]->href.'" >'.$r[0]->href.'</a>';
					$other_links[$z] = $r[0]->href;
				}
				else {
					echo $t->find('div[class=infovalue]')[0]->text();
					$project_base[$z] = $t->find('div[class=infovalue]')[0]->text();
					
				}
				echo '<br />';
			}
		}
	}
	$project_base['start_date'] = date('Y-m-d H:i:s', strtotime($project_base['start_date']));
	$project_base['end_date'] = date('Y-m-d H:i:s', strtotime($project_base['end_date']));
	$project_base['total_supply'] = str_replace(',', '', $project_base['total_supply']);

	$db->insert('project_base', $project_base);
	$baseid =  $db->id();

	// links part one
	$other_keys = array_keys($other_links);
	for ($i=0; $i<count($other_links); $i++){
		$db->insert('project_links', [
						'project_id' => $baseid,
						'link_name' => $other_keys[$i],
						'link_url' => $other_links[$other_keys[$i]]
		]);
	}

	// Team Scrapping
	foreach ($dom->find('table[class=teamtable] tr') as $t){
		echo $t->find('td')[0]->innertext.'<br />';
		echo $t->find('td')[1]->innertext.'<br />';
		$team_base['name'] = $t->find('td')[0]->innertext;
		$team_base['position'] = $t->find('td')[1]->innertext;
		$team_base['project_id'] = $baseid;
		$db->insert('project_team', $team_base);
		$team_id = $db->id();
		if ($t->find('td')[2]){
			foreach ($t->find('td')[2]->find('a') as $l){
				echo '<a href="'.$l->href.'">'.$l->href.'</a><br />';
				$team_link['team_id'] = $team_id;
				$team_link['link_name'] = '';
				$team_link['link_url'] = $l->href;
				$db->insert('project_team_links', $team_link);
			}
		}
	}
	// Links Scrapping
	foreach ($dom->find('div[class=proj-link]') as $link){
		if ($link) {
			echo strtolower(str_replace(' Link', '', $link->find('img')[0]->getAttribute('alt'))).':';
			echo $link->find('a')[0]->href.'<br />';

			$project_links['project_id'] = $baseid;
			$project_links['link_name'] = strtolower(str_replace(' Link', '', $link->find('img')[0]->getAttribute('alt')));
			$project_links['link_url'] = $link->find('a')[0]->href;
			$db->insert('project_links', $project_links);
		}
	}
}

$url = 'https://www.coinschedule.com/?live_view=2';
$html = file_get_contents($url);
$dom = HtmlDomParser::str_get_html($html);

var_dump($html);

/*
foreach ($dom->find('div[class=list-container]') as $y){
	$table = $y->find('td');

	foreach ($table as $t){

		$s = HtmlDomParser::str_get_html($t->innertext);	
		if ($s)
		if ($s->find('table')[0]->innertext)
		{
			$r = HtmlDomParser::str_get_html($s->find('table')[0]->innertext);
			$url1 = $r->find('a')[0]->href;
			parseICO($url1, $database);
		}
	}
}
*/







