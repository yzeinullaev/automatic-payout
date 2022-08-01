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
            }
        }
    }
});
