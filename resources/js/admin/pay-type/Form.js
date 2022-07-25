import AppForm from '../app-components/Form/AppForm';

Vue.component('pay-type-form', {
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
