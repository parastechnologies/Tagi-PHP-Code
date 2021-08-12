<?php

	include("vcardexp.inc.php");
	
    $name=$_GET['name'];
	$phone=$_GET['phone'];
	$photo=$_GET['photo'];
	
	$test = new vcardexp;
	
	$test->setValue("firstName", $name);
	$test->setValue("tel_work", $phone);
	$test->copyPicture('profileImages/'.$photo);
	//$test->addPhoto('profileImages/'.$photo);
	$test->getCard();

?>