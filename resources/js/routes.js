import Home from './pages/Home'
import Dashboard from './pages/Dashboard/Index.vue'
import Guest from './pages/Dashboard/Guests/Index.vue'
import GuestAdd from './pages/Dashboard/Guests/GuestAdd.vue'
import GuestUpdate from './pages/Dashboard/Guests/GuestUpdate.vue'
import Folio from './pages/Dashboard/Folios/Index.vue'
import FolioAdd from './pages/Dashboard/Folios/FolioAdd.vue'
import FolioAddGuests from './pages/Dashboard/Folios/FolioAddGuests.vue'
import FolioUpdate from './pages/Dashboard/Folios/FolioUpdate.vue'
import Profile from './pages/Dashboard/Profile/Index.vue'
import Login from './pages/Login'
import PageNotFound from './pages/PageNotFound'
import Unsubscribe from './pages/Unsubscribe'
import FieldUpdate from './pages/Dashboard/Guests/FieldAdd.vue'



import FieldAdd from './pages/Dashboard/Guests/FieldUpdate.vue'

export const routes = [
    {
        path: '/',
        component: Home,
        children: [
            { path: '', component: Dashboard },

            { path: 'me', component: Profile },

            { path: 'guests', component: Guest },     
            { path: 'guests/create', component: GuestAdd },     
            { path: 'guests/:id', component: GuestUpdate},

            { path: 'guests/addfields', component: FieldAdd },

            { path: 'guests/addfields/:id', component: FieldUpdate },    

            { path: 'folios', component: Folio },     
            { path: 'folios/create', component: FolioAdd },     
            { path: 'folios/addguests', component: FolioAddGuests },     
            { path: 'folios/:id', component: FolioUpdate },  

        ],
        meta: { requiresAuth: true }
    },
    { path: '/login', component: Login },
    { path: '/unsubscribe', component: Unsubscribe },
    { path: '*', component: PageNotFound }
]