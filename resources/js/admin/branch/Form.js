import AppForm from '../app-components/Form/AppForm';

Vue.component('branch-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                number:  '' ,
                address:  '' ,
                bin:  '' ,
                customer: '',
                customer_initials: '',
                enabled:  false ,

            }
        }
    }

});
