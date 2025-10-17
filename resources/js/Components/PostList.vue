<template>
        <div v-if="loading">Carregando posts...</div>
        <div v-else>
            <div v-if="!posts.length">Nenhum post encontrado.</div>
            <div v-else>
                <div v-for="post in posts" :key="post.id" class="mb-4 p-4 border rounded shadow">
                    <h3 class="font-semibold text-lg truncate">{{ post.title }}</h3>
                    <p class="break-words overflow-hidden">{{ post.content }}</p>
                    <small>Autor: {{ post.user.name }}</small>
                </div>
            </div>
        </div>
</template>

<script setup>
const props = defineProps({
    posts: {
        type: Array,
        required: true
    },
    loading: {
        type: Boolean,
        default: false
    }
});
</script>
