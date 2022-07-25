import AppListing from '../app-components/Listing/AppListing';

Vue.component('agent-listing', {
    mixins: [AppListing],
    data: function() {
        return {
            agent_data: {},
            before_agent_data: {}
        }
    },
    methods: {
        toggleSwitchAgent(url, col, row) {
            this.agent_data = row;
            this.agent_data = this.before_agent_data;
            var _partner_url = new URL(location.href);
            axios.get('/api/partners/')
                .then(r => {
                    r.data.results.map((items) => {
                        if (items.text === row.branch_id) {
                            this.agent_data.parnter_id = items.id;
                        }
                    })
                }).catch(error => {
                let _this = this;
                _this.$notify({ type: 'error', title: 'Error!', text: error.message ?? 'An error has Branch Api.' });
            })

            let self = this;

            axios.post(url, this.agent_data).then(function (response) {
                self.$notify({ type: 'success', title: 'Success!', text: response.data.message ? response.data.message : 'Item successfully changed.' });
            }, function (error) {
                self.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            });
        }
    }
});
