<?php //namespace Objectify\Collection;

class Arr extends \Objectify\Object implements \ArrayAccess {
  use \Objectify\Traits\Enumerable;


  private $value;

  public function __construct($arr_or_len=0, $elem=null) {
    if ($arr_or_len instanceof Arr) {
      $this->value = $arr_or_len->to_raw_a();
    } else {
      $arr = Arr::try_convert_primative($arr_or_len);
      if ($arr) $this->value = $arr;
      else {
        $this->value = array_fill(0, $arr_or_len, $elem);
      }
    }
  }

  public static function try_convert($value) {
    if (is_array($value)) {
      return Arr::new($value);
    } else if ($value instanceof Object && $value->responds_to('to_a')) {
      return Arr::new($value->to_a());
    } else {
      return null;
    }
  }

  public static function try_convert_primative($value) {
    if (is_array($value)) {
      return $value;
    } else if ($value instanceof Object && $value->responds_to('to_a')) {
      return $value->to_raw_a();
    } else {
      return null;
    }
  }

  public function each(){}


  public function offsetExists($offset) {
    return $offset > 0 && $offset < $this->length();
  }

  public function offsetGet ($offset) {
    var_dump($offset);
    return $this->value[$offset];
  }

  public function offsetSet ($offset ,$value) {
    return $this->value->offsetSet($offset, $value);
  }

  public function offsetUnset ($offset) {
    return $this->value->offsetUnset($offset, $value);
  }

  public function join($del='') {
    return implode($del, $this->value);
  }

  public function to_s() {
    return "[{$this->join(', ')}]";
  }

  public function to_a(){
    return $this;
  }

  public function to_raw_a() {
    return $this->value;
  }

}
