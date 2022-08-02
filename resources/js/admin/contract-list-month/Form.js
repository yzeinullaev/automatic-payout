import AppForm from '../app-components/Form/AppForm';

Vue.component('contract-list-month-form', {
    mixins: [AppForm],
    props: [
      'contract'
    ],
    data: function() {
        return {
            form: {
                contract_list_id:  '' ,
                month:  '' ,
                pay_decode:  '' ,
                pay_act:  '' ,
                upload_decode_file:  '' ,
                download_akt_file:  ''
            },
            pay_decode: '',
            pagination: {
                state: {
                    per_page: 100, // required
                    current_page: 1, // required
                    last_page: 1, // required
                    from: 1,
                    to: 25 // required
                },
                options: {
                    alwaysShowPrevNext: false
                }
            },
            orderBy: {
                column: 'id',
                direction: 'asc'
            },
            mediaCollections: ['decode_file']
        }
    },
    methods: {
        getPayDecode() {
            this.pay_decode = this.form.pay_decode;
            this.form.pay_act = (this.pay_decode * this.contract.agent_fee / 100).toFixed(2);
        },
        updatePayAct(pay_decode) {
            this.form.pay_decode = this.pay_decode;
            this.form.pay_act = (this.pay_decode * this.contract.agent_fee / 100).toFixed(2);
        }
    },
    beforeMount() {
        this.getPayDecode();
    }

});
