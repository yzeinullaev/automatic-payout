import AppListing from '../app-components/Listing/AppListing';
import _lodash from "lodash";

Vue.component('contract-list-month-listing', {
    mixins: [AppListing],
    methods: {
        DownloadActs: function DownloadActs(url) {
            var _this5 = this;

            var itemsToDelete = (0, _lodash.keys)((0, _lodash.pickBy)(this.bulkItems));

            this.$modal.show('dialog', {
                title: 'Подтверждение!',
                text: 'Вы уверены что хотите вытащить ' + this.clickedBulkItemsCount + ' записи в 1 файл?',
                buttons: [{ title: 'Нет, отменить.' }, {
                    title: '<span class="btn-dialog btn-success">Да, записать.<span>',
                    handler: function handler() {
                        _this5.$modal.hide('dialog');
                        axios.post(url, {
                            data: {
                                'ids': itemsToDelete
                            }
                        }).then(function (response) {
                            window.location.href = '/storage/get_local.xlsx';
                            _this5.$notify({ type: 'success', title: 'Success!', text: response.data.message ? response.data.message : 'Данные успешно записались в файл.' });
                        }, function (error) {
                            _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'Ошибка при записи в файл' });
                        });
                    }
                }]
            });
        },
        DownloadApplications: function DownloadApplications(url) {
            var _this6 = this;
            var itemsToDelete = (0, _lodash.keys)((0, _lodash.pickBy)(this.bulkItems));

            this.$modal.show('dialog', {
                title: 'Подтверждение!',
                text: 'Вы уверены что хотите вытащить приложении выбранных месяцев в 1 файл?',
                buttons: [{ title: 'Нет, отменить.' }, {
                    title: '<span class="btn-dialog btn-success">Да, записать.<span>',
                    handler: function handler() {
                        _this6.$modal.hide('dialog');
                        axios.post(url, {
                            data: {
                                'ids': itemsToDelete
                            }
                        }).then(function (response) {
                            window.location.href = '/api/contract-list-month/download-delete-doc-file/'+response.data.url;
                            console.log(response.data.url.toString(), response.data);
                            // location.href = response.data.url.toString();
                            _this6.$notify({ type: 'success', title: 'Success!', text: response.data.message ? response.data.message : 'Данные успешно записались в файл.' });
                        }, function (error) {
                            _this6.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'Ошибка при записи в файл' });
                        });
                    }
                }]
            });
        }
    }
});
