<script setup>
import { inject, onMounted, provide, reactive, ref, watch } from 'vue'

import axios from 'axios'

import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'

import SearchHelpList from './SearchHelpList.vue';
import SearchMessageList from './SearchMessageList.vue';

const getToken = inject('getToken')

const props = defineProps({
  modalStatus: Boolean
})

const emit = defineEmits('closeModalStatus')

// Токен пользователя
const token = localStorage.getItem('tokenSearch')


// Очиста токена
const removeToken = () => {
  localStorage.removeItem('tokenSearch')
}

const searchHelpArr = ref([])


// Массив с результаnом фильтра
const searchHelpArrResult = ref([]);

// Значение из текстового поля
const searchValue = ref('')




// Изменение значения поиска при клике на подсказки
const changeSearchValue = (event) => {
  console.log(event.target.innerText)
  searchValue.value = event.target.innerText
}




// Стадия фильтра поиска!!!!!
const searchStage = ref(1)


// Обьект который хранит в себе ответ бекенда

const botMessage = reactive({
  status: true,
})

// Обьект фильтров
const messageFilterResult = reactive({
  city: 0,
  status: 0,
  category: 0,
  event: 0,
  search: 0
})

// Получение всех подсказок в зависимости от стадии
const fetchSearchItems = async () => {
  try{
    
    console.log(messageFilterResult)

    if(searchStage.value == 1){
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred')
      data.cities.forEach(item => {
        searchHelpArr.value.push(item.name)
      });    
    }else if(searchStage.value == 2){

      console.log('------')

      searchHelpArr.value = [] 

      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred?city=' + messageFilterResult.city)
      
      console.log(data)

      data.status.forEach(item => {
        console.log(item.name)
        searchHelpArr.value.push(item.name)
      });
    }else if(searchStage.value == 3){


      searchHelpArr.value = [] 

      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred?city=' + messageFilterResult.city + '&status=' + messageFilterResult.status)

      console.log(data.categories)

      data.categories.forEach(item => {
        searchHelpArr.value.push(item.name)
      });
    }else if(searchStage.value == 4){

      searchHelpArr.value = [] 
      console.log(messageFilterResult)

      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred?city=' + messageFilterResult.city + '&status=' + messageFilterResult.status + '&category=' + messageFilterResult.category)

      console.log(data.services_events)

      data.services_events.forEach(item => {
        searchHelpArr.value.push(item.name)
      });
    }else if(searchStage.value == 5){

      searchHelpArr.value = [] 
      

      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred?city=' + messageFilterResult.city + '&status=' + messageFilterResult.status + '&category=' + messageFilterResult.category + '&event=Оформление документов')

      console.log('-o94=23-=4-09234-092340-9234-9032-=0942-0394-02394')
      console.log(data[0])

      data[0].forEach(item => {
        console.log(item)
        searchHelpArr.value.push(item)
      });
      }



    console.log(messageFilterResult)
    filterSearchHelpArr()
  }catch(err){
    console.log(err)
    console.log(botMessage.status)
  }
}

// Переменная по отображению подсказок

const isShowFilterSearchHelp = ref(false)


// Фильтрация массива и поиск результатов для подсказок
const filterSearchHelpArr = () => {

  console.log(searchValue.value)
    searchHelpArrResult.value = searchHelpArr.value.filter(item =>
      item.toLowerCase().includes(searchValue.value.toLowerCase())
    );

}



provide('changeSearchValue', changeSearchValue)



// Массив который будет хранить все сообщения, для визуала!!!
const messageItems = reactive([])




// Текст который выводит бот в зависимости от статуса запроса

const botText = ref('')

const changeBotText = () => {
  if(botMessage.status == true){
    if(searchStage.value == 1){
      botText.value = 'Привет, я Тимур, чтобы найти услугу, введи город для которого она предназначена.'
    }else if(searchStage.value == 2){
      botText.value = 'Отлично, теперь введите для каких людей создана данная услуга.'
    }else if(searchStage.value == 3){
      botText.value = 'Хорошо, сейчас выберите категорию вашей услуги.'
    }else if(searchStage.value == 4){
      botText.value = 'Введите направление данной услуги.'
    }else if(searchStage.value == 5){
      botText.value = 'Отлично, теперь вы можете найти необходимую вам услугу.'
    }
  } 
}



// Загрузка возможно вы имели ввиду

const maybeSearch = ref([])



// Функция проверки сообщения на правильность

const checkMessageError = async() => {
  try{
    if(searchStage.value == 1){
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred?city=' + searchValue.value)
      console.log(data)
      
    }else if(searchStage.value == 2){
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred?city=' + messageFilterResult.city + '&status=' + searchValue.value)
      console.log(data)
    }else if(searchStage.value == 3){
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred?city=' + messageFilterResult.city + '&status=' + messageFilterResult.status + '&category=' + searchValue.value)
      console.log(data)
    }else if(searchStage.value == 4){
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
      const { data } = await axios.get('https://gos.au42.ru/public/api/filtred?city=' + messageFilterResult.city + '&status=' + messageFilterResult.status + '&category=' + messageFilterResult.category + '&event=' + searchValue.value)
      console.log(data)
    }

    maybeSearch.value = []
    botMessage.status = true
    console.log(botMessage.status)
    searchStage.value = searchStage.value + 1
  }catch(err){
    botText.value = 'Не коректные данные, возможно вы имели ввиду'
    botMessage.status = false

    if(searchStage.value == 1){
      messageFilterResult.city = 0
    }else if(searchStage.value == 2){
      messageFilterResult.status = 0
    }else if(searchStage.value == 3){
      messageFilterResult.category = 0
    }else if(searchStage.value == 4){
      messageFilterResult.event = 0
    }else if(searchStage.value == 5){
      messageFilterResult.search = 0
    }

    console.log(botMessage.status)

    err.response.data.data.forEach(item => {
        console.log(item.name)
        maybeSearch.value.push(item.name)
    });
    console.log(maybeSearch.value)
  } 
}


// Отслеживание отправки из текстового поля
const sendMessage = () => {
  if(searchValue.value !== ''){
    messageItems.push(searchValue.value)
    checkMessageError()

    if(searchStage.value == 1){
      messageFilterResult.city = searchValue.value
    }else if(searchStage.value == 2){
      messageFilterResult.status = searchValue.value
    }else if(searchStage.value == 3){
      messageFilterResult.category = searchValue.value
    }else if(searchStage.value == 4){
      messageFilterResult.event = searchValue.value
    }else if(searchStage.value == 5){
      messageFilterResult.search = searchValue.value
    }

  }
  changeBotText()
  searchValue.value = ''
}












// Переменные с историями поиска и реками
const searchHistoryArr = ref([])
const searchRecomendArr = ref([])


// Очиста массива c историей поиска 
const clearArr = () => {
  searchHistoryArr.value = []
  searchRecomendArr.value = []
}

// Переменная которая скрывает историю

const showSearchHistory = ref(true)


// Подгрузка истории и рекомендаций

const getHistory = async() => {
  try{
    const { data } = await axios.get('https://gos.au42.ru/public/api/filtred')
    console.log(data.cities)
    data.cities.forEach(item => {
        searchHistoryArr.value.push(item.name)
      });

  }catch(err){
    console.log(err)
  }
}

const getRecomend = async() => {
  try{
    const { data } = await axios.get('https://gos.au42.ru/public/api/filtred')
    console.log(data.cities)
    data.cities.forEach(item => {
        searchRecomendArr.value.push(item.name)
      });

  }catch(err){
    console.log(err)
  }
}




// Пуш текстового поля из выбранной подсказки
watch(searchValue, () => {
  filterSearchHelpArr()
}
)

// Отслеживание изменения стадии и при изменении пуш подсказок другим наполненением
watch(searchStage, () => {
  console.log(searchStage.value)
  fetchSearchItems()
  changeBotText()
  getHistory()
  getRecomend()
}
)

onMounted(() => {
  changeBotText()
  fetchSearchItems()
  getHistory()
  getRecomend()

})



</script>


<template>
  <TransitionRoot appear :show="modalStatus" as="template">
    <Dialog @close="emit('closeModalStatus')" as="div" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/60"/>
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
        <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="relative grid gap-10 grid-cols-3 w-[1300px] h-[850px] transform overflow-hidden rounded-2xl bg-[url('/searchBG2.png')]  text-left align-middle shadow-xl transition-all">

              <img class="absolute right-3 top-3 w-8 cursor-pointer" @click="emit('closeModalStatus')" src="/sMark.svg" alt="crosshair">
              <div class="flex flex-col justify-between bg-white p-6">
                <div>
                  <p class="font-medium">Вы искали:</p>
                  <SearchHelpList class="overflow-hidden max-h-[80px]" v-if="showSearchHistory"  :searchHelpArrResult="searchHistoryArr"/>
                  <p class="mt-4 font-medium">Вам может быть интересно:</p>
                  <SearchHelpList class="overflow-hidden max-h-[80px]" v-if="showSearchHistory" :searchHelpArrResult="searchRecomendArr"/>
                </div>
                <div>
                  <button @click="removeToken(), clearArr(), getToken()" class="outline-none bg-rose-600 text-white py-2 rounded-xl w-full mt-6 hover:bg-rose-700 transition">Очистить подсказки</button>
                </div>
              </div>


              <div class="p-6 pl-0 col-span-2 flex justify-between flex-col">
                <div>
                  <!-- <h1 class="text-white text-3xl font-medium mb-4">Поиск услуг</h1> -->
                  <div class="flex mt-6">
                    <div class="relative">
                      <div class="animate-float">      
                        <div v-show="botMessage.status">
                          <img v-if="searchStage == 1" src="/Bot1.png" class="h-[280px]">
                          <img v-if="searchStage == 2" src="/Bot2.png" class="h-[280px] mr-5">
                          <img v-if="searchStage == 3" src="/Bot5.png" class="h-[280px] mr-5">
                          <img v-if="searchStage == 4" src="/Bot3.png" class="h-[280px] mr-5">
                          <img v-if="searchStage >= 5" src="/Bot4.png" class="h-[280px] mr-5">
                        </div>       
                        <img v-show="!botMessage.status" src="/BotBad.png" class="mr-5 h-[280px]">
                      </div>
                      <img src="/Shadow.png" class="w-[150px] left-4 absolute">
                    </div>
                    <div class="relative">
                      <div class="bg-white rounded-bl-lg rounded-3xl w-96 px-5 py-3 h-fit">
                        <p class="leading-5 text-xl font-medium" v-auto-animate>{{ botText }}</p>
                        <div v-if="searchStage < 5" @click="searchStage = searchStage + 1, searchValue = '', maybeSearch = [], botMessage.status = true" class="mb-2 mt-4 cursor-pointer bg-blue-100 rounded-xl flex items-center h-10 justify-between px-3 hover:bg-blue-200 transition">
                          <p>Пропустить пункт</p>
                          <img src="/next.svg" alt="next" class="h-6 bg-white rounded-xl p-1">
                        </div>
                        <div v-if="searchStage < 5" @click="searchStage = 5, searchValue = '', maybeSearch = [], botMessage.status = true" class=" cursor-pointer bg-blue-100 rounded-xl flex items-center h-10 justify-between px-3 hover:bg-blue-200 transition">
                          <p>Сразу ввести услугу</p>
                          <img src="/next.svg" alt="next" class="h-6 bg-white rounded-xl p-1">
                        </div>
                        <div v-if="searchStage == 5" @click="searchStage = 1, searchValue = '', maybeSearch = [], botMessage.status = true, searchHelpArr = []" class=" mt-4 cursor-pointer bg-blue-100 rounded-xl flex items-center h-10 justify-between px-3 hover:bg-blue-200 transition">
                          <p>Начать сначала</p>
                          <img src="/next.svg" alt="next" class="h-6 bg-white rounded-xl p-1">
                        </div>
                      </div>
                      <SearchHelpList class="overflow-hidden absolute max-h-[110px] max-w-[380px]" v-if="showSearchHistory"  :searchHelpArrResult="maybeSearch"/>
                    </div>
                  </div>
                  <SearchMessageList class="py-5 " :messageItems="messageItems"/>

                </div>
                <div>
                  <SearchHelpList class="max-h-[82px]" v-if="isShowFilterSearchHelp" @changeSearchValue="changeSearchValue" :searchValue="searchValue" :searchHelpArrResult="searchHelpArrResult"/>
                  <div class="relative">
                    <input @focus="isShowFilterSearchHelp = true" @keyup.enter="sendMessage" v-model="searchValue" class="bg-white w-full h-14 rounded-[10px] px-5 pr-14 outline-none" placeholder="Введите текст">
                    <img @click="sendMessage" src="/airline.svg" class="h-8 absolute right-4 top-3 cursor-pointer">
                    <img v-if="searchValue" @click="sendMessage" src="/airlineActive.svg" class="h-8 absolute right-4 top-3 cursor-pointer">
                  </div>
                </div>          
              </div>
              

            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

