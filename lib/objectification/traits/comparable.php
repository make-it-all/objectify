<?php namespace Objectify\Traits;

  /* The comparable trait gives orderable objects comparison functions
    The object must define a method called `compare` which compares itself with
    another object which is passed to it.
  */
  trait Comparable{

    /*
      The compare method should:
        return -1 if self is smaller or comes before other
        return 0 if both objects are equal
        return 1 if self is larger or comes after other
    */
    abstract public function compare($other);

    /* returns true if `compare` is 0 and thus $self is equal to $other
      arg: $other -> the object to compare $self against
      return: boolean
    */
    public function eq($other) {
      return $this->compare($other)==0;
    }
    /* returns true if `compare` is -1 and thus $self is less than $other
      arg: $other -> the object to compare $self against
      return: boolean
    */
    public function lt($other) {
      return $this->compare($other)==-1;
    }

    /* returns true if `compare` is 1 and thus $self is greater than $other
      arg: $other -> the object to compare $self against
      return: boolean
    */
    public function gt($other) {
      return $this->compare($other)==1;
    }

    /* returns true if `compare` is not 1 and thus $self is less than or equal to $other
      arg: $other -> the object to compare $self against
      return: boolean
    */
    public function lteq($other) {
      return $this->compare($other)!=1;
    }

    /* returns true if `compare` is not -1 and thus $self is greater than or equal to$other
      arg: $other -> the object to compare $self against
      return: boolean
    */
    public function gteq($other) {
      return $this->compare($other)!=-1;
    }

    /* returns true if $self is between (inclusive) $min and $max
      $self compared with $min is >= 0 and $self compared with $max is <= 0
      arg: $min -> the lower bound of the test
      arg: $max -> the upper bound of the test
      return: boolean
    */
    public function is_between($min, $max) {
      if ($this->compare($min)==-1) return false;
      if ($this->compare($max)==1) return false;
      return true;
    }

    /* returns $self if $self is between $min and $max else returns $min is $self
        is smaller than $min and $max if $self is larger than $max
      arg: min -> the lower clamp for $self
      arg: max -> the upper clamp for $self
      return: $self but limited to the range created by $min and $max
    */
    public function clamp($min, $max) {
      if ($this->compare($min)==-1) return $min;
      if ($this->compare($max)==1) return $max;
      return $this;
    }

  }

 ?>
