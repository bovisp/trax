const nodeExternals = require('webpack-node-externals')

module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    title: 'client',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Trax Client' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
    ]
  },
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth'
  ],
  axios: {
    baseUrl: 'http://trax.test/api'
  },
  auth: {
    strategies: {
      local: {
        endpoints: {
          login: {
            url: 'login',
            method: 'post',
            propertyName: 'meta.token'
          },
          user: {
            url: 'me',
            method: 'get',
            propertyName: 'data'
          },
          logout: {}
        }
      }
    }
  },
  css: ['~/assets/style/app.styl'],
  /*
  ** Customize the progress bar color
  */
  loading: { color: '#3B8070' },
  /*
  ** Build configuration
  */
  build: {
    extractCSS: true
  }
}
