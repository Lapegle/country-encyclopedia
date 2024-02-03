<script setup>
defineProps({
    description: String,
    value: String
})
</script>

<template>
    <p>{{ description }}: <span class="font-bold">{{ value }}</span></p>
</template>
