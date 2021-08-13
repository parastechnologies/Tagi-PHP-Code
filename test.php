<?php

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
class Model_Utils_Numcode
{
  private $nums;
  private $chars;
  private $numeral;

  /**
   * @param $string , String containing the chars that will be used for
   * the convension. !important each char can be present only once.
   */
  public function __construct()
  {
        $string="4fFiV8kRTvm5MPNDcyO1dg7lr20Qtn3X6pKLZUqaEsxCwubGYIzhSWJojHeA9B";
       $this->nums = str_split($string);
        $this->chars = array_flip($this->nums);
        if(count($this->nums) != count($this->chars))
        {
          throw new Exception("$string !important each char can be present only once.", 371);
        }
        $this->numeral = count($this->nums);
  }

public function test($string)
{
     $this->nums = str_split($string);
    $this->chars = array_flip($this->nums);
    if(count($this->nums) != count($this->chars))
    {
      throw new Exception("$string !important each char can be present only once.", 371);
    }
    $this->numeral = count($this->nums);
}
  /**
   * Encodes a number to a string
   * @param int $int
   * @return string
   */
  public function encode($int)
  {
    if(!is_int($int))
    {
      throw new Exception("$int is not integer.", 372);
    }
    return $this->convension($int, $this->numeral);
  }

  /**
   * Decodes a string to a number
   * @param string $string
   * @return number
   */
  public function decode($string)
  {
    $num = 0;
    $m = 1;
    $parts = str_split($string);
    $parts = array_reverse($parts);
    foreach($parts as $part)
    {
      if(!isset($this->chars[$part]))
      {
        throw new Exception("$part is not defined.", 373);
      }
      $num =  $num + $this->chars[$part] * $m;
      $m = $m * $this->numeral;
    }
    return $num;
  }

  /**
   * @see http://www.cut-the-knot.org/recurrence/conversion.shtml
   */
  private function convension($M,$N)
  {
    if($M  < $N)
    {
      return $this->nums[$M];
    }
    else
    {
      return $this->convension($M / $N, $N) . $this->nums[bcmod($M , $N)];
    }
  }

}


$Time=time();
echo $Time;

$numCode = new Model_Utils_Numcode();      
$num = $Time;
$encoded = $numCode->encode($num);

echo "<br/> $num encoded = $encoded";
// 3674 encoded = Ac

echo "<br/> $encoded decoded = ".$numCode->decode($encoded);
// Ac decoded = 3674


die;
echo "</br>";
$profile_url=$Time;
$seed = 1234567890;
mt_srand($seed);
echo $url = str_shuffle($profile_url);
echo "</br>";
 $sh = $url;  //print 'eloWHl rodl!'
echo "<br>";
echo "<br>";
echo $value=str_unshuffle($sh, $seed); //print 'Hello World!'
echo "</br>";
$date_from_timestamp = date("Y-d-m H:i:s",$value);
echo $date_from_timestamp;
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
/*echo "<br>";
$user_id=substr($value,0,4);
echo base64_decode($user_id)."------";
$type=substr($value,4,7);
echo str_rot13($type);
die;*/