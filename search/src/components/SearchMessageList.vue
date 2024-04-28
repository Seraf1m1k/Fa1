<script setup>
import SearchMessageListItem from './SearchMessageListItem.vue';

import { ref, watch } from 'vue'

const props = defineProps({
  messageItems: Array
})

const scrollArea = ref(null)





watch(props.messageItems, () => {
  console.log(props.messageItems)
  scrollArea.value.scrollTo({
  top: scrollArea.value.scrollHeight
})
console.log(props.messageItems)
})


</script>

<template>
  <div @click="scrollToBottom" ref="scrollArea" class="flex flex-col items-end gap-5 overflow-y-auto h-[330px] pb-[80px] pr-2 scroll" v-auto-animate>
    <SearchMessageListItem
    v-for="item in messageItems"
    :key="item"
    :item="item"
    />
  </div>
</template>


<style scoped>


@keyframes scrollDown {
  from {
    scrollTop: 0;
    }
  to {
    scrollTop: 100%; 
  }
}

.scroll {
    overflow-y: auto;
    animation: scrollDown 0.5s linear infinite;
}

.scroll::-webkit-scrollbar{
  width: 4px;
  background-color:  transparent;
}
.scroll::-webkit-scrollbar-thumb {
  background: white;
  border-radius: 5px;
}


</style>