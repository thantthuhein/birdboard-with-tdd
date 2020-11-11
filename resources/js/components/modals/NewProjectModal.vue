<template>
     <div>
          <modal name="new-project" classes="p-10 rounded-lg text-gray-600" height="auto" styles="border-radius: 0.5rem;">
               <h1 class="font-normal mb-10 text-center text-2xl">Let's Start Something New</h1>

               <form @submit.prevent="submit">
                    <div class="flex">
                         <div class="flex-1 mr-3">
                              <text-input 
                              :class-name="form.errors.title ? 'border-red-600' : 'border-gray-500'"
                              name="title" type="text" placeholder="" value="" label="Title" v-model="form.title" @data_change="title_changed"></text-input>
                              <span v-if="form.errors.title" v-text="form.errors.title[0]" class="text-xs italic text-red-600"></span>

                              <div class="mt-4">
                                   <label for="description" class="text-sm block mb-1">Description</label>
                                   <textarea type="text" name="description" id="description" 
                                        v-model="form.description"
                                        :class="form.errors.description ? 'border-red-600' : 'border-gray-500'"
                                        class="border border-gray-500 rounded-md text-xs p-2 outline-none block w-full" rows="7"></textarea>
                                   <span v-if="form.errors.description" v-text="form.errors.description[0]" class="text-xs italic text-red-600"></span>
                              </div>
                         </div>

                         <div class="flex-1 ml-3">
                              <div class="mb-4">
                                   <label class="text-sm block mb-1">Need Some Tasks?</label>

                                   <input 
                                        v-for="task in form.tasks" :key="task[0]"
                                        v-model="task.body"
                                        :placeholder="task.body"
                                        class="border border-gray-500 rounded-md text-xs p-2 outline-none block w-full mb-2" />

                              </div>
                    
                              <button type="button" class="inline-flex items-center text-xs w-full text-gray-500 focus:outline-none" @click.prevent="addTask">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                                        <g fill="none" fill-rule="evenodd" opacity=".Need 307">
                                             <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                                             <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                                        </g>
                                   </svg>

                                   <span>Add Some Tasks</span>
                              </button>
                         </div>
          
                    </div>

                    <footer class="flex justify-end">
                         <button type="button" class="button is-outlined mr-5" @click.prevent="$modal.hide('new-project')">Cancel</button>
                         <button @click.prevent="submit" type="submit" class="button">Create</button>
                    </footer>
               </form>     
          </modal>
     </div>
</template>

<script>
import BirdboardForm from '../../BirdboardForm';

export default {
     data() {
          return {
               form: new BirdboardForm ({
                    title: '',
                    description: '',
                    tasks: [
                         { body: '' },           
                    ]
               })
          }
     },

     methods: {
          addTask() {
               this.form.tasks.push({ body: '' },)
          },          
          title_changed(content) {
               this.form.title = content
          },
          async submit() {
               this.form.submit('/projects')
               .then(response => location = response.data.message)
               .catch(error => console.warn('The Given data was invalid'))
          },
     },
}
</script>