<template>
  <div>
    <form id="guest-list-form" @submit.prevent="handleSubmit" autocomplete="off">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Contacts</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="filter_by">Select Contact</label>
                    <select v-model="folio_guest.guest_id" class="form-control kt-select2 select2-hidden-accessible" name="guest_id">
                        <option v-for="guest in guests" :key="guest.id" :value="guest.id">{{ guest.guest_name }}</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" :class="{ 'kt-spinner kt-spinner--right kt-spinner--light' : saving }" :disabled="saving">{{ saving ? 'Adding' : 'Add' }}</button>
            </div>
        </div>
    </form>
  </div>
</template>

<script>
export default {
    data() {
        return {
            validator: null,
            guests: [],
            folio_guest: {
                folio_id : '',
                guest_id : '',
            },
            errors: null,
            saving: false,
            notify: null,
        }
    },
    mounted() {
        this.fetchLists()
        this.initValidation()
    },
    beforeDestroy() {
        $('.kt-select2').selectpicker('destroy')
        this.validator.destroy()
    },
    methods: {
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
        initValidation() {
            this.validator = $('#guest-list-form').validate({
                rules: {
                    folio_id: { required: true },
                    guest_id: { required: true }
                }
            })
        },
        fetchLists() {
                this.$http.get('guests/')
                    .then(response => {
                        // console.log(response)
                        this.guests = response.data
                        this.$nextTick(() => { $('.kt-select2').selectpicker({ liveSearch: true }) })
                    })
                    .catch(error => console.log(error))
        },
        resetSelectpicker() {
            this.$nextTick(() => $('.kt-select2').selectpicker({ refresh: true }));
        },
        handleSubmit() {

            if (!this.validator.form()) {
                return
            }

            this.saving = true;

            this.$http.post(`folios/${this.$route.params.id}`, this.folio_guest)
                    .then(response => {
                        console.log(response.data)
                        this.saving = false

                        if (response.data.status === 'success') {
                            const type    = 'success'
                            const content = {
                                title  : 'New Contact',
                                message: `Added`
                            }
                            this.notification(type, content)
                            setTimeout(() => {
                                this.$emit('reloadGuests')
                                $('#newGuestFolioListModal').modal('hide')
                            }, 250)
                            this.resetSelectpicker();
                        }
                    })
                    .catch(error => {
                        this.saving = false
                        this.errors = Object.values(error.response.data.errors);
                        this.errors = this.errors.flat()
                        console.log(error.response)

                        const content = {
                            title: error.response.data.message,
                            message: this.errors.map(function(error) {
                                return `<li>${error}</li>`
                            }).join('')
                        }

                        this.notification('danger', content)

                        setTimeout(() => {
                            $('#newGuestFolioListModal').modal('hide')
                        }, 250)
                    })

                    this.$emit('cool_event_name')

        }
    }
}
</script>