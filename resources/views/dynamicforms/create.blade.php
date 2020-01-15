@extends('_layout.layout')

@section('head_title', __("Dynamic forms: Create"))

@section('content')
@include('_layout.partials.breadcrumbs', [
'pageTitle' => __('Dynamic forms: Create'),
'breadcrumbs' => [
url('/') => __('Home'),
route('dynamicforms.list') => __('Dynamic forms'),
]
])
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary card-header-icon">
                <div class="d-flex justify-content-end">
                    <h4 class="card-title"></h4>
                    <!-- begin:title-toolbar -->
                    <button type="reset" form="examples-form" class="btn btn-danger waves-effect m-l-5">
                        <i class="mdi mdi-autorenew"></i>
                        @lang('Reset')
                    </button>
                    <!-- end:title-toolbar  -->
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="row">
                            <label class="col-md-4 control-label">
                                @lang('Dynamic Forms')
                            </label>
                            <div class="col-md-8">
                                <!-- <select name="form_type" class="form_type selectpicker" data-style="btn-light">
                                    <option value="">-- Choose form --</option>
                                    <option value="form1">Form1</option>
                                    <option value="form2">Form2</option>
                                    <option value="form3">Form3</option>
                                    <option value="form4">Form4</option>
                                </select> -->
                                <div class="button-list">
                                    <button type="button" id="form_1" class="btn btn-block btn-sm" data-id="1" @if(!empty($errors) && old('form_id') == 1) style="border:1px solid red;" @endif>Form 1</button>
                                    <button type="button" id="form_2" class="btn btn-block btn-sm" data-id="2" @if(!empty($errors) && old('form_id') == 2) style="border:1px solid red;" @endif>Form 2</button>
                                    <button type="button" id="form_3" class="btn btn-block btn-sm" data-id="3" @if(!empty($errors) && old('form_id') == 3) style="border:1px solid red;" @endif>Form 3</button>
                                    <button type="button" id="form_4" class="btn btn-block btn-sm" data-id="4" @if(!empty($errors) && old('form_id') == 4) style="border:1px solid red;" @endif>Form 4</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        @include('dynamicforms.partials.form')
                    </div>
                </div>
            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
</div>
@endsection