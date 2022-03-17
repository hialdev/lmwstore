<div>
    
    <div class="brands-border border-top border-bottom bg-white d-flex justify-content-center align-items-center mb-5"> 
        @foreach ($brands as $brand)
        <a href="{{url('brand/'.$brand->slug)}}" class="brand border-0 d-flex align-items-center px-4" style="width: 10em;">
            <img src="{{asset('storage'.$brand->image)}}" alt="{{$brand->name}}" class="w-100">
        </a>
        @endforeach
    </div><!-- End .owl-carousel -->

</div>
