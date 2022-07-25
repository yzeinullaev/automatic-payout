import AppListing from '../app-components/Listing/AppListing';

Vue.component('partner-listing', {
    mixins: [AppListing],
    data: function() {
        return {
            partner_data: {},
            before_partner_data: {}
        }
    },
    methods: {
        toggleSwitchPartner(url, col, row) {
            this.partner_data = row;
            this.partner_data = this.before_partner_data;
            var _branch_url = new URL(location.href);
            axios.get('/api/branches/')
                .then(r => {
                    r.data.results.map((items) => {
                        if (items.text === row.branch_id) {
                            this.partner_data.branch_id = items.id;
                        }
                    })
                }).catch(error => {
                let _this = this;
                _this.$notify({ type: 'error', title: 'Error!', text: error.message ?? 'An error has Branch Api.' });
            })

            let self = this;

            axios.post(url, this.partner_data).then(function (response) {
                self.$notify({ type: 'success', title: 'Success!', text: response.data.message ? response.data.message : 'Item successfully changed.' });
            }, function (error) {
                self.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            });
        }
    }
});
