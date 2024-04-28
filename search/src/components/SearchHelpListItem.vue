<script setup>
import { inject } from 'vue';


defineProps({
  item: String,
})

const changeSearchValue = inject('changeSearchValue')

</script>


<template>
  <div class="bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-600 transition max-w-[300px] flex items-center ">
    <p @click="changeSearchValue" class="text-white overflow-hidden px-2 py-0.5">{{ item }}</p>
  </div>
</template>