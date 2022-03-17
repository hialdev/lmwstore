<div>

    <div class="page-content border-0">
        <div class="border-0 bg-white">
            <iframe id="map" class="mb-5" style="width: 100%;border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.51252896939!2d106.88925711536972!3d-6.195903262426719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4bfa036c11b%3A0xce36f6058e6d20ea!2sJl.%20Paus%20No.90%2C%20RT.1%2FRW.8%2C%20Jati%2C%20Kec.%20Pulo%20Gadung%2C%20Kota%20Jakarta%20Timur%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2013220!5e0!3m2!1sen!2sid!4v1646622680776!5m2!1sen!2sid" allowfullscreen="" loading="lazy"></iframe>
        </div><!-- End #map -->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Office</h3>

                        <address>1 New York Plaza, New York, <br>NY 10004, USA</address>
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-4 -->

                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Start a Conversation</h3>

                        <div><a href="mailto:#">info@Molla.com</a></div>
                        <div><a href="tel:#">+1 987-876-6543</a>, <a href="tel:#">+1 987-976-1234</a></div>
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-4 -->

                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h3>Social</h3>

                        <div class="social-icons social-icons-color justify-content-center">
                            <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                            <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                            <a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                            <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                            <a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                        </div><!-- End .soial-icons -->
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
