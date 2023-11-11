<script setup> 

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import NavigationLayout from '../Layouts/NavigationLayout.vue';
import Welcome from '../Components/Welcome.vue';

defineProps({ 
    NavigationLayout,
    Welcome
})

onMounted(() => {
    initFlowbite();
})


</script>

<template>
    <NavigationLayout title="Home"> 
        <div>
            <Welcome />
        </div> 
    </NavigationLayout>
    
</template>


