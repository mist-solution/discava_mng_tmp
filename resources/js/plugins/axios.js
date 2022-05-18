import axios from "axios"

const AxiosPlugin = {}

AxiosPlugin.install = function (app) {
  console.log(app.version) // -> '3.0.0-rc.12'

  const isVue3 = app.version.startsWith('3')

  // インスタンスメソッドの拡張
  const prototype = isVue3 ? app.config.globalProperties : app.prototype
  prototype.$axios = axios.create({
    baseURL: process.env.MIX_APP_API_BASE_URL,
    headers: {
      'Content-Type': 'application/json'
    },
    responseType: 'json',
    timeout: 30000
  })

  // リクエストログ
  prototype.$axios.interceptors.request.use(
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
  prototype.$axios.interceptors.response.use(
    function (response) {
      console.info(response)
      return response;
    },
    function (error) {
      console.error(error)
      return Promise.reject(error);
    }
  )
}

export default AxiosPlugin;
