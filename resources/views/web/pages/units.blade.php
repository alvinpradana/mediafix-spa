<div class="container">
    <div class="row" >
        <div class="col-lg-6 text-center text-lg-start" data-aos="fade-right">
            <h4 class="py-1">Temukan unit repair anda disini</h4>
            <p class="para-light">
                Untuk mengetahui kondisi unit repair, anda bisa memasukkan Token Nota Anda pada form disamping. 
                Atau anda bisa menghubungi Admin kami melalui kontak yang tersedia.
            </p>
        </div>
        <div class="col-lg-6 d-flex align-items-center" data-aos="fade-down">
            <form action="{{ route('invoice') }}" method="get" class="input-group my-3">
                <input type="text" class="form-control p-2" name="stripe_token" value="{{ old('stripe_token') }}" placeholder="Enter your stripe token">
                <button class="btn-secondary text-light" type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div class="row footer rounded mt-5">
        <div class="col-lg-4 d-flex align-items-center">
            <div class="p-2"><i class="fas fa-globe fa-2x"></i></div>
            <div class="ms-2">
                <h6><a href="/">www.mediafix.id</a></h6>
            </div>
        </div>
        <div class="col-lg-4 d-flex align-items-center">
            <div class="p-2"><i class="fab fa-whatsapp fa-2x"></i></div>
            <div class="ms-2">
                <h6><a href="https://wa.me/6283817759139" target="_blank">0838-1775-9139</a> | <a href="https://wa.me/6282299317878" target="_blank">0822-9931-7878</a></h6>
            </div>
        </div>
        <div class="col-lg-4 d-flex align-items-center">
            <div class="p-2"><i class="fab fa-instagram fa-2x"></i></div>
            <div class="ms-2">
                <h6><a href="https://www.instagram.com/mediafix.id/" target="_blank">@medifix.id</a> | <a href="https://www.instagram.com/mediafix.jogja/" target="_blank">@mediafix.jogja</a></h6>
            </div>
        </div>
    </div>
</div>