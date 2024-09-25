@extends('layouts.master')

@push('style-include')

@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="i-card-md">
                <div class="card--header">
                    <h4 class="card-title">
                        {{ translate('Update Password') }}
                    </h4>
                </div>

                    <div class="card-body">
                        <div class="mb-10">
                            <div class="mt-30">
                                <form action="{{ route('user.password.update') }}" method="POST" onsubmit="return validatePasswords()">
                                    @csrf
                                    <!-- Current Password -->
                                    <div class="form-inner">
                                        <label for="current_password">
                                            {{ translate('Current Password') }} <small class="text-danger">*</small>
                                        </label>
                                        <div class="input-group">
                                            <input id="current_password"
                                                   name="current_password"
                                                   type="password"
                                                   class="form-control"
                                                   placeholder="{{ translate('Enter current password') }}"
                                                   required>
                                            <button type="button" class="input-group-text" onclick="togglePasswordVisibility('current_password', this)">
                                                <i class="bi bi-eye" id="eye-icon-current"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- New Password -->
                                    <div class="form-inner">
                                        <label for="password">
                                            {{ translate('New Password') }} <small class="text-danger">*</small>
                                        </label>
                                        <div class="input-group">
                                            <input id="password"
                                                   name="password"
                                                   type="password"
                                                   class="form-control"
                                                   placeholder="{{ translate('Enter new password') }}"
                                                   required>
                                            <button type="button" class="input-group-text" onclick="togglePasswordVisibility('password', this)">
                                                <i class="bi bi-eye" id="eye-icon-new"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div class="form-inner mt-4">
                                        <label for="password_confirmation">
                                            {{ translate('Confirm New Password') }} <small class="text-danger">*</small>
                                        </label>
                                        <div class="input-group">
                                            <input id="password_confirmation"
                                                   name="password_confirmation"
                                                   type="password"
                                                   class="form-control"
                                                   placeholder="{{ translate('Confirm new password') }}"
                                                   required>
                                            <button type="button" class="input-group-text" onclick="togglePasswordVisibility('password_confirmation', this)">
                                                <i class="bi bi-eye" id="eye-icon-confirm"></i>
                                            </button>

                                        </div>
                                        <div id="confirmPasswordError" class="text-danger mt-1 d-none" ></div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-end">
                                        <button type="submit" class="i-btn ai-btn btn--md btn--primary" data-anim="ripple">
                                            {{ translate('Update Password') }}
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>



            </div>
        </div>
    </div>
</div>
@endsection

@push('script-include')
@endpush

@push('script-push')
<script>
    function togglePasswordVisibility(inputId, button) {
        const inputField = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (inputField.type === "password") {
            inputField.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            inputField.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    function validatePasswords() {
        const newPassword = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const errorDiv = document.getElementById('confirmPasswordError');


        errorDiv.classList.add('d-none');
        errorDiv.textContent = '';

        if (newPassword !== confirmPassword) {
            errorDiv.textContent = "{{ translate('New password and confirm password do not match.') }}";
            errorDiv.classList.remove('d-none');
            return false;
        }
        return true;
    }
</script>
@endpush
