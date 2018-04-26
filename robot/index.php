<?php
require_once __DIR__.'/vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

// Using Medoo namespace
use Medoo\Medoo;

$database = new Medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'icolist',
	'server' => '172.17.0.4',
	'port' => 3306,
	'username' => 'icolist',
	'password' => '8AS2GZcC5%jE1VpZ',
	'logging' => true

]);

/*

// Token tiker added

$data = $database->select('project_base','*');

for ($i=0; $i<count($data);$i++){


	$r = explode(' (', $data[$i]['name']);
	$r[1] = str_replace(')', '', $r[1]);

	$data[$i]['name'] = $r[0];
	$data[$i]['tiker'] = $r[1];

	$database->update('project_base', ['name' => $data[$i]['name'],
										'tiker' => $data[$i]['tiker']], ['id' => $data[$i]['id']]);

	var_dump($data[$i]);
	var_dump($database->error());
}
*/


$data = $database->select('project_base','*');




for ($i = 0; $i<count($data); $i++){
	$links = $database->select('project_links','*', ['link_name' => 'website', 
													 'project_id' => $data[$i]['id']]);

	if (count($links) > 0)
	{
		$html = file_get_contents($links[0]['link_url']);
		$dom = HtmlDomParser::str_get_html($html);

		$r = $dom->find('a');
		echo $links['link_url'].'<br />';

		foreach ($r as $r1){
			if (strpos($r1->href, 'mailto:') !== false)
			echo $r1->href.'<br />';
		}
	}

}



