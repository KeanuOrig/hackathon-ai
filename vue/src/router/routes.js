const routes = [
  {
    path: '/',
    component: () => import('pages/ProcessPage.vue'),
  },
  {
    path: '/system/:systemId',
    component: () => import('pages/SystemPage.vue'),
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
