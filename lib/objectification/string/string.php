<?php namespace Objectify;

class Str extends Object implements \ArrayAccess {

  function __construct($value) {
    $this->value = (string)$value;
  }

  public static function try_convert($obj) {
    if ($obj === null || is_scalar($obj) || is_callable([$obj, '__toString'])) {
      return new static($obj);
    } else {
      return null;
    }
  }

  public function length() {
    return strlen($this->value);
  }

  // ArrayAccess methods

  public function offsetExists($offset) {
    return $offset > 0 && $offset < $this->length();
  }

  public function offsetGet ($offset) {
    return $this->value[$offset];
  }

  public function offsetSet ($offset ,$value) {
    return $this->value->offsetSet($offset, $value);
  }

  public function offsetUnset ($offset) {
    return $this->value->offsetUnset($offset, $value);
  }

  function __toString() {
    return $this->value;
  }

}
