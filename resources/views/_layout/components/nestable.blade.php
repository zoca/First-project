@if(!$entities->isEmpty())
<ol class="dd-list">
    @foreach($entities as $entity)
    <li class="dd-item dd3-item" data-id="{{ $entity->id }}">
        <div class="dd-handle dd3-handle"></div>
        <div class="dd3-content">
            {{ $entity->name }}
        </div>
        @include('categories.partials.table.actions', ['entity' => $entity])
        @if($entity->children->count() > 0)
            @nestable(['entities' => $entity->children])
            @endnestable
        @endif
    </li>
    @endforeach
</ol>
@endif