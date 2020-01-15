@push('head_links')
<link href="{{asset('/theme/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

<!-- begin:form -->
<form id="examples-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Title')
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-10">
            <input type="text" name="title" value="{{old('title', $entity->title)}}" class="form-control @errorClass('title', 'is-invalid')" placeholder="@lang('Enter a Title')" autofocus maxlength="100">
            @formError(['field' => 'title'])
            @endformError
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Status')
        </label>
        <div class="col-md-10">
            <select name="status" class="selectpicker" data-style="btn-light">entity->otherCategorie
                @foreach ($statuses as $status)
                <option value="{{$status}}" @if(old('status', $entity->status) == $status) selected @endif>@lang($status)</option>
                @endforeach
            </select>
            <input hidden class="form-group @errorClass('status', 'is-invalid')">
            @formError(['field' => 'status'])
            @endformError
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Description')
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-10">
            <textarea name="description" placeholder="@lang('Enter a description')" class="form-control" rows="5" maxlength="655">{{old('description', $entity->description)}}</textarea>
            <input hidden class="form-group @errorClass('description', 'is-invalid')">
            @formError(['field' => 'description'])
            @endformError
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Tags')
        </label>
        <div class="col-md-10">
            <select name="tags[]" class="custom-select select2" multiple>
                @foreach($entity->tags as $tag)
                <option value="{{ $tag->id }}" selected>@lang($tag->name)</option>
                @endforeach
            </select>
        </div>
    </div>
    @if($entity->exists)
    @if($entity->comments->count() > 0)
    @foreach($entity->comments as $comment)
    <div class="form-group row align-items-center">
        <label class="col-md-2 control-label">
            @lang('Comment')
            <span class="text-danger"></span>
        </label>
        <div class="col-md-7">
            <textarea name="comments[{{ $comment->id }}]" placeholder="@lang('Enter a comment')" class="form-control" rows="5" maxlength="655">{{ old('comments.'. $comment->id, $comment->text)}}</textarea>
            <input hidden class="form-group @errorClass('comments.'. $comment->id, 'is-invalid')">
            @formError(['field' => 'comments.'. $comment->id])
            @endformError
        </div>
        <div class="col-md-3">
            <button data-comment-id="{{ $comment->id }}" class="delete-comment btn btn-icon waves-effect btn-danger delete">Delete comment</button>
        </div>
    </div>
    @endforeach
    @endif
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('New Comment')
            <span class="text-danger"></span>
        </label>
        <div class="col-md-10">
            <textarea name="comments[0]" placeholder="@lang('Enter a comment')" class="form-control" rows="5" maxlength="655">{{ old('comments.0')}}</textarea>
            <input hidden class="form-group @errorClass('comments.0', 'is-invalid')">
            @formError(['field' => 'comments.0'])
            @endformError
        </div>
    </div>
    @endif
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
                url: "@route('tags.selection')",
                dataType: "json",
                type: "POST",
                delay: 500,
                data: function (params) {
                    var queryParameters = {
                        term: params.term
                    };
                    return queryParameters;
                }
            }
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

    $('#example-photo').on('click', '.delete-photo', function() {
        Swal.fire({
            title: "@lang('Are you sure you want to delete this photo?')",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "@lang('Yes')",
            cancelButtonText: "@lang('No, cancel')"
        }).then(function(result) {
            if (result.value) {
                // if user decides to proceed
                $.ajax({
                    url: '/entities/{{$entity->id}}/delete-photo',
                    method: 'POST',
                    success: function(response) {
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
        }).then(function(result) {
            if (result.value) {
                // if user decides to proceed
                $.ajax({
                    url: `/posts/${entity}/comment/${comment}/deleteComment`,
                    method: 'POST'
                }).done(function(response) {
                    target.parent().parent().remove();
                });
            }
        });
    });
</script>
<!-- begin:page script -->
@endpush