export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  // Target: https://go.nuxtjs.dev/config-target
  target: 'static',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'shop_layout',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "@/assets/page/css/bootstrap.css",
    "@/assets/page/css/animate.css",
    "@/assets/page/css/font-awesome.css",
    "@/assets/page/css/furniture-icons.css",
    "@/assets/page/css/linear-icons.css",
    "@/assets/page/css/magnific-popup.css",
    "@/assets/page/css/owl.carousel.css",
    "@/assets/page/css/ion-range-slider.css",
    "@/assets/page/css/theme.css",
    "@/assets/icon/css/all.css"
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    "~/plugins/axios.js",
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    'bootstrap-vue/nuxt',
    '@nuxtjs/axios',
    '@nuxtjs/auth-next'
  ],

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },

  axios: {
    baseUrl: process.env.API_URL || "http://127.0.0.1:8000/api/",
  },

  loading: {
    color: '#ffb701',
    height: '2px'
  },

  auth: {
    strategies: {
      'laravelJWT': {
        provider: 'laravel/jwt',
        url: 'http://127.0.0.1:8000/api',
        token: {
          property: 'access_token',
          maxAge: 60 * 60 * 24
        },
        refreshToken: {
          maxAge: 20160 * 60
        },
        endpoints: {
          login: { url: '/login', method: 'post' },
          logout: { url: '/logout', method: 'post' },
          user: { url: '/user', method: 'get' },
          refresh: { url: '/refresh', method: 'post' }
        }
      }
    }
  },
}
