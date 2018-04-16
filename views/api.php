<?php
include_once('methods.php');
$puzzle = new Crossword();

if(!empty($select = $_GET['selectedMatrix'])) {
	$puzzle->changeSelected($select);
	echo json_encode([
		'countWordAppers'	=> $puzzle->countWordAppers(),
		'selectedMatrix'	=> $select,
	]);
} else {
	echo json_encode([]);
}