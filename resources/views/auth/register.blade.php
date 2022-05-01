<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<div id="bg">
    <img src="{{ asset('storage/bg/abstract-green-triangles-bg.jpg') }}" alt="">
</div>

<body class="hold-transition login-page">
    <div class="login-box" style="width:50vh">
        <!-- /.login-logo -->
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <img src="{{ asset('images/cvsu-logo.png') }}" alt="CvSU Logo" style="width:80px" class="mb-3">
                <h4>{{ config('app.name', 'Laravel') }}</h4>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new account.</p>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="student_number" type="text"
                            class="form-control @error('student_number') is-invalid @enderror" name="student_number"
                            value="{{ old('student_number') }}" required autocomplete="student_number" autofocus
                            placeholder="Student Number">
                        <input type="text" name="student_number_mask" style="display:none;">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-graduate"></span>
                            </div>
                        </div>
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('student_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                            name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name"
                            placeholder="First Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="input-group mb-3">
                        <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror"
                            name="middle_name" value="{{ old('middle_name') }}" autocomplete="middle_name"
                            placeholder="Middle Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        &nbsp;<span>&nbsp;</span>
                        @error('middle_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="input-group mb-3">
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                            name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name"
                            placeholder="Last Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="input-group mb-3">
                        <input type="text" id="birthdate" name="birthdate"
                            class="form-control @error('birthdate') is-invalid @enderror" name="birthdate"
                            required placeholder="Birthdate" onfocus="(this.type='date')" onblur="(this.type='text')">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-calendar-week"></span>
                            </div>
                        </div>
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('birthdate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <select id="gender" class="form-control @error('gender') is-invalid @enderror"
                            name="gender" value="{{ old('gender') }}" required>
                            <option value="" disabled selected>Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-venus-mars"></span>
                            </div>
                        </div>
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="contact_number"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            type = "number"
                            maxlength = "11"
                            class="form-control @error('contact_number') is-invalid @enderror"
                            name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number"
                            placeholder="Contact Number">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-address-book"></span>
                            </div>
                        </div>
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('contact_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                            name="address" value="{{ old('address') }}" required autocomplete="address"
                            placeholder="Address">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-address-card"></span>
                            </div>
                        </div>
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password" placeholder="Password">
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Confirm Password">
                        &nbsp;<span style="color:red;font-weight:bold">*</span>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group">
                            <span>Upload your Profile Picture</span>
                        </div>
                        <input id="profile_picture" type="file" name="profile_picture">
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                @if (Route::has('register'))
                    <p class="mb-0">
                        <a href="{{ route('login') }}" class="text-center">{{ __('Login') }}</a>
                    </p>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</body>

</html>
