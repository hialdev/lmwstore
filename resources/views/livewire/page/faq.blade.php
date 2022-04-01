<div>
    <div class="page-content">
        <div class="container pt-3">
            <h1 class="text-center mb-3">FAQs</h1><!-- End .title -->
            <div class="accordion accordion-rounded" id="accordion-1">
                @foreach ($faqs as $faq)
                <div class="card card-box card-sm bg-light">
                    <div class="card-header" id="heading-{{$loop->index}}">
                        <h2 class="card-title">
                            <a role="button" data-toggle="collapse" href="#collapse-{{$loop->index}}" aria-expanded="true" aria-controls="collapse-{{$loop->index}}" class="{{$loop->index!==0 ? 'collapsed' : ''}}">
                                {{$faq->title}}
                            </a>
                        </h2>
                    </div><!-- End .card-header -->
                    <div id="collapse-{{$loop->index}}" class="collapse {{$loop->index===0 ? 'show' : ''}}" aria-labelledby="heading-{{$loop->index}}" data-parent="#accordion-1">
                        <div class="card-body">
                            {!! $faq->desc !!}
                        </div><!-- End .card-body -->
                    </div><!-- End .collapse -->
                </div><!-- End .card -->
                @endforeach
            </div><!-- End .accordion -->

        </div><!-- End .container -->
    </div>
</div>
