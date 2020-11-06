<?php

namespace App\Filters;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter {
     /**
      * @var Request
      */
     protected $request;

     /**
      * @param Request $request
      */
     public function __construct(Request $request)
     {
          $this->request = $request;
     }
     
     /**
      * Handle Filer
      *  
      * @param Builder $builder
      * @param Closure $next
      * @return void
      */
     public abstract function handle(Builder $builder, Closure $next);
}