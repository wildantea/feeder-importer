<?php
// Include PHPExcel library
require_once '../../lib/PHPExcel.php';
require_once '../../lib/Writer.php';
$xls = new XLSXWriter();
// Add data to the first sheet
$xls->addSheet('Sheet 1');
$xls->writeSheetRow(0, array('Header 1', 'Header 2', 'Header 3'));

// Add a comment to cell A2
$xls->addComment(0, 1, 0, 'This is a comment for cell A2');

// Save the file
$xls->write('example_with_comments.xlsx');