<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Login from './Auth/Login.vue';
import DropdownNav from '../Components/flowbite/DropdownNav.vue';

import DropdownNavItem from '../Components/flowbite/DropdownNavItem.vue'; 
import { ref } from 'vue';

import {
    Guide, Document,
    Menu as IconMenu,
    Location,
    Setting,
} from '@element-plus/icons-vue'

import Logo from '@assets/icons/logo.svg';

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Welcome from '../Components/Welcome.vue';


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    Login
});
/**
onMounted(() => {
    initFlowbite();
})

const animate = ref(false);

const handleOpen = (key, keyPath) => {
    console.log(key, keyPath)
    animate.value = true;
    setTimeout(() => {
        animate.value = false;
    }, 1500);
}
const handleClose = (key, keyPath) => {
    console.log(key, keyPath)
    animate.value = false;
}
 */
</script>
<style scoped>
.no-right-border  {
    border: none !important;  
}
</style>
<template>
    <Head title="Login Go Credit" />
    <Login/> 
    
</template>
 

 
  
 