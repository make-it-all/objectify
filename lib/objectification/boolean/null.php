<?php namespace Objectify;


class Null extends Objectify\Object {

  function to_s() {
    return new String()
  }

  function to_f() {
    return new Float(0.0);
  }

  function to_i() {
    return new Integer(0);
  }

  function to_arr() {
    return []
  }

  function to_a() {
    return new Arr([])
  }

  function to_h() {
    return new Hash([])
  }

  function to_bool() {
    return new FalseClass();
  }

}
