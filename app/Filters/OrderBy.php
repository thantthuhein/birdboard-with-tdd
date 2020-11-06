<?php

namespace App\Filters;

class OrderBy extends Filter {
     public function handle($builder, $next)
     {
          if ($request->has('order_by')) {
               //
          }

          $next($builder);
     }
}