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
            <input type="text" name="name" value="{{old('name', $entity->name)}}" class="form-control @errorClass('name', 'is-invalid')" placeholder="@lang('Enter a Name')" autofocus maxlength="100">
            @formError(['field' => 'name'])
            @endformError
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Price')
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-10">
            <input type="text" name="price" value="{{old('price', $entity->price)}}" class="form-control @errorClass('name', 'is-invalid')" placeholder="@lang('Enter a Price')" autofocus maxlength="100">
            @formError(['field' => 'price'])
            @endformError
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('SKU')
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-10">
            <input type="text" name="sku" value="{{old('sku', $entity->sku)}}" class="form-control @errorClass('sku', 'is-invalid')" placeholder="@lang('Enter a SKU')" autofocus maxlength="100">
            @formError(['field' => 'sku'])
            @endformError
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Product Category')
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-10">
            <select name="primary_category_id" class="selectpicker form-control @errorClass('primary_category_id', 'is-invalid')" data-style="btn-light">
                <option value="">-- Choose primary category --</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}" @if(old('primary_category_id', $entity->primary_category_id) == $category->id) selected @endif>@lang($category->name)</option>
                @endforeach
            </select>
            @formError(['field' => 'primary_category_id'])
            @endformError
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Other categories')
        </label>
        <div class="col-md-10">
            <select name="other_categories[]" class="custom-select select2" multiple>
                @foreach($entity->otherCategories as $category)
                <option value="{{ $category->id }}" selected>@lang($category->name)</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 control-label">
            @lang('Description')
        </label>
        <div class="col-md-10">
            <textarea id="description-field" name="description" placeholder="@lang('Enter a description')" class="form-control @errorClass('description', 'is-invalid')" rows="8" maxlength="655">{{old('description', $entity->description)}}</textarea>
            @formError(['field' => 'description'])
            @endformError
        </div>
    </div>
    <div class="form-group text-right m-b-0">
        <button class="btn btn-primary waves-effect waves-light" type="submit">
            @lang('Submit')
        </button>
        <a href="@route('products.list')" class="btn btn-secondary waves-effect m-l-5">
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
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script> -->
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
    //         title: {
    //             required: true,
    //             rangelength: [10, 100]
    //         },
    //         category: {
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

    // ClassicEditor
    //     .create(document.querySelector('#description-field'))
    //     .catch(error => {
    //         console.error(error);
    //     });
</script>
<!-- begin:page script -->
@endpush