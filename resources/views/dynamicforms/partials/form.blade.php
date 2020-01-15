@push('head_links')

<link rel="stylesheet" href="{{asset('/theme/plugins/switchery/switchery.min.css')}}">
@endpush
@if(!empty($errors))
@endif
{{-- begin:form --}}
<form id="dynamic-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="form_id" class="form-id" value="">
    <div class="form-group row form1 form3 form4 d-none">
        <label class="col-md-2 control-label">
            @lang('Title')
        </label>
        <div class="col-md-10">
            <input type="text" name="title" value="{{old('title', $entity->title)}}" class="form-control @errorClass('title', 'is-invalid')" placeholder="@lang('Enter a title')">
            @formError(['field' => 'title'])
            @endformError
        </div>
    </div>
    <div class="form-group row form4 d-none">
        <label class="col-md-2 control-label">
            @lang('Seo Title')
        </label>
        <div class="col-md-10">
            <input type="text" name="seo_title" value="{{old('seo_title', $entity->seo_title)}}" class="form-control @errorClass('seo_title', 'is-invalid')" placeholder="@lang('Enter a seo title')">
            @formError(['field' => 'seo_title'])
            @endformError
        </div>
    </div>
    <div class="form-group row form1 form4 d-none">
        <label class="col-md-2 control-label">
            @lang('Description')
        </label>
        <div class="col-md-10">
            <textarea name="description" placeholder="@lang('Enter a description')" class="form-control @errorClass('description', 'is-invalid')" rows="5">{{old('description', $entity->description)}}</textarea>
            @formError(['field' => 'description'])
            @endformError
        </div>
    </div>
    <div class="form-group row form4 d-none">
        <label class="col-md-2 control-label">
            @lang('Seo Description')
        </label>
        <div class="col-md-10">
            <textarea name="seo_description" placeholder="@lang('Enter a seo description')" class="form-control @errorClass('seo_description', 'is-invalid')" rows="5">{{old('seo_description', $entity->seo_description)}}</textarea>
            @formError(['field' => 'seo_description'])
            @endformError
        </div>
    </div>
    <div class="form-group row form2 d-none">
        <label class="col-md-2 control-label">
            @lang('Equipment')
        </label>
        <div class="col-md-10">
            @for($i = 1; $i < 4; $i++) 
            <div class="checkbox checkbox-info m-t-0">
                <label>
                    <input type="checkbox" name="equipments[]" class="form-control @errorClass('equipments', 'is-invalid')" value="{{ $i }}" @if(in_array($i, old('equipments', explode(',', $entity->equipments)))) checked @endif>
                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                {{ ($i==1) ? "aircondition" : (($i==2) ?  "childe lock" : "power steering") }}
                </label>
            </div>
            @endfor
            @formError(['field' => 'equipments'])
            @endformError
        </div>
    </div>
    <div class="form-group row form2 d-none">
        <label class="col-md-2 control-label">
            @lang('Car condition')
        </label>
        <div class="col-md-10">
             @for($i = 1; $i < 4; $i++) 
            <div class="radio radio-info m-t-0">
                <label>
                    <input type="radio" name="car_condition" class="form-control @errorClass('car_condition', 'is-invalid')" value="{{ ($i==1) ? 'new' : (($i==2) ?  'used' : 'broken') }}" @if(old('car_condition', $entity->car_condition) == ($i==1) ? "new" : (($i==2) ?  "used" : "broken")) checked @endif>
                    <span class="cr"><i class="cr-icon mdi mdi-checkbox-blank-circle"></i></span>
                    {{ ($i==1) ? "new" : (($i==2) ?  "used" : "broken") }}
                </label>
            </div>
            @endfor
            @formError(['field' => 'car_condition'])
            @endformError
        </div>
    </div>
    <div class="form-group row form3 d-none" data-name="title">
        <label class="col-md-2 control-label">
            @lang('Fuel')
        </label>
        <div class="col-md-10">
            <select class="form-control @errorClass('fuel', 'is-invalid')" name="fuel">
                <option value="" @if(old('fuel', $entity->fuel) == '') selected @endif>Select fuel</option>
                <option value="gasoline" @if(old('fuel', $entity->fuel) == 'gasoline') selected @endif>Gasoline</option>
                <option value="diesel" @if(old('fuel', $entity->fuel) == 'diesel') selected @endif>Diesel</option>
                <option value="gas" @if(old('fuel', $entity->fuel) == 'gas') selected @endif>Gas</option>
            </select>
            @formError(['field' => 'fuel'])
            @endformError
        </div>
    </div>

    <div class="form-group row form3 d-none">
        <label class="col-md-2 control-label">
            @lang('Image')
        </label>
        <div class="col-md-10">
            <input type="file" class="form-control @errorClass('image', 'is-invalid') default" name="image" />
            @formError(['field' => 'image'])
            @endformError
        </div>
    </div>
    <div class="form-group text-right form-n m-b-0 d-none">
        <button class="btn btn-primary waves-effect waves-light m-r-10" type="submit">
            @lang('Submit')
        </button>
    </div>
</form>
<!-- end:form -->
@push('footer_scripts')
<!-- begin:page script -->
<script src="{{asset('/theme/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}"></script>
<script src="{{asset('/theme/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{asset('/theme/plugins/switchery/switchery.min.js')}}"></script>
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script> -->
<script type="text/javascript">
    $("#examples-form :file").filestyle();
    $('#examples-form textarea, #examples-form :text').maxlength({
        threshold: 20,
        placement: 'right'
    });

    $('#form_1').on('click', function() {
        let formId = $(this).data('id');
        $(".form-id").val(formId);
        $(this).toggleClass('btn-info');
        $('.form-n').removeClass('d-none');

        $('#form_2').removeClass('btn-info');
        $('.form2').addClass('d-none');
        $('.form2').find('input').attr('disabled', 'disabled');

        $('#form_3').removeClass('btn-info');
        $('.form3').addClass('d-none');
        $('.form3').find('input').attr('disabled', 'disabled');
        $('.form3').find('select').attr('disabled', 'disabled');

        $('#form_4').removeClass('btn-info');
        $('.form4').addClass('d-none');
        $('.form4').find('input').attr('disabled', 'disabled');
        $('.form4').find('textarea').attr('disabled', 'disabled');

        $('.form1').toggleClass('d-none');
        $('.form1').find('input').removeAttr('disabled', 'disabled');
        $('.form1').find('textarea').removeAttr('disabled', 'disabled');

        if ((!$('#form_1').hasClass('btn-info')) && (!$('#form_2').hasClass('btn-info')) && (!$('#form_3').hasClass('btn-info')) && (!$('#form_4').hasClass('btn-info'))) {
            $('.form-n').addClass('d-none');
        }
    });

    $('#form_2').on('click', function() {
        let formId = $(this).data('id');
        $(".form-id").val(formId);
        $(this).toggleClass('btn-info');
        $('.form-n').removeClass('d-none');

        $('#form_1').removeClass('btn-info');
        $('.form1').addClass('d-none');
        $('.form1').find('input').attr('disabled', 'disabled');
        $('.form1').find('textarea').attr('disabled', 'disabled');

        $('#form_3').removeClass('btn-info');
        $('.form3').addClass('d-none');
        $('.form3').find('input').attr('disabled', 'disabled');
        $('.form3').find('select').attr('disabled', 'disabled');

        $('#form_4').removeClass('btn-info');
        $('.form4').addClass('d-none');
        $('.form4').find('input').attr('disabled', 'disabled');
        $('.form4').find('textarea').attr('disabled', 'disabled');

        $('.form2').toggleClass('d-none');
        $('.form2').find('input').removeAttr('disabled', 'disabled');

        if ((!$('#form_1').hasClass('btn-info')) && (!$('#form_2').hasClass('btn-info')) && (!$('#form_3').hasClass('btn-info')) && (!$('#form_4').hasClass('btn-info'))) {
            $('.form-n').addClass('d-none');
        }
    });

    $('#form_3').on('click', function() {
        let formId = $(this).data('id');
        $(".form-id").val(formId);
        $(this).toggleClass('btn-info');
        $('.form-n').removeClass('d-none');

        $('#form_1').removeClass('btn-info');
        $('.form1').addClass('d-none');
        $('.form1').find('input').attr('disabled', 'disabled');
        $('.form1').find('textarea').attr('disabled', 'disabled');

        $('#form_2').removeClass('btn-info');
        $('.form2').addClass('d-none');
        $('.form2').find('input').attr('disabled', 'disabled');

        $('#form_4').removeClass('btn-info');
        $('.form4').addClass('d-none');
        $('.form4').find('input').attr('disabled', 'disabled');
        $('.form4').find('textarea').attr('disabled', 'disabled');

        $('.form3').toggleClass('d-none');
        $('.form3').find('input').removeAttr('disabled', 'disabled');
        $('.form3').find('select').removeAttr('disabled', 'disabled');

        if ((!$('#form_1').hasClass('btn-info')) && (!$('#form_2').hasClass('btn-info')) && (!$('#form_3').hasClass('btn-info')) && (!$('#form_4').hasClass('btn-info'))) {
            $('.form-n').addClass('d-none');
        }
    });

    $('#form_4').on('click', function() {
        let formId = $(this).data('id');
        $(".form-id").val(formId);
        $(this).toggleClass('btn-info');
        $('.form-n').removeClass('d-none');
        if ($('.form-group').hasClass('form1') && $('.form-group').hasClass('form4')) {
            $('.form1').toggleClass('d-none');
        }
        $('#form_1').removeClass('btn-info');
        $('.form1').addClass('d-none');
        $('.form1').find('input').attr('disabled', 'disabled');
        $('.form1').find('textarea').attr('disabled', 'disabled');

        $('#form_2').removeClass('btn-info');
        $('.form2').addClass('d-none');
        $('.form2').find('input').attr('disabled', 'disabled');

        $('#form_3').removeClass('btn-info');
        $('.form3').addClass('d-none');
        $('.form3').find('input').attr('disabled', 'disabled');
        $('.form3').find('select').attr('disabled', 'disabled');


        $('.form4').toggleClass('d-none');
        $('.form4').find('input').removeAttr('disabled', 'disabled');
        $('.form4').find('textarea').removeAttr('disabled', 'disabled');

        if ((!$('#form_1').hasClass('btn-info')) && (!$('#form_2').hasClass('btn-info')) && (!$('#form_3').hasClass('btn-info')) && (!$('#form_4').hasClass('btn-info'))) {
            $('.form-n').addClass('d-none');
        }

    });
</script>
<!-- begin:page script -->
@endpush