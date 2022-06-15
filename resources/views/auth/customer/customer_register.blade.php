@extends('layouts.web.app')
@section('content')
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

<script src='https://www.google.com/recaptcha/api.js?render=SITE_KEY' async defer></script>
<script src='https://www.google.com/recaptcha/api.js?render=SECURITY_KEY' async defer></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
{{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />  --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

   <div class="container-fluid tm-container-content tm-mt-60" style="padding: 30px;margin-top: -3%;">

            <div class="row mb-4">
                <h1 class="text-center" style="font-size: 1.5rem;margin-top: 50px;font-weight: 400;">
                    Create account
                </h1>
        <div class="row">
             <div class="col-md-4 mx-auto">
                <div class="myform form mt-2 ">
                 {{--  <p class="login-box-msg">{{__('auth.registration')}}</p>  --}}
                   <form method="POST" class="customer_reg_form" action="{{ route('customer.send_verification_code') }}" autocomplete="off" novalidate>
                    @csrf

                      <div class="form-group col-md-4 " style="padding: 0;">
                        <select style="border: solid 1px lightgrey;border-radius: 4px;color: grey !important;height: 6%;" data-message="Bitte w채hlen Sie die Option aus der Liste" name="title" id="data-message" class=" @error('title') is-invalid @enderror">
                                <option value="">-</option>
                                <option {{ old('title') == 'mr'  ? 'selected' : '' }} value="mr">Mr</option>
                                <option {{ old('title') == 'mrs' ? 'selected' : '' }}  value="mrs">Mrs</option>
                            </select>
                            @error('title')
                                <span class="invalid-feedback error" role="alert">
                                    <small>{{ $message }}</small>
                                        {{--<strong>{{__('auth.customer_registration_form_alert_input_title')}}</strong>--}}
                                </span>
                            @enderror
                      </div>

                      <div class="form-group">
                        <input  type="text" value="{{ old('name') }}"
                            name="name" required = "requried"
                            class="form-control @error('name') is-invalid @enderror" data-message="Bitte geben Sie in das Feld etwas ein" placeholder="First Name">
                    @error('name')
                        <span class="invalid-feedback error" role="alert">
                                <strong>{{ $message }}</strong>
                                {{--<strong>{{__('auth.customer_registration_form_alert_input_name')}}</strong>--}}
                        </span>
                    @enderror
                      </div>
                      <div class="form-group">
                        <input  type="text" value="{{ old('last_name') }}"
                                   name="last_name"
                                   class="form-control @error('last_name') is-invalid @enderror" data-message="Bitte geben Sie in das Feld etwas ein" placeholder="Last Name">
                            @error('last_name')
                                <span class="invalid-feedback error" role="alert">
                                    <strong>{{ $message }}</strong>
                                        {{--<strong>{{__('auth.customer_registration_form_alert_input_last_name')}}</strong>--}}
                                </span>
                            @enderror
                      </div>
                      <div class="form-group">
                          <input  type="email" value="{{ old('email') }}"
                                   name="email"
                                    {{--oninvalid="this.setCustomValidity('E-Mail Adresse ist ung체ltig.')"
                                    oninput="this.setCustomValidity('')"--}}
                                   class="form-control @error('email') is-invalid @enderror" data-message="Bitte geben Sie in das Feld etwas ein" placeholder="{{__('auth.customer_registration_form_input_email')}}">

                            @error('email')
                            <span class="invalid-feedback error" role="alert">
                                 <strong>{{ $message }}</strong>
                                    {{--<strong>{{__('auth.customer_registration_form_alert_input_email')}}</strong>--}}
                            </span>
                            @enderror
                      </div>
                      <div class="form-group">
                         <input  type="email" value="{{ old('email_confirmation') }}"
                                   name="email_confirmation"
                                    {{--oninvalid="this.setCustomValidity('E-Mail Adresse stimmt nicht mit der Best채tigung 체berein.')"
                                    oninput="this.setCustomValidity('')"--}}
                                   class="form-control @error('email') is-invalid @enderror" data-message="Bitte geben Sie in das Feld etwas ein" placeholder="Confirm Email}">

                            @error('email_confirmation')
                            <span class="invalid-feedback error" role="alert">
                                     <strong>{{ $message }}</strong> -
                                        {{--<strong>{{__('auth.customer_registration_form_alert_input_email_confirm')}}</strong>--}}
                                </span>
                            @enderror
                      </div>
                       <div class="form-group">
                          <div class="g-recaptcha {{ $errors->has('g-recaptcha-response') ? 'is-invalid' : '' }}"
                                 data-sitekey="{{config('recaptcha.api_site_key')}}"></div>
                            @error('g-recaptcha-response')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12" style="padding: 0;">
                        <button type="submit"  class="btn btn-secondary btn-sm" style="background-color:#048BA8;">Save and continue</button>
                      </div>
</form>

                      <div class="form-group mt-4 text-center">

        or <span><a class="" href="{{ url('/') }}" style="color: #048ba8;font-size: 14px;">Bact to store</a></span>
    </div>


                   <p class="text-gray text-sm text-center"> Do you already have a customer account? <a href="{{route('customer.login_form')}}"><u>Log in here</u></a></p>
                </div>
             </div>
          </div>

    </div>
             <!-- row -->

        </div><!-- container-fluid, tm-container-content -->

@endsection

@push('scripts')
    @include('common.recaptcha')
@endpush


