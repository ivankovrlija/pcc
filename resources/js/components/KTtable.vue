<template>
    <div class="table-wrapper" ref="tableContainer">
        <KTtableFilters v-if="canfilter" :options="options" @triggerSearch="triggerSearch" :columns="guestcolumns" />
        <div class="datatable"></div>
    </div>
</template>

<script>
import KTtableFilters from './KTtableFilters';

export default {
    name: 'KTtable',
    components: {
        KTtableFilters
    },
    props: {
        activegroup: {
            type: Number
        },
        search: {
            type: Boolean,
            default: true
        },
        list: {
            type: Object,
            default: function() {
                return {
                    id: 1,
                    name: 'Hot Leads',
                    filter_by: ''
                }
            }
        },
        route: {
            type: String,
            default: ''
        },
        canedit: {
            type: Boolean,
            default: false
        },
        candelete: {
            type: Boolean,
            default: false
        },
        canfilter: {
            type: Boolean,
            default: false
        },
        options: Array,
        type: {
            type: String,
            required: true
        },
        guestcolumns: Object,
        coursecolumns: Object,
        foliocolumns: Object,
        campaign: String,
        action_edit: String,
        action_delete: String,
    },
    data: function() {
        return {
            table: null
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters['auth/currentUser']
        },
        courseColumns: function() {
            let columns = [
                {
                    field: 'name',
                    title: 'Name',
                    template: raw => {
                        return `<div class="kt-user-card-v2">
                            <div class="kt-user-card-v2__details">
                                <a class="kt-user-card-v2__name js-edit-action" href="/courses/${ raw.id }">${ raw.name }</a>
                            </div>
                        </div>`
                    }
                }, {
                    field: 'type',
                    title: 'Type'
                }, {
                    field: 'year',
                    title: 'Year'
                }
            ]

            if (this.coursecolumns) {                
                let selectedColumns = [];
                for (let key in this.coursecolumns) {
                    if (this.coursecolumns[key]) {
                        selectedColumns.push(key)
                    }
                }

                columns = columns.filter(column => {
                    return selectedColumns.includes(column.field)
                })
            }

            return columns;
        },
        guestColumns: function() {
            let columns = [
                {
                    field: 'guest_name',
                    title: 'Name',
                    template: raw => {
                        return `<div class="kt-user-card-v2">
                            <div class="kt-user-card-v2__details">
                                <a class="kt-user-card-v2__name js-edit-action" href="/guests/${ raw.id }">${ raw.guest_name }</a>
                            </div>
                        </div>`
                    }
                }, {
                    field: 'email',
                    title: 'Email'
                }, {
                    field: 'phone',
                    title: 'Phone'
                }, {
                    field: 'address',
                    title: 'Address'
                }, {
                    field: 'zip',
                    title: 'Zip'
                }, {
                    field: 'city',
                    title: 'City'
                }
            ]

            if (this.guestcolumns) {                
                let selectedColumns = [];
                for (let key in this.guestcolumns) {
                    if (this.guestcolumns[key]) {
                        selectedColumns.push(key)
                    }
                }

                columns = columns.filter(column => {
                    return selectedColumns.includes(column.field)
                })
            }

            return columns;
        },
        folioColumns: function() {
            let columns = [
                {
                    field: 'folio_name',
                    title: 'Group Name',
                    template: raw => {
                        return `<div class="kt-user-card-v2">
                            <div class="kt-user-card-v2__details">
                                <a class="kt-user-card-v2__name js-edit-action" href="/folios/${ raw.id }">${ raw.folio_name }</a>
                            </div>
                        </div>`
                    }
                }
            ]

            if (this.foliocolumns) {                
                let selectedColumns = [];
                for (let key in this.foliocolumns) {
                    if (this.foliocolumns[key]) {
                        selectedColumns.push(key)
                    }
                }

                columns = columns.filter(column => {
                    return selectedColumns.includes(column.field)
                })
            }

            return columns;
        },
        columns: function() {
            let columns = [
                {
                    field: 'id',
                    title: 'ID',
                    width: 40,
                }
            ]

            if (this.type === 'guests') {
                columns = [...columns, ...this.guestColumns];
            }


            if (this.type === 'courses') {
                columns = [...columns, ...this.courseColumns];
            }
            
            if (this.type === 'folios') {
                columns = [...columns, ...this.folioColumns];
            }

            if (this.canedit || this.candelete) {
                columns.push({
                    field: "Actions",
                    width: 120,
                    title: "Actions",
                    sortable: false,
                    autoHide: false,
                    overflow: 'visible',
                    template: raw => {
                        let html = '';

                        if (this.canedit || this.currentUser.id === raw.user_id) {
                            html += `
                                <a href="${this.action_edit}/${raw.id}" class="btn btn-sm btn-clean btn-icon btn-icon-md js-edit-action">
                                    <i class="la la-edit"></i>
                                </a>
                            `
                        }

                        if (this.candelete || this.currentUser.id === raw.user_id) {
                            html += `
                                <a href="${this.action_delete}/${raw.id}" class="btn btn-sm btn-clean btn-icon btn-icon-md js-delete-action">
                                    <i class="la la-trash"></i>
                                </a>
                            `
                        }

                        return html
                    }
                })
            }

            return columns
        }
    },
    mounted: function() {
        this.createTable();
    },
    methods: {
        createTable: function() {
            if (this.table) { this.table.destroy() }

            this.$nextTick(() => {
                this.table = $(this.$refs.tableContainer).find('.datatable').KTDatatable({
                    data: {
                        type: "remote",
                        pageSize: 10,
                        serverPaging: true,
                        serverSorting: false,
                        serverFiltering: false,
                        saveState: {
                            cookie: true,
                            webstorage: true
                        },
                        source: {
                            read: {
                                url: this.route,
                                method: "GET",
                                headers: {
                                    Authorization: `Bearer ${this.$store.getters['auth/currentUser'].token}`
                                },
                                map: function(raw) {
                                    let dataSet = raw;
                                    if (typeof raw.data !== 'undefined') {
                                        dataSet = raw.data;
                                    }
                                    return dataSet;
                                },
                                params: {
                                    filter: this.list.filter_by,
                                    campaign: this.campaign,
                                    conditions: this.list.conditions
                                }
                            }
                        }
                    },
                    columns: this.columns,
                    search: {
                        delay: 400,
                        input: this.$refs.search,
                        onEnter: false,
                    }
                });
    
                this.actionEvents()
                this.table.on('kt-datatable--on-layout-updated', () => this.actionEvents())
            })
        },
        triggerSearch: function(payload) {
            if (!this.table) return;

            let query = this.table.getDataSourceParam('query');

            if (payload.length < 1) {
                query = { general: query !== null ? query.general : '' }
            } else {
                query = { general: query !== null ? query.general : '' };
                payload.forEach(item => { 
                    query[item.field] = item.value
                });
            }

            this.table.setDataSourceParam('query', query);
            this.table.load();
        },
        actionEvents() {
            const self = this

            setTimeout(function() {
                $(self.$refs.tableContainer).on('click', '.js-edit-action', function(e) {
                    e.preventDefault();
                    self.$router.push({ path: $(this).attr('href') })
                })

                $(self.$refs.tableContainer).on('click', '.js-delete-action', function(e) {
                    e.preventDefault();
                    const $row   = $(this).closest('tr')
                    const target = $(this).attr('href')

                    swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        confirmButtonColor: KTAppOptions.colors.state.danger
                    }).then(result => {
                        if (result.value) {
                            self.$http.delete(target)
                                .then(response => {
                                    if (response.data.status === 'success') {
                                        swal.fire('Deleted!', 'Course has been deleted.', 'success')
                                        self.createTable()
                                    }
                                })
                                .catch(error => console.log(error))
                        }
                    })
                })
            })
        }
    }
}
</script>
