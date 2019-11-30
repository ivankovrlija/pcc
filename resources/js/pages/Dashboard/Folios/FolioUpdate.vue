<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <Subheader :title="`Groups`" :separator="true">
            <template v-slot:content>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">Enter groups details and submit</span>
                </div>
            </template>
            <template v-slot:toolbar>
                <ButtonBack />
                <div class="btn-group">
                    <button
                        class="btn btn-label-brand btn-bold"
                        href="#newGuestFolioListModal"
                        data-toggle="modal"
                    >
                        <i class="la la-plus"></i> New Contact
                    </button>
                    <button type="button" class="btn btn-brand btn-bold" :class="{'kt-spinner kt-spinner--right kt-spinner--light': loading}" @click="handleSubmit" :disabled="loading">Update</button>
                    <button type="button" class="btn btn-brand btn-bold dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" :disabled="loading"></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="kt-nav">
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" @click.prevent="handleSubmit('continue')">
                                    <i class="kt-nav__link-icon flaticon2-writing"></i>
                                    <span class="kt-nav__link-text">Update &amp; continue</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" @click.prevent="handleSubmit('exit')">
                                    <i class="kt-nav__link-icon flaticon2-hourglass-1"></i>
                                    <span class="kt-nav__link-text">Update &amp; exit</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </template>
        </Subheader>

        <div id="kt_content" class="kt-content kt-grid__item kt-grid__item--fluid">            
            <div class="kt-portlet">
                <div class="kt-portlet__head" :class="{ 'bg-danger': guestfolio.marked }">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title" :class="{ 'text-white': guestfolio.marked }">{{ guestfolio.name }}</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <form class="kt-form" id="kt_apps_user_add_lead_form" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="folio_name" class="col-form-label">Group Name:</label>
                                        <input v-model="guestfolio.folio_name" type="text" name="folio_name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!--<div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="lead_source" class="col-form-label">{{ currentUser.full_name }} </label>
                                        <div>
                                            <span class="kt-switch">
                                                <label class="d-flex align-items-center">
                                                    <input v-model="lead_owner" type="checkbox">
                                                    <span class="mr-2"></span>
                                                    Entry By
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <GuestFolioLogs :key="keyComponent" :guestfolio="guestfolio" :guestfolio_id="guestfolio_id" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Start Modal ::: New Guest List -->
        <div class="modal fade" id="newGuestFolioListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <FolioAddGuests @cool_event_name="update" @reloadGuests="fetchGuests"/>
            </div>
        </div>

        <!-- End Modal ::: New Guest List-->
    </div>
</template>

<script>
import Subheader from '../../../includes/Subheader'
import ButtonBack from '../../../components/ButtonBack'
import GuestFolioLogs from '../GuestFolioLogs/GuestFolioLogs'
import FolioAddGuests from './FolioAddGuests'

export default {
    name: 'FolioUpdate',
    components: {
        Subheader,
        ButtonBack,
        GuestFolioLogs,
        FolioAddGuests
    },
    data() {
        return {
            guestfolio_id: null,
            lead_owner: false,
            form: null,
            guestfolio: {
                user_id              : 0,
                folio_name           : ''
            },
            keyComponent: 0,
            errors: null,
            notify: null,
            loading: false
        }
    },
    computed: {
        folio_name() {
            return `${this.guestfolio.folio_name}`
        },
        currentUser() {
            return this.$store.getters['auth/currentUser']
        }
    },
    mounted() {
        this.fetchGuests();
        this.fetchFolio();
    },
    methods: {
        update() {
            this.keyComponent += 1
        },
        fetchGuests() {
            this.$http.get(`getfolioguest/${this.$route.params.id}`, {}).then(response => {
                this.loading = false
                this.guests    = response.data
            })
        },
        fetchFolio() {
            this.$http.get(`folios/${this.$route.params.id}`)
                .then(response => {
                    this.guestfolio_id = response.data.id
                    this.lead_owner = response.data.user_id === this.currentUser.id
                    this.guestfolio = {
                        user_id         : response.data.user_id,
                        folio_name : response.data.folio_name
                    }
                })
                .catch(error => {
                    if (error.response.status === 404) {
                        this.$router.push({ path: 'user/not-found' })
                    }
                })
        },
        validation() {
            this.form = $( "#kt_apps_user_add_lead_form" ).validate({
                rules: {
                    folio_name: { required: true }
                }
            })

            this.form.form()
        },
        notification(type, content) {
            if (this.notify) {
                this.notify.update('type', type)
                this.notify.update('title', content.title)
                this.notify.update('message', content.message)
            }

            this.notify = $.notify(content, { 
                type: type,
                allow_dismiss: false,
                newest_on_top: false,
                mouse_over:  false,
                showProgressbar:  false,
                spacing: 10,
                timer: 2000,
                placement: {
                    from: 'bottom', 
                    align: 'right'
                },
                offset: {
                    x: 30, 
                    y: 30
                },
                delay: 1000,
                z_index: 10000,
                animate: {
                    enter: 'animated fadeInUp',
                    exit: 'animated fadeOutRight'
                }
            });
        },
        resetModels() {
            this.guestfolio.folio_name        = ''
        },
        handleSubmit(proceed = 'default') {
            this.validation();

            this.loading = true

            if (!this.form.valid()) {
                this.loading = false
                return
            }

            this.guestfolio.folio_name = this.folio_name
            this.guestfolio.user_id   = this.currentUser.id
            this.guestfolio.lead_owner = this.guest_by ? this.currentUser.id : null

            this.$http.put(`folios/${this.$route.params.id}`, this.guestfolio)
                .then(response => {

                    this.loading = false

                    if (response.data.status === 'success') {
                        const type    = 'success'
                        const content = {
                            title  : 'Group data has been updated',
                            message: `${this.guestfolio.folio_name}'s info has been updated`
                        }
                        if (typeof proceed !== 'string') {
                            this.notification(type, content)
                        } else {
                            if (proceed === 'continue') {
                                this.notification(type, content)
                            }
                            else if (proceed === 'new') {
                                this.notification(type, content)
                                this.resetModels()
                            }
                            else if (proceed === 'exit') {
                                this.$router.push({ path: '/folios' })
                            }
                        }

                    }
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

