<template>
    <nav class="pagination mb-4">
        <Link 
            v-for="page in props.pages" 
            :key="page.label" 
            class="pagination-link"
            :class="{ active : page.active }"
            v-html="page.label"
            :href="cleanUrl(page.url)"
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

// Function to strip domain if window is available
const cleanUrl = (url) => {
  if (!url) return '#';
  if (typeof window !== 'undefined') {
    return url.replace(window.location.origin, '');
  }
  return url; // Fallback: return as-is (safe during SSR)
};

</script>
