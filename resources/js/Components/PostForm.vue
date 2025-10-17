<template>
    <div class="pt-6 pb-3">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-500 flex flex-col gap-3">
                    <input
                        v-model="title"
                        type="text"
                        :maxlength="255"
                        placeholder="Digite um título..."
                        class="w-full mb-2 rounded border-b border-gray-200 dark:border-gray-700 bg-transparent outline-none text-lg font-semibold text-gray-500 dark:text-gray-500 placeholder-gray-500"
                    />
                    <textarea
                    v-model="content"
                    @input="autoResize"
                    placeholder="O que está acontecendo?"
                    rows="1"
                    class="w-full resize-none rounded outline-none text-gray-500 dark:text-gray-500 bg-gray text-lg placeholder-gray-500"
                    ></textarea>
                    <div class="flex justify-end">
                        <button
                            @click="submitPost"
                            :disabled="isSubmitting || !content.trim() || !title.trim()"
                            class="bg-blue-500 hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold px-5 py-2 rounded-full transition"
                        >
                            {{ isSubmitting ? 'Postando...' : 'Postar' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, nextTick } from 'vue'
import { createPost } from '@/Services/postService';

const content = ref('');
const title = ref('');
const isSubmitting = ref(false);
const emit = defineEmits(['post-created']);

//Faz o ajuste automático do textarea
function autoResize(e) {
    const el = e.target;
    el.style.height = 'auto';
    el.style.height = el.scrollHeight + 'px';
}

async function submitPost() {
    if (!content.value.trim() && !title.value.trim()) return
        isSubmitting.value = true

        try {
            const res = await createPost({title: title.value, content: content.value});
            content.value = '';
            title.value = '';
            emit('post-created', res.data);
        } catch (err) {
            console.error(err);
        } finally {
            isSubmitting.value = false;
            await nextTick(() => {
            // reseta altura após limpar
            const textarea = document.querySelector('textarea');
            if (textarea) textarea.style.height = 'auto';
        })
    }
}
</script>

<style scoped>
textarea::-webkit-scrollbar {
  display: none;
}
</style>
