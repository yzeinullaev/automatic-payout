<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agent.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.agent.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('initials'), 'has-success': fields.initials && fields.initials.valid }">
    <label for="initials" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agent.columns.initials') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.initials" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('initials'), 'form-control-success': fields.initials && fields.initials.valid}" id="initials" name="initials" placeholder="{{ trans('admin.agent.columns.initials') }}">
        <div v-if="errors.has('initials')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('initials') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('iin'), 'has-success': fields.iin && fields.iin.valid }">
    <label for="iin" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agent.columns.iin') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.iin" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('iin'), 'form-control-success': fields.iin && fields.iin.valid}" id="iin" name="iin" placeholder="{{ trans('admin.agent.columns.iin') }}">
        <div v-if="errors.has('iin')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('iin') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('address'), 'has-success': fields.address && fields.address.valid }">
    <label for="address" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agent.columns.address') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.address" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('address'), 'form-control-success': fields.address && fields.address.valid}" id="address" name="address" placeholder="{{ trans('admin.agent.columns.address') }}">
        <div v-if="errors.has('address')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('address') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('requisite'), 'has-success': fields.requisite && fields.requisite.valid }">
    <label for="requisite" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agent.columns.requisite') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.requisite" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('requisite'), 'form-control-success': fields.requisite && fields.requisite.valid}" id="requisite" name="requisite" placeholder="{{ trans('admin.agent.columns.requisite') }}">
        <div v-if="errors.has('requisite')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('requisite') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('partner_id'), 'has-success': fields.partner_id && fields.partner_id.valid }">
    <label for="partner_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agent.columns.partner_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <multiselect
            v-model="partner_id"
            :options="partner_data"
            :close-on-select="true"
            placeholder="{{ trans('admin.agent.columns.partner_id') }}"
            label="text"
            track-by="id"
            @input="updateFormPartner"
            @input="validate($event)"
            v-validate="'required'"
            :class="{'form-control-danger': errors.has('partner_id'), 'form-control-success': fields.partner_id && fields.partner_id.valid}"
            id="partner_id"
            name="partner_id"
        ></multiselect>
        <div v-if="errors.has('partner_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('partner_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('perex'), 'has-success': fields.perex && fields.perex.valid }">
    <label for="perex" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agent.columns.perex') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.perex" v-validate="''" id="perex" name="perex"></textarea>
        </div>
        <div v-if="errors.has('perex')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('perex') }}</div>
    </div>
</div>


<div class="form-check row" :class="{'has-danger': errors.has('enabled'), 'has-success': fields.enabled && fields.enabled.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="enabled" type="checkbox" v-model="form.enabled" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element">
        <label class="form-check-label" for="enabled">
            {{ trans('admin.agent.columns.enabled') }}
        </label>
        <input type="hidden" name="enabled" :value="form.enabled">
        <div v-if="errors.has('enabled')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('enabled') }}</div>
    </div>
</div>


