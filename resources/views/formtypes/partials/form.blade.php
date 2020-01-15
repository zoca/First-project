@push('head_links')
<link href="{{asset('/theme/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

@endpush

<!-- begin:form -->
<form id="examples-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Name') 
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-10">
            <input type="text" name="name" value="{{old('name', $entity->name)}}" class="form-control @errorClass('name', 'is-invalid')" placeholder="@lang('Enter a Title')" autofocus maxlength="100">
            @formError(['field' => 'name'])
            @endformError
        </div>
    </div>
    <div class="form-group text-right m-b-0">
        <button class="btn btn-primary waves-effect waves-light" type="submit">
            @lang('Submit')
        </button>
        <a href="@route('tags.list')" class="btn btn-secondary waves-effect m-l-5">
            @lang('Cancel')
        </a>
    </div>
</form>
<!-- end:form -->
@push('footer_scripts')
    <!-- begin:page script -->
    <script src="{{asset('/theme/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}"></script>
    <script src="{{asset('/theme/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{asset('/theme/plugins/select2/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        $("#examples-form :file").filestyle();
        $('#examples-form textarea, #examples-form :text').maxlength({
            threshold: 20,
            placement: 'right'
        });

        $("select.select2").select2({
        tags: false,
        tokenSeparators: [',', ' '],
        ajax: {
            url: "@route('categories.selection')",
            dataType: "json",
            type: "POST",
            delay: 500,
            data: function(params) {
                var queryParameters = {
                    term: params.term
                };
                return queryParameters;
            }
        }
    });

        // $("#examples-form").validate({
        //     rules: {
        //         name: {
        //             required: true,
        //             rangelength: [10, 100]
        //         },
        //         status: {
        //             required: false,
        //         },
        //         description: {
        //             required: true,
        //             rangelength: [10, 655]
        //         },
        //         photo: {
        //             required: false,
        //             extension: 'png|jpg|jpeg|gif'
        //         }
        //     }
        // });

    </script>
    <!-- begin:page script -->
@endpush