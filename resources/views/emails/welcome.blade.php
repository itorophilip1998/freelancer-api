@extends('./layouts/app')

@section('content')
    <div class="body"> 
        <h4 class="head">
           Welcome To Freelancer
        </h4>

        <section class="content">
  <p>
     Hi username!
  </p>
  <p>
      Thanks for choosing the Freelancer, we’re happy you’ve chosen to be part of us!  
  </p>
<p>
    Sesarch a various types of services around your location with ease — welcome! If there’s anything you need, we’ll be here every step of the way.
</p>
<p >
Thanks, <br/>
Freelancer Team
</p>
        </section>
      {{--  {{ $data["link"] }}  --}}
<div class="extra">
   <div class="btn_container">
        <a href="/" target="_blank" class="btn_text">
        Confirm Email Address
    </a>
   </div>
    <div class="token">
    Here is your token  <b>1234</b>
    </div>
    <div class="link">
      You can copy the link <a href="hoioiqe" target="_blank">https://hajhgsjas.com</a>
    </div>
</div>

</div>
@endsection