<template>
     <div>
          <label for="name">{{ label }}</label>
          <input 
               @change="change" 
               :type="type" 
               :id="name" 
               :value="value" 
               :name="name" 
               :placeholder="placeholder" 
               :class="className"
               class="border rounded-md text-xs p-2 outline-none block w-full"
          />
     </div>
</template>
<script>
export default {
    props : ['name','type','placeholder',"value","label", "className"],
    methods : {
      change(event){
        this.$emit('data_change',event.target.value);
      }
    }
};
</script>