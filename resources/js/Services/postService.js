import axios from '@/Api/axios';

export const getPosts = (limit, nextCursor, userId) => axios.get('/posts', { params: { limit: limit, cursor: nextCursor, user_id: userId }});
export const createPost = (data) => axios.post('/posts', data);
export const canPost = () => axios.get('/can-post');