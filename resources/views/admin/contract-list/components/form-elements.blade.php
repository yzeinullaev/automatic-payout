<div class="form-group row align-items-center" :class="{'has-danger': errors.has('branch_id'), 'has-success': fields.branch_id && fields.branch_id.valid }">
    <label for="branch_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.branch_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <multiselect
            v-model="branch_id"
            :options="branch_data"
            :close-on-select="true"
            placeholder="{{ trans('admin.contract-list.columns.branch_id') }}"
            label="text"
            track-by="id"
            @input="updateFormBranch"
            @input="validate($event)"
            v-validate="'required'"
            :class="{'form-control-danger': errors.has('branch_id'), 'form-control-success': fields.branch_id && fields.branch_id.valid}"
            id="branch_id"
            name="branch_id"
        >
        </multiselect>
        <div v-if="errors.has('branch_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('branch_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('contract_number'), 'has-success': fields.contract_number && fields.contract_number.valid }">
    <label for="contract_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.contract_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.contract_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('contract_number'), 'form-control-success': fields.contract_number && fields.contract_number.valid}" id="contract_number" name="contract_number" placeholder="{{ trans('admin.contract-list.columns.contract_number') }}">
        <div v-if="errors.has('contract_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('contract_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('start_contract_date'), 'has-success': fields.start_contract_date && fields.start_contract_date.valid }">
    <label for="start_contract_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.start_contract_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.start_contract_date" :config="datePickerConfigDate" v-validate="'required|date_format:yyyy-MM-dd'" class="flatpickr" :class="{'form-control-danger': errors.has('start_contract_date'), 'form-control-success': fields.start_contract_date && fields.start_contract_date.valid}" id="start_contract_date" name="start_contract_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('start_contract_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('start_contract_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('end_contract_date'), 'has-success': fields.end_contract_date && fields.end_contract_date.valid }">
    <label for="end_contract_date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.end_contract_date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.end_contract_date" :config="datePickerConfigDate" v-validate="'required|date_format:yyyy-MM-dd'" class="flatpickr" :class="{'form-control-danger': errors.has('end_contract_date'), 'form-control-success': fields.end_contract_date && fields.end_contract_date.valid}" id="end_contract_date" name="end_contract_date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('end_contract_date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('end_contract_date') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('partner_id'), 'has-success': fields.partner_id && fields.partner_id.valid }">
    <label for="partner_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.partner_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <multiselect
            v-model="partner_id"
            :options="partners_data"
            :close-on-select="true"
            placeholder="{{ trans('admin.contract-list.columns.partner_id') }}"
            label="text"
            track-by="id"
            @input="updateFormPartner"
            @input="validate($event)"
            v-validate="'required'"
            :class="{'form-control-danger': errors.has('partner_id'), 'form-control-success': fields.partner_id && fields.partner_id.valid}"
            id="partner_id"
            name="partner_id"
        >
        </multiselect>
        <div v-if="errors.has('partner_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('partner_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('partner_bin'), 'has-success': fields.partner_bin && fields.partner_bin.valid }">
    <label for="partner_bin" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.partner_bin') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.partner_bin" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('partner_bin'), 'form-control-success': fields.partner_bin && fields.partner_bin.valid}" id="partner_bin" name="partner_bin" placeholder="{{ trans('admin.contract-list.columns.partner_bin') }}" disabled>
        <div v-if="errors.has('partner_bin')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('partner_bin') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('agent_id'), 'has-success': fields.agent_id && fields.agent_id.valid }">
    <label for="agent_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.agent_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <multiselect
            v-model="agent_id"
            :options="agent_data"
            :close-on-select="true"
            placeholder="{{ trans('admin.contract-list.columns.agent_id') }}"
            label="text"
            track-by="id"
            @input="updateFormAgent"
            @input="validate($event)"
            v-validate="'required'"
            :class="{'form-control-danger': errors.has('agent_id'), 'form-control-success': fields.agent_id && fields.agent_id.valid}"
            id="agent_id"
            name="agent_id"
        >
        </multiselect>
        <div v-if="errors.has('agent_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('agent_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pay_status_id'), 'has-success': fields.pay_status_id && fields.pay_status_id.valid }">
    <label for="pay_status_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.pay_status_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <multiselect
            v-model="pay_status_id"
            :options="pay_status_data"
            :close-on-select="true"
            placeholder="{{ trans('admin.contract-list.columns.pay_status_id') }}"
            label="text"
            track-by="id"
            @input="updateFormPayStatus"
            @input="validate($event)"
            v-validate="'required'"
            :class="{'form-control-danger': errors.has('pay_status_id'), 'form-control-success': fields.pay_status_id && fields.pay_status_id.valid}"
            id="pay_status_id"
            name="pay_status_id"
        >
        </multiselect>
        <div v-if="errors.has('pay_status_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pay_status_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pay_type_id'), 'has-success': fields.pay_type_id && fields.pay_type_id.valid }">
    <label for="pay_type_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.pay_type_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <multiselect
            v-model="pay_type_id"
            :options="pay_type_data"
            :close-on-select="true"
            placeholder="{{ trans('admin.contract-list.columns.pay_type_id') }}"
            label="text"
            track-by="id"
            @input="updateFormPayType"
            @input="validate($event)"
            v-validate="'required'"
            :class="{'form-control-danger': errors.has('pay_type_id'), 'form-control-success': fields.pay_type_id && fields.pay_type_id.valid}"
            id="pay_type_id"
            name="pay_type_id"
        >
        </multiselect>
        <div v-if="errors.has('pay_type_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pay_type_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('agent_fee'), 'has-success': fields.agent_fee && fields.agent_fee.valid }">
    <label for="agent_fee" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list.columns.agent_fee') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.agent_fee" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('agent_fee'), 'form-control-success': fields.agent_fee && fields.agent_fee.valid}" id="agent_fee" name="agent_fee" placeholder="{{ trans('admin.contract-list.columns.agent_fee') }}">
        <div v-if="errors.has('agent_fee')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('agent_fee') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('enabled'), 'has-success': fields.enabled && fields.enabled.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="enabled" type="checkbox" v-model="form.enabled" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element">
        <label class="form-check-label" for="enabled">
            {{ trans('admin.contract-list.columns.enabled') }}
        </label>
        <input type="hidden" name="enabled" :value="form.enabled">
        <div v-if="errors.has('enabled')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('enabled') }}</div>
    </div>
</div>


