<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
    $(".selectpickerBranch").select2({
        ajax: {
            url: 'http://example-app/api/branches',
            dataType: 'json',
            delay: 250,
            placeholder: 'Search for a repository',
            minimumInputLength: 3,
        }
    });

    var branchesSelect = $('.selectpickerBranch');
    $.ajax({
        type: 'GET',
        url: 'http://example-app/api/branches'
    }).then(function (data) {
        const value = data.results.map((items) => {
            if(items.contract_selected === 1) {

                var option = new Option(items.text, items.id, true, true);
                branchesSelect.append(option).trigger('change');
                branchesSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: items
                    }
                });
            }
        })
    });

    $(".selectpickerPartner").select2({
        ajax: {
            url: 'http://example-app/api/partners',
            dataType: 'json',
            delay: 250,
            placeholder: 'Search for a repository',
            minimumInputLength: 3,
        }
    });

    var partnersSelect = $('.selectpickerPartner');
    $.ajax({
        type: 'GET',
        url: 'http://example-app/api/partners'
    }).then(function (data) {
        const value = data.results.map((items) => {
            if(items.contract_selected === 1) {

                var option = new Option(items.text, items.id, true, true);
                partnersSelect.append(option).trigger('change');
                partnersSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: items
                    }
                });
            }
        })
    });

    $(".selectpickerAgent").select2({
        ajax: {
            url: 'http://example-app/api/agents',
            dataType: 'json',
            delay: 250,
            placeholder: 'Search for a repository',
            minimumInputLength: 3,
        }
    });

    var agentsSelect = $('.selectpickerAgent');
    $.ajax({
        type: 'GET',
        url: 'http://example-app/api/agents'
    }).then(function (data) {
        const value = data.results.map((items) => {
            if(items.contract_selected === 1) {

                var option = new Option(items.text, items.id, true, true);
                agentsSelect.append(option).trigger('change');
                agentsSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: items
                    }
                });
            }
        })
    });


    $(".selectpickerPayStatus").select2({
        ajax: {
            url: 'http://example-app/api/pay-statuses',
            dataType: 'json',
            delay: 250,
            placeholder: 'Search for a repository',
            minimumInputLength: 3,
        }
    });

    var payStatusSelect = $('.selectpickerPayStatus');
    $.ajax({
        type: 'GET',
        url: 'http://example-app/api/pay-statuses'
    }).then(function (data) {
        const value = data.results.map((items) => {
            if(items.contract_selected === 1) {

                var option = new Option(items.text, items.id, true, true);
                payStatusSelect.append(option).trigger('change');
                payStatusSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: items
                    }
                });
            }
        })
    });


    $(".selectpickerPayType").select2({
        ajax: {
            url: 'http://example-app/api/pay-types',
            dataType: 'json',
            delay: 250,
            placeholder: 'Search for a repository',
            minimumInputLength: 3,
        }
    });

    var payTypeSelect = $('.selectpickerPayType');
    $.ajax({
        type: 'GET',
        url: 'http://example-app/api/pay-types'
    }).then(function (data) {
        const value = data.results.map((items) => {
            if(items.contract_selected === 1) {

                var option = new Option(items.text, items.id, true, true);
                payTypeSelect.append(option).trigger('change');
                payTypeSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: items
                    }
                });
            }
        })
    });

</script>
