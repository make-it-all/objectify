<?php

// require '../lib/all.php';
require 'test_helper.php';

require '../lib/objectification/object.php';
require '../lib/objectification/traits/all.php';

class SizeMatters extends \Objectify\Object {
  use \Objectify\Traits\Comparable;

  function __construct($str) {
    $this->str = $str;
  }

  function compare($other) {
    return strlen($this->str) <=> strlen($other->str);
  }

}



$s1 = SizeMatters::new("Z");
$s2 = SizeMatters::new("YY");
$s3 = SizeMatters::new("XXX");
$s4 = SizeMatters::new("WWWW");
$s5 = SizeMatters::new("VVVVV");


test($s1->lt($s2) == true);
test($s4->is_between($s1, $s3) == false);
test($s4->is_between($s3, $s5) == true);
