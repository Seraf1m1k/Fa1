<script setup>

import { inject } from 'vue';
import SearchHelpListItem from './SearchHelpListItem.vue'

const props = defineProps({
  searchHelpArrResult: Array,
})


</script>


<template>
  <div class="py-2 rounded-[10px] flex overflow-hidden flex-row flex-wrap items-start gap-2" v-auto-animate>
    <SearchHelpListItem
    v-for="item in searchHelpArrResult"
    :key="item"
    :item="item"
    />
  </div>
</template>