<div class="list-group">
  <a href="{{ route('Theme.show',$app->id)}}" class="list-group-item list-group-item-action {{  request()->is('admin/theme/'.$app->id) ? 'active' : ''  }}" aria-current="true">
    Theme Home
  </a>
  <a href="{{ route('Page.index',$app->id)}}" class="list-group-item list-group-item-action {{  request()->is('admin/theme/*/page*') ? 'active' : ''  }}">Pages</a>
  <a href="{{ route('Module.index',$app->id)}}" class="list-group-item list-group-item-action {{  request()->is('admin/theme/*/module*') ? 'active' : ''  }}">Modules</a>
  <a href="{{ route('Asset.index',$app->id)}}" class="list-group-item list-group-item-action {{  request()->is('admin/theme/*/asset*') ? 'active' : ''  }}">Assets</a>
</div>