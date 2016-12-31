<?php

// require '../lib/all.php';
require 'test_helper.php';

require '../lib/all.php';

// class ArrayWrapper extends \Objectify\Object {
//   use \Objectify\Traits\Enumerable;
//
//   function __construct($values) {
//     $this->values = $values;
//   }
//
//   function each($block=null) {
//     return \Objectify\Collection\Enumerator::new()
//     if ($block==null) {
//       foreach($this->values as $value) {
//         yield $value;
//       }
//     } else {
//       foreach($this->values as $value) {
//         $block($value);
//       }
//     }
//   }
//
// }
//
//
//
// $nums = ArrayWrapper::new([1,2,3,4,5,6,7,8,9,10]);
// $nums->each();
//
// var_dump($nums->each());


$arr = Arr::new([1,2,3]);

$x = \Objectify\Collection\Enumerator::new($arr);

echo $x->map->map->map->each;
