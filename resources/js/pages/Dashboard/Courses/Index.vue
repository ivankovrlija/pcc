<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <!-- begin:: Subheader -->
        <Subheader :title="`Courses`">
            <template v-slot:toolbar>
                <router-link
                    to="/courses/create"
                    class="btn btn-label-brand btn-bold"
                >
                   New Course
                </router-link>
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
                        :coursecolumns="list.columns"
                        :list="list"
                        route="/api/datatable/courses"
                        type="courses"
                        :options="JSON.parse(list.conditions)"
                        :canfilter="true"
                        :canedit="true"
                        :candelete="true"
                        action_edit="/courses"
                        action_delete="/courses"
                        :key="tableKey"
                    />
                </div>
            </div>
            <div id="my-leads" class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">My Courses</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <KTtable
                        :list="{ filter_by: 'owned' }"
                        route="/api/datatable/courses"
                        type="courses"
                        :options="optionsForDefaults"
                        :canfilter="false"
                        :canedit="true"
                        :candelete="true"
                        action_edit="/courses"
                        action_delete="/courses"
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
    name: 'Course',
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
        
    }
}
</script>


