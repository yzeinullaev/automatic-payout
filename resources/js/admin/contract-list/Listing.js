import AppListing from '../app-components/Listing/AppListing';

Vue.component('contract-list-listing', {
    mixins: [AppListing],

    data() {
        return {
            showBranchesFilter: false,
            branchesMultiselect: {},

            showPayStatusFilter: false,
            payStatusMultiselect: {},

            showPayTypesFilter: false,
            payTypesMultiselect: {},

            filters: {
                branches: [],
                payStatus: [],
                payTypes: [],
            },
        }
    },
    methods: {
        truncData(text) {
            return text.slice(0, 28)+"...";
        }
    },
    watch: {
        showBranchesFilter: function (newVal, oldVal) {
            this.branchesMultiselect = [];
        },
        branchesMultiselect: function(newVal, oldVal) {
            this.filters.branches = newVal.map(function(object) { return object['key']; });
            this.filter('branches', this.filters.branches);
        },

        showPayStatusFilter: function (newVal, oldVal) {
            this.payStatusMultiselect = [];
        },
        payStatusMultiselect: function(newVal, oldVal) {
            this.filters.payStatus = newVal.map(function(object) { return object['key']; });
            this.filter('payStatus', this.filters.payStatus);
        },

        showPayTypesFilter: function (newVal, oldVal) {
            this.payTypesMultiselect = [];
        },
        payTypesMultiselect: function(newVal, oldVal) {
            this.filters.payTypes = newVal.map(function(object) { return object['key']; });
            this.filter('payTypes', this.filters.payTypes);
        }
    }
});
