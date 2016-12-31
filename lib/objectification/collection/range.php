<?php namespace Objectify\Collection;

class Range extends \Objectify\Object {
  use \Objectify\Traits\Enumerable;


  private $start;
  private $end;

  function __construct($start, $end) {
    $this->start = $start;
    $this->end = $end;
  }

  //returns the first object in range
  public function start() {
    return $this->start;
  }

  //returns the last object in range
  public function end() {
    return $this->end;
  }

  public function includes($element) {

  }

  //calls $callback on each element of the range in turn of returns an enumerable
  // if a callback isnt given.
  public function each($callback=null) {
  }

  public function is_equal($range) {
    if (!($range instanceof Range)) return false;
    return $range->start()==$this->start() && $range->end() == $this->end();
  }
#eql?
#exclude_end?
#first
#hash
#include?
#inspect
#last
#max
#member?
#min
#size
#step
#to_s

}
