<div class="form-group row align-items-center" :class="{'has-danger': errors.has('contract_list_id'), 'has-success': fields.contract_list_id && fields.contract_list_id.valid }">
    <label for="contract_list_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list-month.columns.contract_list_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.contract_list_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('contract_list_id'), 'form-control-success': fields.contract_list_id && fields.contract_list_id.valid}" id="contract_list_id" name="contract_list_id" placeholder="{{ trans('admin.contract-list-month.columns.contract_list_id') }}" disabled>
        <div v-if="errors.has('contract_list_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('contract_list_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('month'), 'has-success': fields.month && fields.month.valid }">
    <label for="month" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list-month.columns.month') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.month" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('month'), 'form-control-success': fields.month && fields.month.valid}" id="month" name="month" placeholder="{{ trans('admin.contract-list-month.columns.month') }}" disabled>
        <div v-if="errors.has('month')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('month') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pay_decode'), 'has-success': fields.pay_decode && fields.pay_decode.valid }">
    <label for="pay_decode" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list-month.columns.pay_decode') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input
            type="number"
            v-model="pay_decode"
            v-validate="'decimal'"
            @input="updatePayAct"
            @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('pay_decode'), 'form-control-success': fields.pay_decode && fields.pay_decode.valid}"
            id="pay_decode"
            name="pay_decode"
            placeholder="{{ trans('admin.contract-list-month.columns.pay_decode') }}">
        <div v-if="errors.has('pay_decode')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pay_decode') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('pay_act'), 'has-success': fields.pay_act && fields.pay_act.valid }">
    <label for="pay_act" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.contract-list-month.columns.pay_act') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.pay_act" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('pay_act'), 'form-control-success': fields.pay_act && fields.pay_act.valid}" id="pay_act" name="pay_act" placeholder="{{ trans('admin.contract-list-month.columns.pay_act') }}" disabled>
        <div v-if="errors.has('pay_act')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('pay_act') }}</div>
    </div>
</div>


