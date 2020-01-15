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
    <script type="text/javascript">
        $("#examples-form :file").filestyle();
        $('#examples-form textarea, #examples-form :text').maxlength({
            threshold: 20,
            placement: 'right'
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

        $('#example-photo').on('click', '.delete-photo', function() {
            Swal.fire({
                title: "@lang('Are you sure you want to delete this photo?')",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "@lang('Yes')",
                cancelButtonText: "@lang('No, cancel')"
            }).then(function(result){
                if (result.value) {
                    // if user decides to proceed
                    $.ajax({
                        url: '/entities/{{$entity->id}}/delete-photo',
                        method: 'POST',
                        success: function(response){
                            showSystemMessage(response.message);

                            $('#example-photo').remove();
                        },
                    });
                }
            });
        });

           // Delete comment
           $(".delete-comment").on('click', function(e) {
               e.preventDefault();
            // fetch needed data from row
            let entity = '{{$entity->id}}';
            let comment = $(this).data('commentId');
            let target = $(this);
            //alert(entity);
            // show swal to make sure this is an intentional action
            Swal.fire({
                title: "@lang('Are you sure you want to delete comment?')",
                text: "@lang('some or all data may be lost')",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "@lang('Yes')",
                cancelButtonText: "@lang('No, cancel')"
            }).then(function(result){
                if (result.value) {
                    // if user decides to proceed
                    $.ajax({
                        url: `/tags/${entity}/comment/${comment}/deleteComment`,
                        method: 'POST'
                    }).done(function(response){
                        target.parent().parent().remove();
                    });
                }
            });
        });
    </script>
    <!-- begin:page script -->
@endpush