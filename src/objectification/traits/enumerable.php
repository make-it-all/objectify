<?php namespace Objectify\Traits;

  trait Enumerable{

    //yields consecitive items and returns $this when finished
    abstract public function each();

    public function to_enum($method=null) {
      return \Objectify\Collection\Enumerator::new($this->each(), $method);
    }

    public function map($block=null) {
      if ($block==null) return $this->to_enum('map');

      $results = [];
      $this->each(function($el) use (&$results, $block){
        $results[] = $block($el);
      });
      return $results;
    }

    public function each_with_index($block) {
      return $this->with_index(0, $block);
    }

    public function with_index($i, $block) {
      return $this->each(function($el) use (&$i, $block){
        $block($el, $i);
        $i++;
      });
    }

  }
