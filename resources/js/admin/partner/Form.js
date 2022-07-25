import AppForm from '../app-components/Form/AppForm';

Vue.component('partner-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                bin:  '' ,
                branch_id:  '' ,
                perex:  '' ,
                enabled:  false ,

            },
            branch_data: [],
            branch_id: '',
        }
    },
    methods: {
        getPartnerBranches() {
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
        }
    },
    beforeMount() {
        this.getPartnerBranches();
    }

});
