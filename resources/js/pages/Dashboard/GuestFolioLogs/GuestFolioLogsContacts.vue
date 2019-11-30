<template>
    <table class="table table-hover m-table m-table--head-bg-primary">
        <thead>
        <tr>
            <th>Contact Name</th>
            <th>Phone</th>
            <th>Bussines Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>City</th>
            <th>Country</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(guest, index) in guests">
            <td class="link_contact" @click="checkContact(guest.id)">{{ guest.guest_name }}</td>
            <td>{{ guest.home_phone }}</td>
            <td>{{ guest.cell_phone }}</td>
            <td>{{ guest.email }}</td>
            <td>{{ guest.address1 }}</td>
            <td>{{ guest.city }}</td>
            <td>{{ guest.country }}</td>
        </tr>
        </tbody>
    </table>
</template>

<style>
.table{
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    background-color: transparent;
}
.table thead th{
    background: #5867dd;
    color: #ffffff;
    border-bottom: 0;
    border-top: 0;
}
.table td,
.table th{
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #f4f5f8;
}
.table td.link_contact:hover{
    color: #5d78ff;
    cursor: pointer;
}
</style>

<script>

export default {
    name: 'GuestFolioLogsContacts',
    data() {
        return {
            guests: [],
            datatable: null
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters['auth/currentUser']
        }
    },
    mounted() {
        this.fetchGuest();
    },
    methods: {
        fetchGuest() {

            this.$http.get(`getfolioguest/${this.$route.params.id}`, {}).then(response => {
                this.loading = false
                this.guests    = response.data
                // console.log(this.guests);
            })

        },
        checkContact(id) {
            this.$router.push({ path: `/guests/${id}`})
        }

    },
}
</script>

