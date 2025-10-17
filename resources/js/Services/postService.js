import axios from '@/Api/axios';

export const getPosts = (userId) => axios.get('/posts', { params: { user_id: userId }});
export const createPost = (data) => axios.post('/posts', data);
export const canPost = () => axios.get('/can-post');