<script setup>

defineProps({
  item: String
})

</script>


<template>
  <p class="bg-white rounded-br-lg rounded-3xl w-auto max-w-96 px-5 py-3 leading-5">
    {{ item }}
  </p>
</template>