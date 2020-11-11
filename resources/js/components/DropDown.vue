<template>
     <div class="dropdown">
          <div 
               @click.prevent="toggleDropdown"
               aria-haspopup="true"
               :aria-expanded="isOpen"
          >
               <slot name="trigger"></slot> 
          </div>

          <div 
          v-show="isOpen"
          class="dropdown-menu absolute bg-card py-2 rounded shadow mt-2"
          :class="align == 'left' ? 'left-0' : 'right-0'"
          :style="{ width }"
          >
               <slot></slot>
          </div>
     </div>
</template>

<script>
export default {
     props: {
          align: { default: 'left' },
          width: { default: 'auto' }
     },
     data() {
          return {
               isOpen: false,
          }
     },
     methods: {
          toggleDropdown() {
               this.isOpen = ! this.isOpen
          },
          closeIfOutside(event) {
               if (! event.target.closest('.dropdown')) {
                    this.isOpen = false;
                    document.removeEventListener('click', this.closeIfOutside);
               }
          }
     },

     watch: {
          isOpen(isOpen) {
               if (isOpen) {
                    document.addEventListener('click', this.closeIfOutside)
               }
          }
     },
}
</script>