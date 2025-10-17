<template>
    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-end">
                <div class="relative inline-block text-left">
                    <button @click="open = !open"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Filtrar Por Usuário
                    </button>
            
                    <!-- Dropdown -->
                    <div v-if="open"
                        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Selecione o usuário:</label>
                            <select v-model="selectedUser" class="w-full rounded border-gray-300 p-2">
                                <option value="">Todos</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
            
                            <button @click="applyFilter"
                                class="mt-3 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
                                Aplicar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { canPost } from '@/Services/postService'

const open = ref(false)
const selectedUser = ref('')
const users = ref([])
const emit = defineEmits(['filter-applied'])

const fetchUsersThatCanPost = async () => {
    try {
        const res = await canPost();
        users.value = res.data;
    } catch (err) {
        console.log(err);
    }
}

function applyFilter() {
    emit('filter-applied', selectedUser.value)
    open.value = false
}

onMounted(fetchUsersThatCanPost);
</script>
