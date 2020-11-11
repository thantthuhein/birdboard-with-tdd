<nav class="navbar navbar-expand-md navbar-light bg-header shadow-sm">
     <div class="mx-auto px-6">
          <div class="flex justify-between items-center py-2">
               <a class="navbar-brand text-2xl" href="{{ url('/') }}">
                    @include('layouts.logo')
               </a>
          
               <div class="flex relative">
                    <!-- Authentication Links -->
                    @guest
                         <div class="mr-5">
                              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                         </div>
                         @if (Route::has('register'))
                              <div>
                                   <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                              </div>
                         @endif
                    @else
                         <div class="mr-10">
                              <theme-switcher></theme-switcher>
                         </div>

                         <div class="flex ml-10">
                              <dropdown align="right" width="100%">
                                   <template v-slot:trigger>
                                        <button class="text-default no-underline text-sm focus:outline-none">
                                             {{ Auth::user()->name }}
                                        </button>
                                   </template>

                                   <button type="submit" form="logout-form" class="dropdown-menu-link focus:outline-none w-full text-left">
                                        {{ __('Logout') }}
                                   </button>
                              </dropdown>
          
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                              @csrf
                              </form>
                         </div>
                    @endguest
               </div>
          </div>
     </div>
</nav>
