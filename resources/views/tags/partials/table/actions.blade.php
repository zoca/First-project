<div class="button-list">
    <a href="{{route('tags.edit', ['entity' => $entity->id])}}" class="btn btn-icon waves-effect btn-warning"><i class="mdi mdi-pencil"></i></a>
    
    <button class="btn btn-icon waves-effect btn-danger delete" data-route="{{route('tags.delete', ['entity' => $entity->id])}}"><i class="mdi mdi mdi-delete"></i></button>
</div>