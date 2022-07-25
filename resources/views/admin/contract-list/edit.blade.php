@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.contract-list.actions.edit', ['name' => $contractList->id]))

@include('admin.contract-list.components.header-scripts')

@section('body')

    <div class="container-xl">
        <div class="card">

            <contract-list-form
                :action="'{{ $contractList->resource_url }}'"
                :data="{{ $contractList->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.contract-list.actions.edit', ['name' => $contractList->id]) }}
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
