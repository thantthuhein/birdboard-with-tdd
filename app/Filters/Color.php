<?php

namespace App\Filters;

class Color extends Filter {
     public function handle($builder, $next)
     {
          if ($request->has('color')) {
               //
          }

          $next($builder);
     }
}