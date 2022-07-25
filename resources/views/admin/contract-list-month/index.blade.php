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
                            <table class="r_table table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th scope="col" is='sortable' :column="'id'">{{ trans('admin.contract-list-month.columns.id') }}</th>
                                        <th scope="col" is='sortable' :column="'month'">{{ trans('admin.contract-list-month.columns.month') }}</th>
                                        <th scope="col" is='sortable' :column="'pay_decode'">{{ trans('admin.contract-list-month.columns.pay_decode') }}</th>
                                        <th scope="col" is='sortable' :column="'pay_act'">{{ trans('admin.contract-list-month.columns.pay_act') }}</th>
                                        <th scope="col" is='sortable' :column="'upload_decode_file'">{{ trans('admin.contract-list-month.columns.upload_decode_file') }}</th>
                                        <th scope="col" is='sortable' :column="'download_akt_file'">{{ trans('admin.contract-list-month.columns.download_akt_file') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">

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

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </contract-list-month-listing>

@endsection
