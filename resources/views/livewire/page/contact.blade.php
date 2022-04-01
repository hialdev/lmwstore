<div>

    <div class="page-content border-0">
        <div class="border-0 bg-white">
            <iframe id="map" class="mb-5" style="width: 100%;border:0" src="{{$setting->get('gmaps')->content}}" allowfullscreen="" loading="lazy"></iframe>
        </div><!-- End #map -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Office</h3>

                        <address>{{$setting->get('address')->content}}</address>
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-4 -->

                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Start a Conversation</h3>

                        <div class="social-icons d-flex justify-content-center">
                            @foreach ($contacts as $c) 
                                <a href="{{$c->url}}" class="social-icon" target="_blank" title="{{$c->platform}}"><span class="iconify" data-icon="{{$c->icon}}"></span></a>
                            @endforeach
                        </div><!-- End .soial-icons -->
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-4 -->

                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Direct Chat</h3>

                        <div class="d-inline-flex align-items-center p-4 border rounded">
                            <span class="iconify text-primary" data-icon="bi:whatsapp" style="width: 3em; height:3em;"></span>
                            <a href="" class="ml-3 btn btn-primary text-white">Chat Via WhatsApp</a>
                        </div>
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-4 -->
            </div><!-- End .row -->

            <hr class="mt-3 mb-5 mt-md-1">
            <div class="touch-container row justify-content-center">
                <div class="col-md-9 col-lg-7">
                    <div class="text-center">
                        <h2 class="title mb-1">Get In Touch</h2><!-- End .title mb-2 -->
                        <p class="lead text-primary">
                            Hubungi kami dengan form dibawah, kami akan menjawab secepatnya!.
                        </p><!-- End .lead text-primary -->
                    </div><!-- End .text-center -->
                    @if (session()->has('failed'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{  session('failed') }}<a href="{{route('cart')}}" class="btn-primary p-3 ml-3">Lihat keranjang</a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{  session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <form wire:submit.prevent="sendEmail" class="contact-form mb-2">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cname" class="sr-only">Name</label>
                                <input wire:model="name" type="text" class="form-control" id="cname" placeholder="Name *" required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div><!-- End .col-sm-4 -->

                            <div class="col-sm-4">
                                <label for="cemail" class="sr-only">Email</label>
                                <input wire:model="email" type="email" class="form-control" id="cemail" placeholder="Email *" required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div><!-- End .col-sm-4 -->

                            <div class="col-sm-4">
                                <label for="cphone" class="sr-only">Phone</label>
                                <input wire:model="phone" type="tel" class="form-control" id="cphone" placeholder="Phone *">
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div><!-- End .col-sm-4 -->
                        </div><!-- End .row -->

                        <label for="csubject" class="sr-only">Subject / Tujuan</label>
                        <input wire:model="subject" type="text" class="form-control" id="csubject" placeholder="Subject">
                        @error('subject') <span class="text-danger">{{ $message }}</span> @enderror

                        <label for="cmessage" class="sr-only">Message</label>
                        <textarea wire:model="message" class="form-control" cols="30" rows="4" id="cmessage" required placeholder="Message *"></textarea>
                        @error('message') <span class="text-danger">{{ $message }}</span> @enderror

                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                <span>SUBMIT</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </div><!-- End .text-center -->
                    </form><!-- End .contact-form -->
                </div><!-- End .col-md-9 col-lg-7 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</div>
