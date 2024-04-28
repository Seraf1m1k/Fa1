<template>
    <div>
        <span class="helpful-resources-title">Полездные ресурсы</span>
        <div
            class=" bg-blue-500 w-[100%] h-[208px] rounded-[20px] my-[20px] flex items-center justify-between ">
            <div class="">
                <div class="animate-pulse bg-gray-400 ml-9 my-2 w-[500px] h-12 rounded-xl"></div>
                <div class="animate-pulse bg-gray-400 ml-9 my-2 w-[160px] h-6 rounded-xl"></div>
                <div class="animate-pulse bg-gray-400 ml-9 my-2 w-[160px] h-6 rounded-xl"></div>
            </div>
            <div class="animate-pulse bg-gray-400 mr-9 w-[180px] h-[200px] rounded-xl"></div>
        </div>
        <div class="grid grid-cols-3 relative justify-items-center gap-4">
            <BlocIner />
            <BlocIner />
            <BlocIner />
            <BlocIner />
            <BlocIner />
            <BlocIner />
            <BlocIner />
            <BlocIner />
            <BlocIner />
            <BlocIner />
            <BlocIner />
        </div>
    </div>
</template>

<script setup>
import BlocIner from "../components/BlocIner.vue";
</script>
