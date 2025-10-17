import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

//Requisição necessária para fazer as chamadas nos endpoints de api
await axios.get('/sanctum/csrf-cookie');

axios.defaults.baseURL = '/api';
axios.defaults.headers.common['Accept'] = 'application/json';

export default axios;