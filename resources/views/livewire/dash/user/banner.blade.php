<div class="card bg-dark text-white rounded-0">
    <img src="{{asset('storage'.$banner->image)}}" class="card-img rounded-0" alt="{{$banner->title}} Banner" style="max-height: 23em;object-fit:cover">
    <div class="card-img-overlay rounded-0 p-4 w-100" style="max-width: 40em">
        <small>{{$banner->subtitle}}</small>
        <h1 class="text-white">{{$banner->title}}</h1>
        <hr>
        <p class="card-text">{{$banner->desc}}</p>
        <a href="{{$banner->url}}" class="btn btn-primary">{{$banner->btn_text}}</a>
    </div>
</div>