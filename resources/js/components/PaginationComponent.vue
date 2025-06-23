<template>
    <nav class="pagination mb-4">
        <Link 
            v-for="page in props.pages" 
            :key="page.label" 
            class="pagination-link"
            :class="{ active : page.active }"
            v-html="page.label"
            :href="page.url ? page.url.replace(window.location.origin, '') : '#'"
            :disabled="page.url === null"
            as="button"
        ></Link>
    </nav>
</template>

<script setup>

import { Link } from '@inertiajs/vue3';

const props = defineProps({
    pages: Array
})

</script>
