import { createRouter, createWebHistory } from 'vue-router';
import FieldList from '../components/Field/FieldList.vue';
import FieldDetails from '../components/Field/FieldDetails.vue';
import FieldCreate from '../components/Field/FieldCreate.vue';
import FieldEdit from '../components/Field/FieldEdit.vue';

const routes = [
    { path: '/fields', name: 'FieldList', component: FieldList },
    { path: '/fields/create', name: 'FieldCreate', component: FieldCreate },
    { path: '/fields/:id', name: 'FieldDetails', component: FieldDetails },
    { path: '/fields/edit/:id', name: 'FieldEdit', component: FieldEdit },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;