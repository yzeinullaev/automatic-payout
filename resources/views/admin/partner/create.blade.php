@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.partner.actions.create'))

@include('admin.partner.components.header-scripts')

@section('body')

    <div class="container-xl">


        <partner-form
            :action="'{{ url('admin/partners') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus"></i> {{ trans('admin.partner.actions.create') }}
                            </div>
                            <div class="card-body">
                                @include('admin.partner.components.form-elements')
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary fixed-cta-button button-save" :disabled="submiting">
                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-save'"></i>
                    {{ trans('brackets/admin-ui::admin.btn.save') }}
                </button>
                <button type="submit" style="display: none" class="btn btn-success fixed-cta-button button-saved" :disabled="submiting" :class="">
                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-check'"></i>
                    <span>{{ trans('brackets/admin-ui::admin.btn.saved') }}</span>
                </button>

            </form>

        </partner-form>

        </div>


@endsection

@section('bottom-scripts')
    @include('admin.partner.components.bottom-scripts')
@endsection
