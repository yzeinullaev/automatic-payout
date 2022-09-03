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

                                    <div class="col form-group deadline-checkbox-col">
                                        <div class="switch-filter-wrap">
                                            <label class="switch switch-3d switch-primary">
                                                <input type="checkbox" class="switch-input" v-model="showBranchesFilter" >
                                                <span class="switch-slider"></span>
                                            </label>
                                            <span class="authors-filter">&nbsp;{{ __('Branches filter') }}</span>
                                        </div>
                                    </div>
                                    <div class="col form-group deadline-checkbox-col">
                                        <div class="switch-filter-wrap">
                                            <label class="switch switch-3d switch-primary">
                                                <input type="checkbox" class="switch-input" v-model="showPayStatusFilter" >
                                                <span class="switch-slider"></span>
                                            </label>
                                            <span class="authors-filter">&nbsp;{{ __('Pay status filter') }}</span>
                                        </div>
                                    </div>
                                    <div class="col form-group deadline-checkbox-col">
                                        <div class="switch-filter-wrap">
                                            <label class="switch switch-3d switch-primary">
                                                <input type="checkbox" class="switch-input" v-model="showPayTypesFilter" >
                                                <span class="switch-slider"></span>
                                            </label>
                                            <span class="authors-filter">&nbsp;{{ __('Pay types filter') }}</span>
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

                                <div class="row" v-if="showBranchesFilter">
                                    <div class="col-sm-auto form-group" style="margin-bottom: 0;">
                                        <p style="line-height: 40px; margin:0;">{{ __('Select branch/s') }}</p>
                                    </div>
                                    <div class="col col-lg-12 col-xl-12 form-group" style="max-width: 590px; ">
                                        <multiselect v-model="branchesMultiselect"
                                                     :options="{{ $branches->map(function($branch) { return ['key' => $branch->id, 'label' =>  $branch->name]; })->toJson() }}"
                                                     label="label"
                                                     track-by="key"
                                                     placeholder="{{ __('Type to search a branch/s') }}"
                                                     :limit="2"
                                                     :multiple="true">
                                        </multiselect>
                                    </div>
                                </div>

                                <div class="row" v-if="showPayStatusFilter">
                                    <div class="col-sm-auto form-group" style="margin-bottom: 0;">
                                        <p style="line-height: 40px; margin:0;">{{ __('Select pay status') }}</p>
                                    </div>
                                    <div class="col col-lg-12 col-xl-12 form-group" style="max-width: 590px; ">
                                        <multiselect v-model="payStatusMultiselect"
                                                     :options="{{ $payStatus->map(function($status) { return ['key' => $status->id, 'label' =>  $status->name]; })->toJson() }}"
                                                     label="label"
                                                     track-by="key"
                                                     placeholder="{{ __('Type to search a pay status') }}"
                                                     :limit="2"
                                                     :multiple="true">
                                        </multiselect>
                                    </div>
                                </div>

                                <div class="row" v-if="showPayTypesFilter">
                                    <div class="col-sm-auto form-group" style="margin-bottom: 0;">
                                        <p style="line-height: 40px; margin:0;">{{ __('Select pay type') }}</p>
                                    </div>
                                    <div class="col col-lg-12 col-xl-12 form-group" style="max-width: 590px; ">
                                        <multiselect v-model="payTypesMultiselect"
                                                     :options="{{ $payTypes->map(function($type) { return ['key' => $type->id, 'label' =>  $type->name]; })->toJson() }}"
                                                     label="label"
                                                     track-by="key"
                                                     placeholder="{{ __('Type to search a pay type') }}"
                                                     :limit="2"
                                                     :multiple="true">
                                        </multiselect>
                                    </div>
                                </div>
                            </form>

                            <table class="r_table table table-hover table-listing">
                                <thead>
                                    <tr>
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
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                    <td data-label="{{ trans('admin.contract-list.columns.id') }}">@{{ item.id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.branch_id') }}">@{{ item.branch_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.contract_number') }}">@{{ item.contract_number }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.start_contract_date') }}">@{{ item.start_contract_date | date }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.end_contract_date') }}">@{{ item.end_contract_date | date }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.partner_id') }}">@{{ truncData(item.partner_id)}}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.partner_bin') }}">@{{ item.partner_bin }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.agent_id') }}">@{{ item.agent_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.pay_status_id') }}">@{{ item.pay_status_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.pay_type_id') }}">@{{ item.pay_type_id }}</td>
                                        <td data-label="{{ trans('admin.contract-list.columns.agent_fee') }}">@{{ item.agent_fee }}</td>
                                        <!--@{{ item.partner_id }}-->

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
