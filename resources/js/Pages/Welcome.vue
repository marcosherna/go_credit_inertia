<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Login from './Auth/Login.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    Login
});
</script>

<template>
    <Head title="Login Go Credit" />  
    <Login/> 
</template>

 