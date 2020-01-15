<div class="button-list">
    <a href="{{route('categories.edit', ['entity' => $entity->id])}}" class="btn-active btn btn-icon waves-effect btn-warning"><i class="mdi mdi-pencil"></i></a>
    @unless($entity->isActive())
        <button class="btn btn-icon waves-effect btn-success activate-deactivate" data-route="{{route('categories.change_active', ['entity' => $entity->id])}}">
            <i class="mdi mdi-check"></i>
        </button>
    @else
        <button class="btn btn-icon waves-effect btn-danger activate-deactivate" data-route="{{route('categories.change_active', ['entity' => $entity->id])}}">
            <i class="mdi mdi-close"></i>
        </button>
    @endunless
    <button class="btn btn-icon waves-effect btn-danger delete" data-route="{{route('categories.delete', ['entity' => $entity->id])}}"><i class="mdi mdi mdi-delete"></i></button>
</div>