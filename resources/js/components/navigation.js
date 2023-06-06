export const menuItems = [
    { title: 'Обладнання', path: '/items', icon: 'mdi-laptop', permission: 'view-items' },
    { title: 'Ліцензії', path: '/licenses', icon: 'mdi-microsoft-windows', permission: 'view-licenses' },
    { title: 'Накладні', path: '/invoices', icon: 'mdi-file-document-outline', permission: 'view-invoices' },
    { title: 'Передачі', path: '/transfers', icon: 'mdi-swap-horizontal', permission: 'view-transfers' },
    { title: 'Ремонти', path: '/repairs', icon: 'mdi-wrench', permission: 'view-repairs' },
];

export const profileMenuItems = [
    { title: 'Профіль', path: '/profile', icon: 'mdi-card-account-details', permission: null },
];

export const settingsMenuItems = [
    { title: 'Статистика', path: '/stats', icon: 'mdi-chart-areaspline', permission: 'view-stats' },
    { title: 'Користувачі', path: '/users', icon: 'mdi-account-plus', permission: 'view-users' },
    { title: 'Ролі користувачів', path: '/roles', icon: 'mdi-account-supervisor', permission: 'view-roles' },
    { title: 'Постачальники', path: '/providers', icon: 'mdi-account-tie', permission: 'view-providers' },
    { title: 'Приміщення', path: '/departments', icon: 'mdi-home-city', permission: 'view-departments' },
    { title: 'Типи обладнання', path: '/types', icon: 'mdi-format-list-bulleted', permission: 'view-types' },
    { title: 'Моделі обладнання', path: '/hardware-models', icon: 'mdi-memory', permission: 'view-hardware-models' },
    { title: 'Моделі ліцензій', path: '/software-models', icon: 'mdi-microsoft', permission: 'view-software-models' },
    { title: 'Статуси', path: '/statuses', icon: 'mdi-information', permission: 'view-statuses' },
];
