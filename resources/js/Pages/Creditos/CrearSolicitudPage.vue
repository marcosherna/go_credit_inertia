<script setup>

defineProps({
    cliente: {
        type: Object,
    },
})

</script>
<template>
    <div>
        {{ cliente }}
    </div>
</template>