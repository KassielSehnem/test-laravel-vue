<template>
    <div class="h-[80vh] overflow-y-auto p-4" ref="scrollArea" @scroll.passive="handleScroll">
        <div v-if="!posts.length && !loading">Nenhum post encontrado.</div>
        <div v-else>
            <div v-for="post in posts" :key="post.id" class="mb-4 p-4 border rounded shadow">
                <h3 class="font-semibold text-lg truncate">{{ post.title }}</h3>
                <p class="break-words overflow-hidden">{{ post.content }}</p>
                <small>Autor: {{ post.user.name }}</small>
            </div>
        </div>
        <div v-if="loading" class="text-center text-gray-500 py-4">Carregando posts...</div>
        <div v-if="!hasMore" class="text-center text-gray-500 py-4">Você chegou ao fim.</div>
    </div>
</template>

<script setup>
const emit = defineEmits(['near-bottom'])
const props = defineProps({
    posts: {
        type: Array,
        required: true
    },
    loading: {
        type: Boolean,
        default: false
    },
    hasMore: {
        type: Boolean,
        default: true
    }
});

const handleScroll = (e) => {
    const el = e.target;
    const nearBottom = el.scrollTop + el.clientHeight >= el.scrollHeight - 100;
    if (nearBottom) emit('near-bottom');
};
</script>
