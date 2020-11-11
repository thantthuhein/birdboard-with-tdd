<template>
     <div>
          <div class="flex items-center mr-5">
               <button v-for="(color, theme) in themes" :key="theme"
                    class="rounded-full w-4 h-4 border mr-2 focus:outline-none" 
                    :class="{ 'border-accent': selectedTheme == theme }"
                    :style="{ backgroundColor: color }"
                    @click="selectedTheme = theme">
               </button>
          </div>
     </div>
</template>

<script>
export default {
     data() {
          return {
               themes: {
                    'light-theme': 'white',
                    'dark-theme': 'black',
               },
               selectedTheme: 'light-theme'
          }
     },

     created() {
          this.selectedTheme = localStorage.getItem('theme') ?? 'light-theme'
     },

     watch: {
          selectedTheme() {
               document.body.className = document.body.className.replace(/\w+-theme/, this.selectedTheme)

               localStorage.setItem('theme', this.selectedTheme)
          }
     },
}
</script>