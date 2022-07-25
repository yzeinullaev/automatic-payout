@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.contract-list-month.actions.edit', ['name' => $contractListMonth->id]))

@section('body')

    <div class="container-xl">

            <contract-list-month-form
                :action="'{{ $contractListMonth->resource_url }}'"
                :data="{{ $contractListMonth->toJson() }}"
                :contract="{{ $contractList->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-pencil"></i> {{ trans('admin.contract-list-month.actions.edit', ['name' => $contractListMonth->id]) }}
                                </div>

                                <div class="card-body">
                                    @include('admin.contract-list-month.components.form-elements')
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-xl-5 col-xxl-4">
                            @include('brackets/admin-ui::admin.includes.media-uploader', [
                                'mediaCollection' => app(App\Models\ContractListMonth::class)->getMediaCollection('decode_file'),
                                'media' => $contractListMonth->getThumbs200ForCollection('decode_file'),
                                'label' => 'Decode file'
                            ])
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

        </contract-list-month-form>


</div>

@endsection
