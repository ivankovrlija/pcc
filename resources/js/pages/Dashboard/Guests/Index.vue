<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <!-- begin:: Subheader -->
        <Subheader :title="`Contacts`">
            <template v-slot:toolbar>
                <router-link
                    to="/guests/create"
                    class="btn btn-label-brand btn-bold"
                >
                   New Contact
                </router-link>

                <a href="#" class="btn btn-label-brand btn-bold" @click.prevent="handleSeed">Add 10k Contacts</a>
            </template>
        </Subheader>

        <!-- end:: Subheader -->

        <!-- begin:: Content -->
        <div id="kt_content" class="kt-content kt-grid__item kt-grid__item--fluid">
            <div v-for="(list, index) in lists" :key="list.id" :id="`portlet_${index}`" class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ list.name }}</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <KTtable
                        :guestcolumns="list.columns"
                        :list="list"
                        route="/api/datatable/guests"
                        type="guests"
                        :options="JSON.parse(list.conditions)"
                        :canfilter="true"
                        :canedit="true"
                        :candelete="true"
                        action_edit="/guests"
                        action_delete="/guests"
                        :key="tableKey"
                    />
                </div>
            </div>
            <div id="my-leads" class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">My Contacts</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <KTtable
                        :list="{ filter_by: 'owned' }"
                        route="/api/datatable/guests"
                        type="guests"
                        :options="optionsForDefaults"
                        :canfilter="false"
                        :canedit="true"
                        :candelete="true"
                        action_edit="/guests"
                        action_delete="/guests"
                        :key="tableKey"
                    />
                </div>
            </div>
        </div>
    
        <!-- end:: Content -->

    </div>
</template>

<script>
import { openWindow } from '../../../helpers/general'
import Subheader from '../../../includes/Subheader'
import DefaultUser from '../../../../images/users/default.jpg'
import KTtable from '../../../components/KTtable'

export default {
    name: 'Guestfolio',
    components: {
        Subheader,
        KTtable
    },
    data() {
        return {
            lists: [],
            optionsForDefaults: [
                { label: 'Name', value: 'guest_name' },
                { label: 'Email', value: 'email' },
                { label: 'Address', value: 'address' },
                { label: 'Zip', value: 'zip' },
                { label: 'City', value: 'city' },
            ],
            tableKey: 0,
            importing: false
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters['auth/currentUser']
        },
        popupHost() {
            if (process.env.NODE_ENV === 'development') { return '' }
            else { return 'https://cloudcom.businessai.io' }
        }
    },
    mounted() {

        new KTPortlet('my-guests')
        new KTPortlet('hot-guests')
    },
    methods: {
        handleSeed(){
            this.$http.post('guests/addmany500')
                .then(response => {
                    //alert('success 1')
                    new KTPortlet('my-guests')
                    this.tableKey += 1

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {
                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {

                    this.$http.post('guests/addmany1000')
                .then(response => {
                    
                    
                    
                    
                })
                    
                    
                })
                    
                    
                })
                    
                    
                })

                    
                    
                })

                    
                    
                })

                    
                    
                })

                    
                    
                })

                    
                    
                })

                    
                    
                })

                    
                    
                })

                    
                    
                })
                    
                    
                })
                .catch(error => {
                    this.loading = false
                    this.errors = Object.values(error.response.data.errors);
                    this.errors = this.errors.flat()

                    const content = {
                        title: error.response.data.message,
                        message: this.errors.map(function(error) {
                            return `<li>${error}</li>`
                        }).join('')
                    }

                    this.notification('danger', content)
                })

                



        }
        
    }
}
</script>


