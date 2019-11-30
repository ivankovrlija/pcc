<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <Subheader :title="`Contact`" :separator="true">
            <template v-slot:content>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">Enter contact details and submit</span>
                </div>
            </template>
            <template v-slot:toolbar>
                <ButtonBack />
                <div class="btn-group">
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
                <div class="kt-portlet__head" :class="{ 'bg-danger': guest.marked }">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title" :class="{ 'text-white': guest.marked }">{{ guest.guest_name }}</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <form class="kt-form" id="kt_apps_user_add_lead_form" novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-6 divider">
                                <h3>Contact Information</h3>
                                <br>
                            	<div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="acc_name" class="col-form-label">Group Name:</label>
                                        <a class="acc_link" @click="checkAccount" v-model="acc_name">{{acc_name}}</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="first_name" class="col-form-label">First Name:</label>
                                        <input v-model="guest.first_name" type="text" name="first_name" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="last_name" class="col-form-label">Last Name:</label>
                                        <input v-model="guest.last_name" type="text" name="last_name" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="email" class="col-form-label">Email :</label>
                                        <input v-model="guest.email" type="email" name="email" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="phone" class="col-form-label">Phone:</label>
                                        <input v-model="guest.phone" type="text" name="phone" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="address" class="col-form-label">Address:</label>
                                        <input v-model="guest.address" type="text" name="address" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="city" class="col-form-label">City:</label>
                                        <input v-model="guest.city" type="text" name="city" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="zip" class="col-form-label">Zip:</label>
                                        <input v-model="guest.zip" type="text" name="zip" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="country" class="col-form-label">Country:</label>
                                        <input v-model="guest.country" type="text" name="country" class="form-control">
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="note" class="col-form-label">Note:</label>
                                        <input v-model="guest.note" type="text" name="note" class="form-control">
                                    </div>
                                    <FieldUpdate @special_field_updated="FieldNameUpdated" />
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
import Subheader from '../../../includes/Subheader'
import ButtonBack from '../../../components/ButtonBack'
import FieldUpdate from '../Guests/FieldUpdate'

export default {
    name: 'GuestsUpdate',
    components: {
        Subheader,
        FieldUpdate,
        ButtonBack
    },
    data() {
        return {
            guest_id: null,
            lead_owner: false,
            form: null,
            guest: {
                field_id             : '',
                first_name           : '',
                last_name            : '',
                email                : '',
                phone                : '',
                address              : '',
                city                 : '',
                zip                  : '',
                country              : '',
                note                 : ''
            },
            field_name               : {
                'field_name'         : ''
            },
            acc_name             : '',
            acc_id               : '',
            errors: null,
            notify: null,
            loading: false
        }
    },
    computed: {
        guest_name() {
            return `${this.guest.first_name} ${this.guest.last_name}`
        },
        currentUser() {
            return this.$store.getters['auth/currentUser']
        }
    },
    mounted() {
        this.fetchGuest()
    },
    methods:{
        FieldNameUpdated(name){
            this.field_name = { 
                'field_name' : name
            }
        },
        fetchGuest() {
            this.$http.get(`guests/${this.$route.params.id}`)
                .then(response => {
                    this.guest_id = response.data.id
                    this.lead_owner = response.data.user_id === this.currentUser.id
                    this.guest = {
                        user_id        : response.data.user_id,
                        field_id       : response.data.field_id,
                        guest_name     : response.data.guest_name,
                        first_name     : response.data.first_name,
                        last_name      : response.data.last_name,
                        email          : response.data.email,
                        phone          : response.data.phone,
                        address        : response.data.address,
                        city           : response.data.city,
                        zip            : response.data.zip,
                        country        : response.data.country,
                        note           : response.data.note
                    }
                    this.acc_name        = response.data.acc_name
                    this.acc_id      = response.data.acc_id
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
                    first_name: { required: true },
                    last_name: { required: true },
                    phone: { digits: true },
                    email: {
                        required: true,
                        email: true
                    }
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
            this.guest.first_name      = ''
            this.guest.last_name       = ''
            this.guest.email           = ''
            this.guest.phone           = ''
            this.guest.address         = ''
            this.guest.city            = ''
            this.guest.zip             = ''
            this.guest.country         = ''
            this.guest.note            = ''
        },
        handleSubmit(proceed = 'default') {

            this.$http.put(`guests/addfields/${this.guest.field_id}`, this.field_name).then(response => {


            })
            this.validation();

            this.loading = true

            if (!this.form.valid()) {
                this.loading = false
                return
            }

            this.guest.guest_name = this.guest_name
            this.guest.user_id   = this.currentUser.id
            this.guest.lead_owner = this.guest_by ? this.currentUser.id : null
            this.guest.field_id = this.field_id

            this.$http.put(`guests/${this.$route.params.id}`, this.guest)
                .then(response => {

                    this.loading = false

                    if (response.data.status === 'success') {
                        const type    = 'success'
                        const content = {
                            title  : 'Contact data has been updated',
                            message: `${this.guest.first_name}'s info has been updated`
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
                                this.$router.push({ path: '/guests' })
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
        },
        checkAccount() {
            this.$router.push({ path: `/folios/${this.acc_id}`})
        }
    }
}
</script>

