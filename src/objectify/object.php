<?php namespace Objectify;

class Object {

  public static function new() {
    $args = func_get_args();
    $reflector = new \ReflectionClass(get_called_class());
    return $reflector->newInstanceArgs($args);
  }

  public function class() {
    return get_class($this);
  }
  public function clone() {
    return clone $this;
  }
  public function display($output=STDOUT) {
    fwrite($output, $this);
  }
  public function is_equal($other) {
    return $this->is_eql($other);
  }
  public function inspect() {
    $name = $this->class();
    $hash = $this->object_id();
    $variables_list = $this->instance_variables();
    $variables = implode(array_map(function($el){ return " $$el={$this->$el}"; }, $variables_list));
    return "#<$name:$hash$variables>";
  }
  public function is_instance_of($cls) {
    return $this instanceof $cls;
  }
  public function is_instance_variable_defined($name) {
    return property_exists($this, $name);
  }
  public function instance_variable_get($name) {
    return $this->$name;
  }
  public function instance_variable_set($name, $value) {
    return $this->$name = $value;
  }
  public function instance_variables() {
    return array_keys(get_object_vars($this));
  }
  public function is_a($cls) {
    return ($this instanceof $cls) || is_subclass_of($this, $cls);
  }
  public function itself() {
    return $this;
  }
  public function is_kind_of($cls) {
    return $this->is_a($cls);
  }
  public function method($name) {
    if (in_array($this->methods(), $name)) {
      return Method::new($this->$name);
    } else {
      throw new NameException();
    }
  }
  public function methods() {
    $class = new \ReflectionClass($this);
    $methods = $class->getMethods(
        \ReflectionMethod::IS_PUBLIC |
        \ReflectionMethod::IS_PROTECTED
    );
    return array_map(function($el) {return $el->name;}, $methods);
  }
  public function is_nil() {
    return false;
  }
  public function object_id() {
    return spl_object_hash($this);
  }
  public function private_methods() {
    $class = new \ReflectionClass($this);
    $methods = $class->getMethods(\ReflectionMethod::IS_PRIVATE);
    return array_map(function($el) {return $el->name;}, $methods);
  }
  public function protected_methods() {
    $methods = $class->getMethods(\ReflectionMethod::IS_PROTECTED);
    return array_map(function($el) {return $el->name;}, $methods);
  }
  public function public_methods() {
    $class = new \ReflectionClass($this);
    $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
    return array_map(function($el) {return $el->name;}, $methods);
  }
  public function responds_to($method_name) {
    return in_array($method_name, $this->methods());
  }
  public function responds_to_missing() {
    return method_exists($this, '__call');
  }
  public function send($method_name) {
    $args = func_get_args();
    array_shift($args);
    return call_user_func_array([$this, $method_name], $args);
  }
  public function tap($callback) {
    call_user_func($callback, $this);
    return $this;
  }

  public function __get($name) {
    if ($this->responds_to($name)) {
      return $this->$name();
    } else {
      parent::__get($name);
    }
  }

  public function to_s() {
    if (isset($this) && is_a($this, __CLASS__))  {
      $name = $this->class();
      $hash = $this->object_id();
      return "#<$name:$hash>";
    } else {
      return get_called_class();
    }
  }
  public function __toString() {
    return $this->to_s();
  }
}
