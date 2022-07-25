@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.contract-list.actions.index'))

@include('admin.contract-list.components.header-scripts')

@section('body')

    <contract-list-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/contract-lists') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.contract-list.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/contract-lists/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.contract-list.actions.create') }}</a>
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
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
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

                                        <th scope="col" is='sortable' :column="'id'">{{ trans('admin.contract-list.columns.id') }}</th>
                                        <th scope="col" is='sortable' :column="'branch_id'">{{ trans('admin.contract-list.columns.branch_id') }}</th>
                                        <th scope="col" is='sortable' :column="'contract_number'">{{ trans('admin.contract-list.columns.contract_number') }}</th>
                                        <th scope="col" is='sortable' :column="'start_contract_date'">{{ trans('admin.contract-list.columns.start_contract_date') }}</th>
                                        <th scope="col" is='sortable' :column="'end_contract_date'">{{ trans('admin.contract-list.columns.end_contract_date') }}</th>
                                        <th scope="col" is='sortable' :column="'partner_id'">{{ trans('admin.contract-list.columns.partner_id') }}</th>
                                        <th scope="col" is='sortable' :column="'partner_bin'">{{ trans('admin.contract-list.columns.partner_bin') }}</th>
                                        <th scope="col" is='sortable' :column="'agent_id'">{{ trans('admin.contract-list.columns.agent_id') }}</th>
                                        <th scope="col" is='sortable' :column="'pay_status_id'">{{ trans('admin.contract-list.columns.pay_status_id') }}</th>
                                        <th scope="col" is='sortable' :column="'pay_type_id'">{{ trans('admin.contract-list.columns.pay_type_id') }}</th>
                                        <th scope="col" is='sortable' :column="'agent_fee'">{{ trans('admin.contract-list.columns.agent_fee') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="14">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/contract-lists')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/contract-lists/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                    <td data-label="{{ trans('admin.contract-list.columns.id') }}">@{{ item.id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.branch_id') }}">@{{ item.branch_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.contract_number') }}">@{{ item.contract_number }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.start_contract_date') }}">@{{ item.start_contract_date | date }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.end_contract_date') }}">@{{ item.end_contract_date | date }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.partner_id') }}">@{{ item.partner_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.partner_bin') }}">@{{ item.partner_bin }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.agent_id') }}">@{{ item.agent_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.pay_status_id') }}">@{{ item.pay_status_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.pay_type_id') }}">@{{ item.pay_type_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.agent_fee') }}">@{{ item.agent_fee }}</td>


                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-md-12">
                                                    <a class="btn btn-sm btn-spinner btn-success" :href="'{{ url('admin/contract-list-months') }}/' + item.id + '/month'" title="{{ trans('brackets/admin-ui::admin.btn.month') }}" role="button"><i class="fa fa-calendar"></i></a>
                                                </div>
                                                <div class="col-md-12">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <div class="col-md-12">
                                                    <form @submit.prevent="deleteItem(item.resource_url)">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/contract-lists/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.contract-list.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </contract-list-listing>

@endsection
