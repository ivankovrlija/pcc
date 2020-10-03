import Home from './pages/Home'
import Dashboard from './pages/Dashboard/Index.vue'
import Course from './pages/Dashboard/Courses/Index.vue'
import CourseAdd from './pages/Dashboard/Courses/CourseAdd.vue'
import CourseUpdate from './pages/Dashboard/Courses/CourseUpdate.vue'
import Profile from './pages/Dashboard/Profile/Index.vue'
import Login from './pages/Login'
import PageNotFound from './pages/PageNotFound'
import Unsubscribe from './pages/Unsubscribe'

export const routes = [
    {
        path: '/',
        component: Home,
        children: [
            { path: '', component: Dashboard },

            { path: 'me', component: Profile },

            { path: 'courses', component: Course },     
            { path: 'courses/create', component: CourseAdd },     
            { path: 'courses/:id', component: CourseUpdate},    

        ],
        meta: { requiresAuth: true }
    },
    { path: '/login', component: Login },
    { path: '/unsubscribe', component: Unsubscribe },
    { path: '*', component: PageNotFound }
]