<?php
require_once __DIR__.'/vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

// Using Medoo namespace
use Medoo\Medoo;

$database = new Medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'gtifinan_joom787',
	'server' => 'localhost',
	'username' => 'gtifinan_joom787',
	'password' => '8AS2GZcC5%jE!VpZ',
	'logging' => true

]);

$r = $database->select('mk6bn_project_base','*');
$i = 0;

$database->query('DELETE FROM mk6bn_content');
$database->query('DELETE FROM mk6bn_fields_values');
$database->query('ALTER TABLE mk6bn_content AUTO_INCREMENT=1');

foreach ($r as $r1)
{
	$i++;


	if (date('U') > strtotime($project_base[$i]['start_date']) && date('U') < strtotime($project_base[$i]['end_date'])) {
	    $catid = 17;
	}
	if (date('U') < strtotime($project_base[$i]['start_date'])) {
	    $catid = 18;
	}
	if (date('U') > strtotime($project_base[$i]['end_date'])) {
	    $catid = 19;
	}

	$t = explode(' (', $r1['name']);
	$alias = strtolower('ico_'.str_replace(' ', '_', $t[0]));
	$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $r1['image']));
	file_put_contents('../images/ico/'.$alias.'.png', $image);

	$database->insert('mk6bn_content', ['title' => $t[0],
										'alias' => $alias,
										'introtext' => $r1['description'],
										'asset_id' => $i,
										'state' => 1,
										'catid' => $catid,
										'created_by' => 316,
										'created' => '2018-01-04 19:14:26',
										'modified_by' => 316,
										//'checked_out' => 316,
										'checked_out_time' => '2018-01-04 19:14:26',
										'publish_up' => '2018-01-04 19:14:26',
										'images' => '{"image_intro":"../images/ico/'.$alias.'.png","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}',
										'urls' => '{"urla":false,"urlatext":"","targeta":"","urlb":false,"urlbtext":"","targetb":"","urlc":false,"urlctext":"","targetc":""}',
										'attribs' => '{"article_layout":"","show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_associations":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_page_title":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":""}',
										'access' => 1,
										'metadata' => '{"robots":"","author":"","rights":"","xreference":""}',
										'language' => '*'
	]);
	
    $z = $database->id();
    if ($s > 0)
    $database->insert('mk6bn_fields_values', ['field_id' => 1,
    										 'item_id' => $z,
    										 'value' => $s]);
}