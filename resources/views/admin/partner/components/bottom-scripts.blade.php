<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
    $(".selectpicker").select2({
        ajax: {
            url: 'http://example-app/api/branches',
            dataType: 'json',
            delay: 250,
            placeholder: 'Search for a repository',
            minimumInputLength: 3,
        }
    });

    var branchesSelect = $('.selectpicker');
    $.ajax({
        type: 'GET',
        url: 'http://example-app/api/branches'
    }).then(function (data) {
        const value = data.results.map((items) => {
            if(items.selected === 1) {

                var option = new Option(items.text, items.id, true, true);
                branchesSelect.append(option).trigger('change');
                branchesSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data.results[0]
                    }
                });
            }
        })
    });

</script>
