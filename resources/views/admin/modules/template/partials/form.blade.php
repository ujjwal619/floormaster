<div class="form-container">
  <div class="row" v-show="page===1">
    @include('admin.modules.template.partials.page_1')
  </div>
  <div class="row" v-show="page===2">
    @include('admin.modules.template.partials.page_2')
  </div>

  <div class="row">
    <div class="col-xsmall-12 col-small-12">
      <button class="btn btn-success pull-right" @click="submit">Save</button>
    </div>
  </div>


  <div class="row">
    <div class="col-xsmall-12 col-small-12">
      <portlet-content isform="true" :onlybody="true">
        <template slot="body">
          <button type="button" class="btn action-buttons" @click="openModal('SearchTemplate')">Search</button>

          @if(request()->segment(3) === 'edit')
            <a href="{{ !is_null($previous) ? route('admin.templates.edit', $previous) : '#' }}  "
               class="btn action-buttons"
            >Previous</a>
            <a href="{{ !is_null($next) ?  route('admin.templates.edit', $next)  : '#' }}"
               class="btn action-buttons">Next</a>
            <a class="btn action-buttons" href="{{ route('admin.templates.create') }}">Add</a>
            <a class="btn action-buttons" href="#">Update</a>
            <form action="{{ route('admin.templates.destroy', $template->id) }}" method="post"
                  style="display: inline;">
              @method('DELETE')
              @csrf
              <button class="btn action-buttons"
                      onclick="return confirm('Are you sure?');">Delete
              </button>
            </form>
            <a class="btn action-buttons" @click.prevent="page = 1" :class="{ currentPage : page=== 1}">
              1
            </a>
            <a class="btn action-buttons" @click.prevent="page = 2" :class="{ currentPage : page=== 2}">
              2
            </a>
          @endif
        </template>
      </portlet-content>
    </div>
  </div>

  <template v-if="mountSearchTemplate">
    <search-template
            :sites="sites"
            @selected="handleSelectedTemplate"
            @close="closeModal('SearchTemplate')"
    />
  </template>
</div>
