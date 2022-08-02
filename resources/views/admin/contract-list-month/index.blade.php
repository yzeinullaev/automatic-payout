@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.contract-list-month.actions.index'))

@include('admin.contract-list.components.header-scripts')

@section('body')

    <contract-list-month-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/contract-list-months/' . $contract_list_id . '/month' ) }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.contract-list.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/contract-lists') }}" role="button"><i class="fa fa-backward"></i>&nbsp; {{ trans('admin.contract-list-month.actions.back') }}</a>
                        <div v-if="{{ !empty($contract_list_data) }}" class="card-block">
                            <table class="r_table table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th>{{ trans('admin.contract-list.columns.id') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.branch_id') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.contract_number') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.start_contract_date') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.end_contract_date') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.partner_id') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.partner_bin') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.agent_id') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.pay_status_id') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.pay_type_id') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.agent_fee') }}</th>
                                        <th>{{ trans('admin.contract-list.columns.enabled') }}</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $contract_list_data['id'] }}</td>
                                        <td>{{ $contract_list_data['branch_id'] }}</td>
                                        <td>{{ $contract_list_data['contract_number'] }}</td>
                                        <td>{{ $contract_list_data['start_contract_date'] }}</td>
                                        <td>{{ $contract_list_data['end_contract_date'] }}</td>
                                        <td>{{ $contract_list_data['partner_id'] }}</td>
                                        <td>{{ $contract_list_data['partner_bin'] }}</td>
                                        <td>{{ $contract_list_data['agent_id'] }}</td>
                                        <td>{{ $contract_list_data['pay_status_id'] }}</td>
                                        <td>{{ $contract_list_data['pay_type_id'] }}</td>
                                        <td>{{ $contract_list_data['agent_fee'] }}</td>
                                        <td>{{ $contract_list_data['enabled'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">

                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                        </span>
                                        </div>
                                    </div>

                                    {{--<div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>--}}

                                </div>
                            </form>

                            <table class="r_table table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th scope="col" class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>
                                        <th scope="col" is='sortable' :column="'id'">{{ trans('admin.contract-list-month.columns.id') }}</th>
                                        <th scope="col" is='sortable' :column="'month'">{{ trans('admin.contract-list-month.columns.month') }}</th>
                                        <th scope="col" is='sortable' :column="'pay_decode'">{{ trans('admin.contract-list-month.columns.pay_decode') }}</th>
                                        <th scope="col" is='sortable' :column="'pay_act'">{{ trans('admin.contract-list-month.columns.pay_act') }}</th>
                                        <th scope="col" is='sortable' :column="'upload_decode_file'">{{ trans('admin.contract-list-month.columns.upload_decode_file') }}</th>
                                        <th scope="col" is='sortable' :column="'download_akt_file'">{{ trans('admin.contract-list-month.columns.download_akt_file') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="#" class="bg-bulk-info d-table-cell text-center" colspan="7">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/contract-list-months/' + {{$contract_list_id}} + '/month')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a>
                                                <span class="text-primary">|</span>
                                                    <a href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>
                                            </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-success pr-3 pl-3" @click="bulkDeleteMonth('/admin/contract-list-months/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.download_more') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td data-label="#" class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>
                                        <td data-label="{{ trans('admin.contract-list-month.columns.id') }}">@{{ item.id }}</td>
                                        <td data-label="{{ trans('admin.contract-list-month.columns.month') }}">@{{ item.month }}</td>
                                        <td data-label="{{ trans('admin.contract-list-month.columns.pay_decode') }}">@{{ item.pay_decode }}</td>
                                        <td data-label="{{ trans('admin.contract-list-month.columns.pay_act') }}">@{{ item.pay_act }}</td>
                                        <td data-label="{{ trans('admin.contract-list-month.columns.upload_decode_file') }}">
                                            <div v-if="item.upload_decode_file" class="col-md-12">
                                                <a class="btn btn-sm btn-success" :href="item.upload_decode_file" title="{{ trans('brackets/admin-ui::admin.btn.download') }}" role="button"><i class="fa fa-cloud-download"></i></a>
                                            </div>
                                            <div class="col-md-12">
                                                <a class="btn btn-sm btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </td>
                                        <td data-label="{{ trans('admin.contract-list-month.columns.download_akt_file') }}" style="display: block;">
                                            <div class="col-md-12">
                                                @{{ item.download_akt_file }}
                                            </div>
                                            <div class="col-md-12">
                                                <a class="btn btn-sm btn-success" :href="item.resource_url + '/download'" title="{{ trans('brackets/admin-ui::admin.btn.download') }}" role="button"><i class="fa fa-download"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                           {{-- <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>--}}

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/admin-users/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.new') }} AdminUser</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </contract-list-month-listing>

@endsection
