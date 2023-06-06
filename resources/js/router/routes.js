function page(path) {
    return () => import(/* webpackChunkName: '' */ `~/pages/${ path }.vue`).then(m => m.default || m);
}

export default [
    { path: '/', name: 'login', component: page('auth/login') },
    { path: '/dashboard', name: 'dashboard', component: page('dashboard'), meta: { title: "Ваш кабінет"} },

    { path: '/stats', name: 'stats.index', component: page('stats/index'), meta: { title: "Статистика"} },

    { path: '/departments', name: 'departments.index', component: page('departments/index'), meta: { title: "Приміщення"} },
    { path: '/invoices', name: 'invoices.index', component: page('invoices/index'), meta: { title: "Накладні"} },
    { path: '/items', name: 'items.index', component: page('items/index'), meta: { title: "Технічне обладнання"} },
    { path: '/licenses', name: 'licenses.index', component: page('licenses/index'), meta: { title: "Ліцензії"} },
    { path: '/hardware-models', name: 'hardware-models.index', component: page('hardware-models/index'), meta: { title: "Моделі обладнання"} },
    { path: '/software-models', name: 'software-models.index', component: page('software-models/index'), meta: { title: "Моделі ліцензій"} },
    { path: '/providers', name: 'providers.index', component: page('providers/index'), meta: { title: "Потачальники"} },
    { path: '/repairs', name: 'repairs.index', component: page('repairs/index'), meta: { title: "Ремонти"} },
    { path: '/statuses', name: 'statuses.index', component: page('home'), meta: { title: "Статуси"} },
    { path: '/transfers', name: 'transfers.index', component: page('transfers/index'), meta: { title: "Передачі обладнання"} },
    { path: '/types', name: 'types.index', component: page('types/index'), meta: { title: "Типи обладнання"} },
    { path: '/users', name: 'users.index', component: page('users/index'), meta: { title: "Користувачі"} },
    { path: '/roles', name: 'roles.index', component: page('roles/index'), meta: { title: "Ролі користувачів"} },
    { path: '/writeoffs', name: 'writeoffs.index', component: page('writeoffs/index'), meta: { title: "Списання"} },

    { path: '/qr/items/:id', name: 'qr.item', component: page('home') },

    { path: '*', component: page('errors/404') }
];
