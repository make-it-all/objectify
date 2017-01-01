<?php
/**
* Short Desc
*
*/

 namespace Objectify;

/**
 * The object class is the root of all other classes.
 *
 * It provides key functionallity for use by all other classes such as cloning
 * and inspecting all objects. This means that all Objectified objects have a
 * unified functionallity set.
 *
 */
class Object {

  /**
   * An objectified constructor for all classes. It exists to allow the creation
   * of objects to be immediately chained.
   *
   * @return Object new instance of the class
   */
  public static function new() {
    $args = func_get_args();
    $reflector = new \ReflectionClass(get_called_class());
    $instance = $reflector->newInstanceArgs($args);
    return $instance;
  }

  /**
   * Returns the class of the object
   *
   * @return string class of the object
   */
  public function class() {
    return get_class();
  }

  /**
   * Returns a copy of the object
   *
   * @return Object a cloned version of $this
   */
  public function clone() {
    return clone $this;
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
  public function object_id() {
    return spl_object_hash($this);
  }


  public function tap($callback) {
    call_user_func($callback, $this);
    return $this;
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

  public function instance_eval($closure) {
    $closure->call($this);
  }


  /*
    Methods!
    All things methods.
  */

  private $__instance_methods = [];
  protected static $__class_methods = [];

  public function public_methods() {
    return $this->reflect_methods(\ReflectionMethod::IS_PUBLIC);
  }
  public function protected_methods() {
    return $this->reflect_methods(\ReflectionMethod::IS_PROTECTED);
  }
  public function private_methods() {
    return $this->reflect_methods(\ReflectionMethod::IS_PRIVATE);
  }
  public function static_methods() {
    return $this->reflect_methods(\ReflectionMethod::IS_STATIC);
  }
  private function reflect_methods($modifiers=null) {
    $class = new \ReflectionClass($this->class());
    $methods = $class->getMethods($modifiers);
    return array_map(function($el) {return $el->name;}, $methods);
  }
  public function dynamic_methods() {
    $class = array_keys(static::$__class_methods);
    $instance = array_keys($this->__instance_methods);
    return array_merge($class, $instance);
  }
  public function methods() {
    $public = $this->public_methods();
    $protected = $this->protected_methods();
    $dynamic = $this->dynamic_methods();
    return array_merge($public, $protected, $dynamic);
  }
  public function method($name) {
    if (in_array($this->methods(), $name)) {
      return Method::new($this->$name);
    } else {
      throw new NameException();
    }
  }
  public static function define_method($name, $body) {
    static::$__class_methods[$name] = $body;
  }
  public function define_instance_method($name, $body) {
    $this->__instance_methods[$name] = $body;
  }
  /**
   * Calls a method indicated by *$method_name*
   *
   * @param string $method_name the name of the method to call.
   * @param mixed $arguments arguments to pass to the method.
   *
   * @return Object
   */
  public function send($method_name, ...$arguments) {
    return $this->$method_name(...$arguments);
  }

  /**
   * Returns whether the *$method_name* is defined within the object and is callable
   *
   * @param string $method_name the name of the method to check.
   *
   * @return boolean
   */
  public function responds_to($method_name) {
    return in_array($method_name, $this->methods());
  }

  public final function __call_dynamic_method($method_name, $arguments) {
    if (in_array($method_name, $this->dynamic_methods())) {
      if (array_key_exists($method_name, $this->__instance_methods)) {
        $method_arr = $this->__instance_methods;
      } else {
        $method_arr = static::$__class_methods;
      }
      return $method_arr[$method_name]->call($this, ...$arguments);
    }
  }

  /* If a method call is made to an unknown method then check the methods list.
    If its found there then call that method in the context of this object.
  */
  public final function __call($method_name, $arguments) {
    if (in_array($method_name, $this->dynamic_methods())) {
      return $this->__call_dynamic_method($method_name, $arguments);
    } elseif ($this->responds_to('missing_method')) {
      return $this->missing_method($method_name, $arguments);
    } else {
      trigger_error('Call to undefined method '.__CLASS__.'::'.$method_name.'()', E_USER_ERROR);
    }
  }


}
