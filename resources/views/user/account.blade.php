<form name="account-form" method="POST" action="{{ route('users.update', Auth::user()->id) }}" enctype="multipart/form-data" id="formUpdateAccount">
    @csrf
    @method('patch')
    <div class="modal fade" id="user-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Account</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="student_number"
                                class="col-md-4 col-form-label text-md-right">{{ __('Number Code') }}</label>

                            <div class="col-md-6">
                                <input id="student_number" type="text"
                                    class="form-control @error('student_number') is-invalid @enderror"
                                    name="student_number" value="{{ Auth::user()->student_number }}" required
                                    autocomplete="student_number" autofocus disabled>
                                <input type="text" name="student_number_mask" style="display:none;">
                                @error('student_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                    value="{{ Auth::user()->first_name }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middle_name" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                            <div class="col-md-6">
                                <input id="middle_name" type="text"
                                    class="form-control @error('middle_name') is-invalid @enderror" name="middle_name"
                                    value="{{ Auth::user()->middle_name }}" autocomplete="middle_name">

                                @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                    value="{{ Auth::user()->last_name }}" required autocomplete="last_name">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthdate" class="col-md-4 col-form-label text-md-right">{{ __('Birthdate') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input type="date" id="birthdate" name="birthdate"
                                class="form-control @error('birthdate') is-invalid @enderror" name="birthdate"
                                value="{{ Auth::user()->birthdate }}" required placeholder="Birthdate">

                                @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror"
                                    name="gender" required>
                                    <option value="" disabled selected>Gender</option>
                                    <option {{ (Auth::user()->gender == 'Male' ? 'selected' : '')}}>Male</option>
                                    <option {{ (Auth::user()->gender == 'Female' ? 'selected' : '')}}>Female</option>
                                </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact_number" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input id="contact_number"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type = "number"
                                    maxlength = "11"
                                    class="form-control @error('contact_number') is-invalid @enderror"
                                    name="contact_number" value="{{ Auth::user()->contact_number }}" required autocomplete="contact_number"
                                    placeholder="Contact Number">
                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input id="address" type="text"
                                    class="form-control @error('address') is-invalid @enderror" name="address"
                                    value="{{ Auth::user()->address }}" required autocomplete="address">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ Auth::user()->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" onkeyup="comparePassword('')">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <i class="text-info">If not changing password, please leave it blank.</i>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" onkeyup="comparePassword('')">
                                <span id="password-does-not-match-text" class="text-danger" hidden>
                                    Password does not match
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profile_picture"
                                class="col-md-4 col-form-label text-md-right">{{ __('Profile Picture') }}</label>

                            <div class="col-md-6">
                                <input id="profile_picture" type="file" name="profile_picture">
                                </br><i class="text-info">If not changing profile picture, please leave it
                                    blank.</i>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="submitBtn" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</form>
