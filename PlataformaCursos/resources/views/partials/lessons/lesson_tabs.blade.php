<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a 
      class="nav-link" 
      id="material-tab" 
      data-toggle="tab" 
      href="#material" 
      role="tab" 
      aria-controls="material" 
      aria-selected="false"
    >
      {{ __("Material de apoyo") }}
    </a>
  </li>
  <li class="nav-item">
    <a 
      class="nav-link active" 
      id="mi-material-tab" 
      data-toggle="tab" 
      href="#mi-material" 
      role="tab" 
      aria-controls="mi-material" 
      aria-selected="true"
    >
      {{ __('Compartir material') }}
    </a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div 
    class="tab-pane fade" 
    id="material" 
    role="tabpanel" 
    aria-labelledby="material-tab"
  >
    @include('partials.lessons.list_files')  
  </div>
  <div 
    class="tab-pane fade show active" 
    id="mi-material" 
    role="tabpanel" 
    aria-labelledby="mi-material-tab"
  >
    @include('partials.lessons.share_files')  
  </div>
</div>