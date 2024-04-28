<script setup>

const emit = defineEmits('openModalStatus')

</script>

<template>
  
  <div class="bg-blue-600 h-[350px] w-full flex items-center">
    <div class="container">
      <button @click="emit('openModalStatus')" class="bg-white w-full h-14 rounded-xl flex items-center justify-between px-5 outline-none">
        <p class="text-gray-500">Найти услугу</p>
        <img class="h-8" src="/airline.svg" alt="airline">
      </button>

    </div>
  </div>


</template>