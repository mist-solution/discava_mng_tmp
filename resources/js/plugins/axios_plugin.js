import axios from "../axios"

const AxiosPlugin = {}

AxiosPlugin.install = function (app) {
  console.log(app.version) // -> '3.0.0-rc.12'

  const isVue3 = app.version.startsWith('3')

  // インスタンスメソッドの拡張
  const prototype = isVue3 ? app.config.globalProperties : app.prototype
  prototype.$axios = axios
}
export default AxiosPlugin;
