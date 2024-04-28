<script setup>
import Resurs from "./components/Resurs.vue"
import Menu from "./components/Menu.vue";
import BlocInfo from "./components/BlocInfo.vue";


import { onMounted, provide, ref } from 'vue';
import SearchModal from './components/SearchModal.vue';

import axios from 'axios'
// Статус модалки поика

const modalStatus = ref(false)

const closeModalStatus = () => modalStatus.value = false
const openModalStatus = () => modalStatus.value = true

// Запись токена при входе пользователся на сайт


const getToken = async() => {
  try{
    if(localStorage.getItem('tokenSearch') == null){
      const { data } = await axios.get('https://gos.au42.ru/public/api/create')
      localStorage.setItem('tokenSearch', data.data.token)
    }else{
    }
  }catch(err){
    console.log(err)
  }
}

provide('getToken', getToken)

onMounted(() => {
  getToken()
})


</script>

<template>
  

  <div class=" relative justify-center items-center h-full">
    <Menu class="container"/>
    <router-view @openModalStatus="openModalStatus"></router-view>
    <div class="container flex-col relative items-center justify-center h-96 w-5/6 pt-4">
      <section class="">
        <div class="helpful-resources-title mb-4 ">
          <h1 class="mt-10">Интересно и полезно</h1>
        </div>
        <div class="grid gap-40 grid-cols-3 ">
          <BlocInfo />
          <BlocInfo />
          <BlocInfo />
        </div>
        <div class="flex items-center justify-center pt-[40px]">
          <span class=" px-6 py-4 rounded-lg  bg-blue-500  text-white"> Все материалы </span>
        </div>
      </section>

      <section>
        <Resurs />
      </section>
  </div>
</div>

  <SearchModal :modalStatus="modalStatus" @closeModalStatus="closeModalStatus"/>
</template>