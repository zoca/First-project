@extends('_layout.layout')

@section('head_title', __("Product Categories"))

@push('head_links')
<!-- Nestable css -->
<link href="{{asset('/theme/plugins/nestable/jquery.nestable.css')}}" rel="stylesheet" type="text/css" />
<style>
    .button-list {
        margin-top: -35px;
        margin-left: 75%;
    }

    .btn-active {
        height: 26px;
        width: 26px;
    }

    .mdi {
        position: absolute;
        bottom: 5px;
        right: 5px;
    }
</style>
@endpush

@section('content')
@include('_layout.partials.breadcrumbs', [
'pageTitle' => __("Product Categories"),
'breadcrumbs' => [
url('/') => __('Home')
]
])
<div class="row">
<div class="col-sm-10 m-auto">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 m-auto">
                    <div class="custom-dd-empty dd" id="category_nestable">
                        @nestable(['entities' => $entities])
                        @endnestable
                    </div>
                </div><!-- end col -->

            </div> <!-- end row -->
        </div>
    </div>
</div> <!-- end col -->
</div>
@endsection

@push('footer_scripts')
<!-- begin:page script -->
<script src="{{asset('/theme/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/theme/plugins/nestable/jquery.nestable.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--script for this page only-->
<!-- begin:default config scripts -->
<!-- @include('_layout.partials.datatable') -->
<!-- end:default config scripts -->
<script type="text/javascript">
    let updateOutput = function(e) {
        let list = e.length ? e : $(e.target),
            output = list.data('output');

        $.ajax({
            method: "POST",
            url: "{{ route('categories.reorder' )}}",
            data: {
                list: list.nestable('serialize')
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("Unable to save new list order: " + errorThrown);
        });
    };

    var nest = $('#category_nestable').nestable({
        group: 1,
        maxDepth: 7,
    });
    nest.on('change', updateOutput);

    // Delete record
    nest.on('click', '.delete', function() {
        // fetch needed data from li
        let $li = $(this).closest('li');
        let entity = $li.data('id');
        let url_route = $(this).data('route');
        
        // show swal to make sure this is an intentional action
        Swal.fire({
            title: "@lang('Are you sure you want to delete this?')",
            text: "@lang('some or all data may be lost')",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "@lang('Yes')",
            cancelButtonText: "@lang('No, cancel')"
        }).then(function(result) {
            if (result.value) {
                // if user decides to proceed
                $.ajax({
                    url: url_route,
                    method: 'POST',
                }).done(function(response) {
                    location.reload();
                });
            }
        });
    });

    // De-/Activate a record
    nest.on('click', '.activate-deactivate', function(e) {
        // fetch needed data from row
        let $li = $(this).closest('li');
        let entity = $li.data('id');
        let url_route = $(this).data('route');
        // make an ajax request
        $.ajax({
            url: url_route,
            method: 'POST'
        }).done(function(response) {
            location.reload();
        });
    });
</script>
<!-- end:page script -->
@endpush