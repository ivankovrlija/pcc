<template>
    <div class="lead-logs">
        <template>
            <ul class="nav nav-tabs  nav-tabs-line" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#topbar_notifications_contacts" role="tab" aria-selected="true">Contacts</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="topbar_notifications_contacts" role="tabpanel">
                    <GuestFolioLogsContacts :loading="loading"/>
                </div>
            </div>
            <div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>
        </template>
    </div>
</template>

<script>

import GuestFolioLogsContacts from './GuestFolioLogsContacts';
import PerfectScrollbar from 'perfect-scrollbar';

export default {
    name: 'GuestFolioLogs',
    components: {
        GuestFolioLogsContacts
    },
    props: {
        guestfolio: Object,
        guestfolio_id: Number
    },
    data() {
        return {
            logs: [],
            loading: true,
            ps: null,
            componentKey: 0,
            task: null
        }
    },
    computed: {
        hasLogs() {
            return this.logs.length
        },
        user_id() {
            return this.$store.getters['auth/currentUser'].id
        },
        currentUser() {
            return this.$store.getters['auth/currentUser']
        }
    },
    mounted() {
        this.fetchGuestFolioLogs();
    },
    methods: {
        forceRerender() {
            this.componentKey += 1
    },
        fetchGuestFolioLogs() {
            if (!this.guestfolio_id) return

            this.$http.get(`guestfoliologs/${this.guestfolio_id}`, {}).then(response => {
                this.loading = false
                this.logs    = response.data
                // console.log(this.logs);
                this.$nextTick(() => {
                    if (this.ps) { this.ps.update() }
                    // else { this.ps = new PerfectScrollbar('#scrollable') }
                })
            })
        },
        handleSubmit(payload) {
            this.loading = true;

            this.$http.post(`guestfoliologs`, {
                user_id: this.user_id,
                guestfolio_id: this.guestfolio_id,
                ...payload.data
            }).then(response => {
                this.fetchGuestFolioLogs()
            });
        }
    },
    watch: {
        guestfolio_id: function(newId) {
            this.fetchGuestFolioLogs()
        }
    }
}
</script>
