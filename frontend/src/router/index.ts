import {createRouter, createWebHistory} from 'vue-router';
import FieldsSummaryView from './../views/FiedsSummaryView.vue'


const routes = [
    {
        path: '/fields',
        name: 'Fields', component: FieldsSummaryView
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

export default router;