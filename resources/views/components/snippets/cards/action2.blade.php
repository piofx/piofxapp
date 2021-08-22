<div {{ $attributes->merge(['class' => 'card']) }}>
<form class="form">
 <div class="card-footer bg-gray-100 border-top-0">
  <div class="row align-items-center">
   <div class="col text-left">
    <h2>{{$title}} Module</h2>
   </div>
   <div class="col text-right">
    <button type="submit" class="btn btn-primary font-weight-bold mr-2">Submit</button>
    <a href="{{route('Page.index',$appid)}}"  class="btn btn-light-info font-weight-bold">Close</a>
   </div>
  </div>
 </div>
 <div class="card-body bg-white">
  {{$slot}}
 </div>
</form>
</div>