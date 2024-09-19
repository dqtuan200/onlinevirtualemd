import Vue from 'vue'
import Router from 'vue-router'
import { normalizeURL, decode } from 'ufo'
import { interopDefault } from './utils'
import scrollBehavior from './router.scrollBehavior.js'

const _57924020 = () => interopDefault(import('..\\pages\\forgot-password.vue' /* webpackChunkName: "pages/forgot-password" */))
const _3dcbc344 = () => interopDefault(import('..\\pages\\login.vue' /* webpackChunkName: "pages/login" */))
const _0f435f3c = () => interopDefault(import('..\\pages\\packages.vue' /* webpackChunkName: "pages/packages" */))
const _15d64e78 = () => interopDefault(import('..\\pages\\profile.vue' /* webpackChunkName: "pages/profile" */))
const _01695f18 = () => interopDefault(import('..\\pages\\register.vue' /* webpackChunkName: "pages/register" */))
const _107cd50e = () => interopDefault(import('..\\pages\\reset-password.vue' /* webpackChunkName: "pages/reset-password" */))
const _29768de8 = () => interopDefault(import('..\\pages\\subscription\\cancel.vue' /* webpackChunkName: "pages/subscription/cancel" */))
const _dbf1993e = () => interopDefault(import('..\\pages\\subscription\\success.vue' /* webpackChunkName: "pages/subscription/success" */))
const _7424202d = () => interopDefault(import('..\\pages\\index.vue' /* webpackChunkName: "pages/index" */))

const emptyFn = () => {}

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: '/',
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,

  routes: [{
    path: "/forgot-password",
    component: _57924020,
    name: "forgot-password"
  }, {
    path: "/login",
    component: _3dcbc344,
    name: "login"
  }, {
    path: "/packages",
    component: _0f435f3c,
    name: "packages"
  }, {
    path: "/profile",
    component: _15d64e78,
    name: "profile"
  }, {
    path: "/register",
    component: _01695f18,
    name: "register"
  }, {
    path: "/reset-password",
    component: _107cd50e,
    name: "reset-password"
  }, {
    path: "/subscription/cancel",
    component: _29768de8,
    name: "subscription-cancel"
  }, {
    path: "/subscription/success",
    component: _dbf1993e,
    name: "subscription-success"
  }, {
    path: "/",
    component: _7424202d,
    name: "index"
  }],

  fallback: false
}

export function createRouter (ssrContext, config) {
  const base = (config._app && config._app.basePath) || routerOptions.base
  const router = new Router({ ...routerOptions, base  })

  // TODO: remove in Nuxt 3
  const originalPush = router.push
  router.push = function push (location, onComplete = emptyFn, onAbort) {
    return originalPush.call(this, location, onComplete, onAbort)
  }

  const resolve = router.resolve.bind(router)
  router.resolve = (to, current, append) => {
    if (typeof to === 'string') {
      to = normalizeURL(to)
    }
    return resolve(to, current, append)
  }

  return router
}
