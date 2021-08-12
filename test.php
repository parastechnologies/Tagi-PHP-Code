<?php
$url = 'https://contribute.geeksforgeeks.org/wp-content/uploads/gfg-40.png';
  
// Use basename() function to return the base name of file 
$file_name = basename($url);
   
// Use file_get_contents() function to get the file
// from url and use file_put_contents() function to
// save the file by using base name
if(file_put_contents( $file_name,file_get_contents($url))) {
    echo "File downloaded successfully";
}
else {
    echo "File downloading failed.";
}

die;
/*$text="Public";
$encrypt=gzcompress($text);
echo $encrypt."--";
$baseEncode=base64_encode($encrypt);
echo $baseEncode."----------------";

$baseDecode=base64_decode($baseEncode);
echo $baseDecode."--";

$decrypt=gzuncompress($baseDecode);
echo $decrypt;*/
/*$id=99;
$idd=base64_encode($id);
 $test=str_rot13("UBP");
$profile_url=$idd.$test;
echo $profile_url;
echo "<br>";*/

$profile_url="MlzxHCC";
$seed = 1234567890;
mt_srand($seed);

echo $sh = "MlzxHCC";  //print 'eloWHl rodl!'
echo "<br>";
echo "<br>";
echo $value=str_unshuffle($sh, $seed); //print 'Hello World!'

function str_unshuffle($str, $seed){
    $unique = implode(array_map('chr',range(0,254)));
    $none   = chr(255);
    $slen   = strlen($str);
    $c      = intval(ceil($slen/255));
    $r      = '';
    for($i=0; $i<$c; $i++){
        $aaa = str_repeat($none, $i*255);
        $bbb = (($i+1)<$c) ? $unique : substr($unique, 0, $slen%255);
        $ccc = (($i+1)<$c) ? str_repeat($none, strlen($str)-($i+1)*255) : "";
        $tmp = $aaa.$bbb.$ccc;
        mt_srand($seed);
        $sh  = str_shuffle($tmp);
        for($j=0; $j<strlen($bbb); $j++){
            $r .= $str{strpos($sh, $unique{$j})};
        }
    }
    return $r;
}
//echo str_rot13($test);
echo "<br>";
$user_id=substr($value,0,4);
echo base64_decode($user_id)."------";
$type=substr($value,4,7);
echo str_rot13($type);
die;