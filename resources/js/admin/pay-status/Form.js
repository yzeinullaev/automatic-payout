import AppForm from '../app-components/Form/AppForm';

Vue.component('pay-status-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                enabled:  false ,

            }
        }
    }

});
