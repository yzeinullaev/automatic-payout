<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
    $(".selectpicker").select2({
        ajax: {
            url: 'http://example-app/api/partners',
            dataType: 'json',
            delay: 250,
            placeholder: 'Search for a repository',
            minimumInputLength: 3,
        }
    });

    var partnersSelect = $('.selectpicker');
    $.ajax({
        type: 'GET',
        url: 'http://example-app/api/partners'
    }).then(function (data) {
        const value = data.results.map((items) => {
            if(items.selected === 1) {

                var option = new Option(items.text, items.id, true, true);
                partnersSelect.append(option).trigger('change');
                partnersSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data.results[0]
                    }
                });
            }
        })
    });

</script>
