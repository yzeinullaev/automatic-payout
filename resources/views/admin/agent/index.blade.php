@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.agent.actions.index'))

@include('admin.contract-list.components.header-scripts')

@section('body')

    <agent-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/agents') }}'"
        :trans="{{ json_encode(trans('brackets/admin-ui::admin.dialogs')) }}"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.agent.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/agents/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.agent.actions.create') }}</a>
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
                                        <th scope="col" is='sortable' :column="'id'">{{ trans('admin.agent.columns.id') }}</th>
                                        <th scope="col" is='sortable' :column="'name'">{{ trans('admin.agent.columns.name') }}</th>
                                        <th scope="col" is='sortable' :column="'initials'">{{ trans('admin.agent.columns.initials') }}</th>
                                        <th scope="col" is='sortable' :column="'iin'">{{ trans('admin.agent.columns.iin') }}</th>
                                        <th scope="col" is='sortable' :column="'requisite'">{{ trans('admin.agent.columns.requisite') }}</th>
                                        <th scope="col" is='sortable' :column="'address'">{{ trans('admin.agent.columns.address') }}</th>
                                        <th scope="col" is='sortable' :column="'enabled'">{{ trans('admin.agent.columns.enabled') }}</th>
                                        <th></th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                        <td data-label="{{ trans('admin.agent.columns.id') }}">@{{ item.id }}</td>
                                        <td data-label="{{ trans('admin.agent.columns.name') }}">@{{ item.name }}</td>
                                        <td data-label="{{ trans('admin.agent.columns.initials') }}">@{{ item.initials }}</td>
                                        <td data-label="{{ trans('admin.agent.columns.iin') }}">@{{ item.iin }}</td>
                                        <td data-label="{{ trans('admin.agent.columns.requisite') }}">@{{ item.requisite }}</td>
                                        <td data-label="{{ trans('admin.agent.columns.address') }}">@{{ item.address }}</td>

                                        <td data-label="{{ trans('admin.agent.columns.enabled') }}">
                                            <label class="switch switch-3d switch-success">
                                                <input type="checkbox" class="switch-input" v-model="collection[index].enabled" @change="toggleSwitchAgent(item.resource_url, 'enabled', collection[index])">
                                                <span class="switch-slider"></span>
                                            </label>
                                        </td>


                                        <td>
                                            <div class="row no-gutters">
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
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/agents/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.agent.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </agent-listing>

@endsection
