import AppForm from '../app-components/Form/AppForm';
import Multiselect from 'vue-multiselect'

Vue.component('contract-list-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                branch_id: '',
                contract_number: '',
                start_contract_date: '',
                end_contract_date: '',
                partner_id: '',
                partner_bin: '',
                agent_id: '',
                pay_status_id: '',
                pay_type_id: '',
                agent_fee: '',
                enabled: false
            },
            partner_bins: [],
            partners_data: [],
            partner_id_select: '',
            partner_id: '',

            branch_data: [],
            branch_id: '',

            agent_data: [],
            agent_id: '',

            pay_status_data: [],
            pay_status_id: '',

            pay_type_data: [],
            pay_type_id: '',

            datePickerConfigDate: {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd.m.Y',
                locale: null
            }
        }
    },
    methods: {
        partnerBin() {
            var url = new URL(location.href);
            axios.get('/api/partners/getBin')
            .then(r => {
                this.partner_bins = r.data;

            }).catch(error => {
                console.log( error.message);
            })
        },
        getPartners() {
            var url = new URL(location.href);
            axios.get('/api/partners/')
                .then(r => {
                    this.partners_data = r.data.results;
                    if (this.form.partner_id !== '') {
                        const value = r.data.results.map((items) => {
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
            for (let i = 0; i < this.partner_bins.length; i++) {
                if (this.partner_bins[i].id === partner_id.id) {
                    this.form.partner_bin = this.partner_bins[i].bin;
                }
            }
        },
        getBranches() {
            var url = new URL(location.href);
            axios.get('/api/branches/')
                .then(r => {
                    this.branch_data = r.data.results;
                    if (this.form.branch_id !== '') {
                        const value = r.data.results.map((items) => {
                            if (items.id === this.form.branch_id) {
                                this.branch_id = items;
                            }
                        })
                    }
                }).catch(error => {
                console.log( error.message);
            })
        },
        updateFormBranch(branch_id) {
            this.form.branch_id = branch_id.id;
        },
        getAgents() {
            var url = new URL(location.href);
            axios.get('/api/agents/')
                .then(r => {
                    this.agent_data = r.data.results;
                    if (this.form.agent_id !== '') {
                        const value = r.data.results.map((items) => {
                            if (items.id === this.form.agent_id) {
                                this.agent_id = items;
                            }
                        })
                    }
                }).catch(error => {
                console.log( error.message);
            })
        },
        updateFormAgent(agent_id) {
            this.form.agent_id = agent_id.id;
        },
        getPayStatuses() {
            var url = new URL(location.href);
            axios.get('/api/pay-statuses/')
                .then(r => {
                    this.pay_status_data = r.data.results;
                    if (this.form.pay_status_id !== '') {
                        const value = r.data.results.map((items) => {
                            if (items.id === this.form.pay_status_id) {
                                this.pay_status_id = items;
                            }
                        })
                    }
                }).catch(error => {
                console.log( error.message);
            })
        },
        updateFormPayStatus(pay_status_id) {
            this.form.pay_status_id = pay_status_id.id;
        },
        getPayTypes() {
            var url = new URL(location.href);
            axios.get('/api/pay-types/')
                .then(r => {
                    this.pay_type_data = r.data.results;
                    if (this.form.pay_type_id !== '') {
                        const value = r.data.results.map((items) => {
                            if (items.id === this.form.pay_type_id) {
                                this.pay_type_id = items;
                            }
                        })
                    }
                }).catch(error => {
                console.log( error.message);
            })
        },
        updateFormPayType(pay_type_id) {
            this.form.pay_type_id = pay_type_id.id;
        },
    },
    beforeMount() {
        this.partnerBin();
        this.getPartners();
        this.getBranches();
        this.getAgents();
        this.getPayStatuses();
        this.getPayTypes();
    }
});
