<?php namespace Objectify\Collection;

class Enumerator extends \Objectify\Object {
  use \Objectify\Traits\Enumerable;

  public function __construct($yielder_or_enumerable, $method='each') {
    if (is_callable($yielder_or_enumerable)) {
      $this->__constructor_with_generator($yielder_or_enumerable, $method);
    } else {
      $this->__constructor_with_enum_and_method($yielder_or_enumerable, $method);
    }
  }

  public function __constructor_with_enum_and_method($enum, $method) {
    $this->enumerable = $enum;
    $this->method = $method;
  }

  public function __constructor_with_generator($generator) {
    echo "GEN";
  }

  function to_s() {
    $x = (string)$this->enumerable;
    return "<enum $x:$this->method>";
  }




  public function each($block=null) {
    if (empty($block)) return $this;

    foreach(($this->yielder)() as $el) {
      $block($el);
    }

    return $this;
  }
  #TODO possibly?:
  #each_with_index
  #each_with_object
  #feed
  #inspect
  #next
  #next_values
  #peek
  #peek_values
  #rewind
  #size
  #with_index
  #with_object
}
