<?php

error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

class NewObject extends Objectify\Object {


  public $x;
  private $y;

  function __construct() {
    $this->x = 1;
  }

  public function missing_method($n, $a) {
    echo 'OHNO';
  }




}



NewObject::define_method('testing', function(){
  if (isset($this->test)) {
    echo 'CALLED AGAIN'.PHP_EOL;
  }
  $this->test = true;
});

$x = NewObject::new();
$x->testing();
$x->testing();
$x->testing();

$x->define_instance_method('test2', function(){
  echo 'test2'.PHP_EOL;
});

$y = NewObject::new();
$x->test2();
$y->test2();
