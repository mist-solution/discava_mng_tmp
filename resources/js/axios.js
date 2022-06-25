import axios from "axios"

const storeAxios = axios.create({
    baseURL: process.env.MIX_APP_API_BASE_URL,
    headers: {
        'Content-Type': 'application/json'
    },
    responseType: 'json',
    timeout: 30000
})

// リクエストログ
storeAxios.interceptors.request.use(
    function (config) {
        console.info(config)
        return config;
    },
    function (error) {
        console.error(error)
        return Promise.reject(error);
    }
)

// レスポンスログ
storeAxios.interceptors.response.use(
    function (response) {
        console.info(response)
        return response;
    },
    function (error) {
        console.error(error)
        return Promise.reject(error);
    }
)

export default storeAxios;