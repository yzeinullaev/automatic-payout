@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.contract-list.actions.create'))

@include('admin.contract-list.components.header-scripts')

@section('body')

    <div class="container-xl">

                <div class="card">

        <contract-list-form
            :action="'{{ url('admin/contract-lists') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.contract-list.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.contract-list.components.form-elements')
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </contract-list-form>

        </div>

        </div>


@endsection

@section('bottom-scripts')
    @include('admin.contract-list.components.bottom-scripts')
@endsection
