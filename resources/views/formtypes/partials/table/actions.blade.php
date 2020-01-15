<div class="button-list">
    <a href="{{route('formtypes.edit', ['entity' => $entity->id])}}" class="btn btn-icon waves-effect btn-warning"><i class="mdi mdi-pencil"></i></a>
    
    <button class="btn btn-icon waves-effect btn-danger delete" data-route="{{route('formtypes.delete', ['entity' => $entity->id])}}"><i class="mdi mdi mdi-delete"></i></button>
</div>