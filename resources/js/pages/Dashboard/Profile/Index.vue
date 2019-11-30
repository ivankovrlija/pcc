<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <Subheader :title="`Me`" :separator="true">
            <template v-slot:content>
                <div class="kt-subheader__group" id="kt_subheader_search">
                    <span class="kt-subheader__desc" id="kt_subheader_total">Enter your details and submit</span>
                </div>
            </template>
            <template v-slot:toolbar>
                <a class="btn btn-default btn-bold" href="javascript:;" @click.prevent="$router.go(-1)">Back</a>
                <div class="btn-group">
                    <button type="button" class="btn btn-brand btn-bold" @click="handleSubmit">Update</button>
                </div>
            </template>
        </Subheader>

        <div id="kt_content" class="kt-content kt-grid__item kt-grid__item--fluid">            
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <form class="kt-form" id="kt_apps_user_add_user_form" novalidate="novalidate" @submit.prevent="handleSubmit">
                        <div class="kt-heading kt-heading--md">Your Profile Details:</div>
                        <div class="kt-section kt-section--first">
                            <div class="kt-wizard-v4__form">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="kt-section__body">
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">Avatar</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_apps_user_add_avatar">
                                                        <div class="kt-avatar__holder" :style="`background-image: url(${avatar})`"></div>
                                                        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                                                            <i class="fa fa-pen"></i>
                                                            <input ref="avatarUploader" type="file" name="avatar" @change="handleImage">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">First Name</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input v-model="user.first_name" class="form-control" type="text" name="first_name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">Last Name</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <input v-model="user.last_name" class="form-control" type="text" name="last_name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">Contact Phone</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-phone"></i></span></div>
                                                        <input v-model="user.phone" type="text" class="form-control" placeholder="Phone" aria-describedby="basic-addon1" name="phone">
                                                    </div>
                                                    <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">Email Address</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-at"></i></span></div>
                                                        <input v-model="user.email" type="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" name="email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">Password</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock"></i></span></div>
                                                        <input v-model="user.password" type="password" class="form-control" id="password" placeholder="Password" aria-describedby="basic-addon1" name="password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 col-form-label text-right">Confirm Password</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-check"></i></span></div>
                                                        <input v-model="user.password_confirmation" type="password" class="form-control" placeholder="Confirm Password" aria-describedby="basic-addon1" name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
import Subheader from '../../../includes/Subheader'
import defaultAvatar from '../../../../images/users/default.jpg'

export default {
    name: 'Profile',
    components: {
        Subheader
    },
    data() {
        return {
            avatar: null,
            form: null,
            user: {
                first_name           : '',
                last_name            : '',
                phone                : '',
                email                : '',
                password             : '',
                password_confirmation: ''
            },
            errors: null,
            notify: null
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters['auth/currentUser']
        }
    },
    mounted() {
        this.fetchProfile()
    },
    methods: {
        fetchProfile(){
            this.$http.get(`me/1`)
                .then(response => {
                    this.user = {
                        first_name        : response.data.first_name,
                        last_name         : response.data.last_name,
                        phone             : response.data.phone,
                        email             : response.data.email
                    }

                    if (response.data.avatar == null) {
                        this.avatar = defaultAvatar
                    }else{
                        this.avatar      = 'http://' + window.location.hostname + response.data.avatar
                    }
                })
                .catch(error => {
                    if (error.response.status === 404) {
                        this.$router.push({ path: 'user/not-found' })
                    }
                })

        },
        validation() {
            this.form = $( "#kt_apps_user_add_user_form" ).validate({
                rules: {
                    first_name: { required: true },
                    last_name: { required: true },
                    phone: { digits: true },
                    email: {
                        required: true,
                        email: true
                    },
                    password_confirmation: { equalTo: '#password' }
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
            this.user.first_name = this.user.last_name = this.user.email = this.user.phone = this.user.password = this.user.password_confirmation = ''
        },
        handleImage() {
            if (this.$refs.avatarUploader.files && this.$refs.avatarUploader.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    this.avatar = e.target.result

                    let data = new FormData()
                    let file = this.$refs.avatarUploader.files[0]
                    data.append('avatar', file, file.name)

                    axios.post('me/avatar', data, {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                    this.avatar = '/uploads/avatars/' + this.$refs.avatarUploader.files[0]['name']
                    this.currentUser.avatar = '/uploads/avatars/' + this.$refs.avatarUploader.files[0]['name']

                    console.log(response)
                })
                    .catch(error => console.log(error.response))
                }

                reader.readAsDataURL(this.$refs.avatarUploader.files[0])

            } else {
                this.avatar = defaultAvatar
            }

        },
        handleSubmit() {
            this.validation();

            this.user.avatar = '/uploads/avatars/' + this.$refs.avatarUploader.files[0]['name'];

            if (!this.form.valid()) { return }

            this.$http.put(`me/${this.currentUser.id}`, this.user)
                .then(response => {
                    if (response.data.status === 'success') {
                        const type    = 'success'
                        const content = {
                            title  : 'Success',
                            message: `Your profile has been updated!`
                        }
                        this.notification(type, content)
                    }
                })
                .catch(error => {
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

                this.$emit('reload_avatar', 'pera')

        }
    }
}
</script>

