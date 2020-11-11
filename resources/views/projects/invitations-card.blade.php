<div class="card flex flex-col mt-3">
       <h3 class="font-normal text-2xl py-4 border-l-4 border-blue-light mb-4 -ml-5 pl-4">
          Invite a user
       </h3>

       <form action="{{ route('projects.sendInvitation', $project) }}" method="POST">
          @csrf
          <div class="mb-3">
             <input 
                type="email" 
                name="email" id="email" 
                class="border border-grey rounded w-full py-2 px-3" 
                placeholder="Email Address"
                style="outline: none">
          </div>

          <button type="submit" class="button">Invite</button>
       </form>

       @include('projects._errors', ['bag' => 'invitations'])
    </div>