<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <Subheader :title="`Contact`" :separator="true">
            <template v-slot:content>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">Enter Contact details and submit</span>
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
                                <h3>Contact Informations</h3>
                                <br>
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
                                        <label for="email" class="col-form-label">Email:</label>
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
                                    <FieldAdd @special_field="FieldName" />
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
import FieldAdd from '../Guests/FieldAdd'

export default {
    name: 'GuestAdd',
    components: {
        Subheader,
        FieldAdd,
        ButtonBack
    },
    data() {
        return {
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
            errors: null,
            notify: null,
            loading: false
        }
    },
    computed: {
        guest_name() {
            return `${this.guest.first_name} ${this.guest.last_name}`
        },
        user_id() {
            return this.$store.getters['auth/currentUser'].id
        }
    },
    methods: {
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
        FieldName(name){
            this.field_name = { 
                'field_name' : name
            }
        },
        handleSubmit(proceed = 'default') {

            this.validation();

            this.loading = true

            if (!this.form.valid()) {
                this.loading = false
                return
            }
            this.$http.post('guests/addfields', this.field_name)
            .then(response => {
                    
               
                    this.fld_id = response.data.id

                    localStorage.setItem('FieldId', this.fld_id)

                    

                    
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

            this.guest.guest_name = this.guest_name
            this.guest.user_id   = this.user_id

            if (localStorage.getItem('FieldId') != undefined) {
                this.guest.field_id = parseInt(localStorage.getItem('FieldId')) + 1
            }else{
                this.guest.field_id = 1;
            }
            

            //this.guest.field_id = this.guest.field_id + 1

            


            this.$http.post('guests', this.guest)
                .then(response => {

                    this.loading = false

                    if (response.data.status === 'success') {
                        const type    = 'success'
                        const content = {
                            title  : 'Contact has been added',
                            message: `${this.guest.first_name} is now a new contact`
                        }
                        if (typeof proceed !== 'string') {
                            this.notification(type, content)
                            this.$router.push({ path: '/guests' })
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
        }
    }
}
</script>

