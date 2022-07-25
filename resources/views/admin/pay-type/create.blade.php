@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.pay-type.actions.create'))

@section('body')

    <div class="container-xl">


        <pay-type-form
            :action="'{{ url('admin/pay-types') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus"></i> {{ trans('admin.pay-type.actions.create') }}
                            </div>
                            <div class="card-body">
                                @include('admin.pay-type.components.form-elements')
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

        </pay-type-form>

        </div>


@endsection
