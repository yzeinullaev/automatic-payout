import AppForm from '../app-components/Form/AppForm';

Vue.component('agent-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                initials:  '' ,
                iin:  '' ,
                address:  '' ,
                requisite:  '' ,
                partner_id:  '' ,
                enabled:  false ,

            },
            partner_data: [],
            partner_id: '',
        }
    },
    methods: {
        getAgentPartners() {
            var url = new URL(location.href);
            axios.get('/api/partners/')
            .then(r => {
                this.partner_data = r.data.results;
                if (this.form.partner_id !== '') {
                    r.data.results.map((items) => {
                        if (items.id === this.form.partner_id) {
                            this.partner_id = items;
                        }
                    })
                }
            }).catch(error => {
                console.log( error.message);
            })
        },
        updateFormPartner(partner_id) {
            this.form.partner_id = partner_id.id;
        }
    },
    beforeMount() {
        this.getAgentPartners();
    }
});
