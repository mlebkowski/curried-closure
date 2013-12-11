<?php

namespace Nassau;

class CurriedClosure {

  private $applyLeft = [];
  private $applyRight = [];
  private $callable;

  public function __construct($callable, $applyLeft = [], $applyRight = []) {
    $this->callable = $callable;
    $this->applyLeft = $applyLeft;
    $this->applyRight = $applyRight;
  }

  public function __invoke() {
    return call_user_func_array($this->callable, array_merge($this->applyLeft, func_get_args(), $this->applyRight));
  }

  public function curryLeft($params) {
    $closure = clone $this;
    $closure->applyLeft = array_merge(is_array($params) ? $params : [$params], $closure->applyLeft);
    return $closure;
  }

  public function curryRight($params) {
    $closure = clone $this;
    $closure->applyRight = array_merge($this->applyRight, is_array($params) ? $params : [$params]);
    return $closure;
  }

  public function compose($callable) {
    $closure = clone $this;
    $inner = $closure->callable;
    $closure->callable = function () use ($inner, $callable) { 
      return $callable(call_user_func_array($inner, func_get_args()));
    };
    return $closure;
  }

}
