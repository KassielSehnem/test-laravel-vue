<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue'
import { getPosts } from '@/Services/postService';
import PostList from '@/Components/PostList.vue';
import PostForm from '@/Components/PostForm.vue';
import PostFilter from '@/Components/PostFilter.vue';

const page = usePage()
const user = computed(() => page.props.auth?.user)
const posts = ref([]);
const loading = ref(false);
const hasMore = ref(true);
const nextCursor = ref(null);
const selectedUserId = ref(null);

const fetchPosts = async (limit = 10) => {
    if (loading.value || !hasMore.value) return;
    loading.value = true;

    try {
        const res = await getPosts(limit, nextCursor.value, selectedUserId.value);
        console.log(res.data.data);
        posts.value.push(...res.data.data);
        nextCursor.value = res.data.next_cursor;
        hasMore.value = res.data.has_more;
    } catch (err) {
        console.error(err);
    } finally {
        loading.value = false;
    }
};

const addPost = (newPost) => {
    posts.value.unshift(newPost);
}

const applyFilter = (userId = null) => {
    selectedUserId.value = userId
    nextCursor.value = null;
    posts.value = [];
    hasMore.value = true;
    fetchPosts();
}

onMounted(fetchPosts);
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Posts
            </h2>
        </template>
        <PostForm v-if="user?.is_admin" @post-created="addPost" />
        <PostFilter @filter-applied="applyFilter" />
        <div class="py-3">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <PostList :posts="posts" :loading="loading" :hasMore="hasMore" @near-bottom="fetchPosts"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
