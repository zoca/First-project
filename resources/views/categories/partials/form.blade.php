@push('head_links')

@endpush

<!-- begin:form -->
<form id="examples-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Category name')
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-10">
            <input type="text" name="name" value="{{old('name', $entity->name)}}" class="form-control @errorClass('name', 'is-invalid')" placeholder="@lang('Enter a Name')" autofocus maxlength="100">
            @formError(['field' => 'name'])
            @endformError
        </div>
    </div>
    <div class="form-group text-right m-b-0">
        <button class="btn btn-primary waves-effect waves-light" type="submit">
            @lang('Submit')
        </button>
        <a href="@route('posts.list')" class="btn btn-secondary waves-effect m-l-5">
            @lang('Cancel')
        </a>
    </div>
</form>
<!-- end:form -->
@push('footer_scripts')
<!-- begin:page script -->
<script src="{{asset('/theme/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}"></script>
<script src="{{asset('/theme/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script type="text/javascript">
    $("#examples-form :file").filestyle();
    $('#examples-form textarea, #examples-form :text').maxlength({
        threshold: 20,
        placement: 'right'
    });
    // $("#examples-form").validate({
    //     rules: {
    //         title: {
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