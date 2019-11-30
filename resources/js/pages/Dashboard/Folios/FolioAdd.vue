<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <Subheader :title="`Group`" :separator="true">
            <template v-slot:content>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">Enter Group name and submit</span>
                </div>
            </template>
            <template v-slot:toolbar>
                <ButtonBack />
                <div class="btn-group">
                    <button type="button" class="btn btn-brand btn-bold" :class="{'kt-spinner kt-spinner--right kt-spinner--light': loading}" @click="handleSubmit" :disabled="loading">Submit</button>
                    <button type="button" class="btn btn-brand btn-bold dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" :disabled="loading"></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="kt-nav">
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" @click.prevent="handleSubmit('continue')">
                                    <i class="kt-nav__link-icon flaticon2-writing"></i>
                                    <span class="kt-nav__link-text">Save &amp; continue</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" @click.prevent="handleSubmit('new')">
                                    <i class="kt-nav__link-icon flaticon2-medical-records"></i>
                                    <span class="kt-nav__link-text">Save &amp; add new</span>
                                </a>
                            </li>
                            <li class="kt-nav__item">
                                <a href="#" class="kt-nav__link" @click.prevent="handleSubmit('exit')">
                                    <i class="kt-nav__link-icon flaticon2-hourglass-1"></i>
                                    <span class="kt-nav__link-text">Save &amp; exit</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </template>
        </Subheader>

        <div id="kt_content" class="kt-content kt-grid__item kt-grid__item--fluid">            
            <div class="kt-portlet">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ButtonBack from '../../../components/ButtonBack'
import Subheader from '../../../includes/Subheader'

export default {
    name: 'FolioAdd',
    components: {
        Subheader,
        ButtonBack
    },
    data() {
        return {
            form: null,
            guestfolio: {
                folio_name           : '',
            },
            errors: null,
            notify: null,
            loading: false
        }
    },
    computed: {
        folio_name() {
            return `${this.guestfolio.folio_name}`
        },
        user_id() {
            return this.$store.getters['auth/currentUser'].id
        }
    },
    methods: {
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
            this.guestfolio.folio_name = ''
        },
        handleSubmit(proceed = 'default') {
            this.validation();

            this.loading = true

            if (!this.form.valid()) {
                this.loading = false
                return
            }

            this.guestfolio.folio_name = this.folio_name
            this.guestfolio.user_id   = this.user_id

            this.$http.post('folios', this.guestfolio)
                .then(response => {

                    this.loading = false

                    if (response.data.status === 'success') {
                        const type    = 'success'
                        const content = {
                            title  : 'Group has been added',
                            message: `${this.guestfolio.folio_name} is now a new group`
                        }
                        if (typeof proceed !== 'string') {
                            this.notification(type, content)
                            this.$router.push({ path: '/folios' })
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

