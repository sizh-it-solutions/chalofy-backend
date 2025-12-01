@extends('layouts.installer')
@section('styles')
    <style>
        #passwordRules li {
            list-style: none;
            margin-bottom: 4px;
            font-size: 0.9rem;
        }
        .requirement::before {
    display: inline-block;
    margin-right: 4px;
}
.requirement.valid::before {
    content: '✔';
    color: green;
}
.requirement.invalid::before {
    content: '✖';
    color: red;
}

    </style>
@endsection
@section('steps')
    @include('installer.steps')
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4"><i class="fas fa-check-circle text-success"></i> Complete Installation</h2>
        <form id="installerForm" action="{{ route('installer.admin.store') }}" method="post" novalidate>
            @csrf

            <div class="form-group mb-3">
                <label for="name"><i class="fas fa-tag text-primary"></i> App Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    <input type="text" name="site_name" id="site_name" class="form-control" required>
                </div>
                <small class="text-danger d-block mt-1" id="nameError"></small>
            </div>

            <div class="form-group mb-3">
                <label for="name"><i class="fas fa-tag text-primary"></i> Admin Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <small class="text-danger d-block mt-1" id="nameError"></small>
            </div>

            <div class="form-group mb-3">
                <label for="email"><i class="fas fa-envelope text-primary"></i> Admin Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <small class="text-danger d-block mt-1" id="emailError"></small>
            </div>

            <div class="form-group mb-3">
                <label for="password"><i class="fas fa-lock text-primary"></i> Admin Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <small class="text-danger d-block mt-1" id="passwordError"></small>
                <ul class="text-muted small mb-2" id="passwordRules">
                    <li id="rule-length">At least 8 characters</li>
                    <li id="rule-uppercase">At least 1 uppercase letter</li>
                    <li id="rule-lowercase">At least 1 lowercase letter</li>
                    <li id="rule-number">At least 1 number</li>
                    <li id="rule-special">At least 1 special character (@$!%*#?&^_-)</li>
                </ul>
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation"><i class="fas fa-lock text-primary"></i> Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required>
                </div>
                <small class="text-danger d-block mt-1" id="passwordConfirmationError"></small>
            </div>

            <div class="form-group" style="display:none">
                <h4>Choose Modules</h4>
                @foreach ($modules as $module)
                    <div class="form-check">
                        <input type="checkbox" checked name="modules[]" id="module_{{ $module->id }}" value="{{ $module->id }}"
                            class="form-check-input">
                        <label for="module_{{ $module->id }}" class="form-check-label">{{ $module->name }}</label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-check-circle"></i> Complete Installation
            </button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('installerForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');

            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const passwordConfirmationError = document.getElementById('passwordConfirmationError');

            // Rule elements
            const ruleLength = document.getElementById('rule-length');
            const ruleUppercase = document.getElementById('rule-uppercase');
            const ruleLowercase = document.getElementById('rule-lowercase');
            const ruleNumber = document.getElementById('rule-number');
            const ruleSpecial = document.getElementById('rule-special');

            // Helper to toggle rule styles
            function updateRule(element, isValid) {
                let text = element.textContent.replace(/^[✔✖]\s*/, '');
                if (isValid) {
                    element.classList.remove('text-muted');
                    element.classList.add('text-success');
                    element.innerHTML = '<i class="fas fa-check-circle"></i> ' + text;
                } else {
                    element.classList.remove('text-success');
                    element.classList.add('text-muted');
                    element.innerHTML = '<i class="fas fa-times-circle"></i> ' + text;
                }

            }

            // Live password rule check
            passwordInput.addEventListener('input', function () {
                const value = passwordInput.value;
                updateRule(ruleLength, value.length >= 8);
                updateRule(ruleUppercase, /[A-Z]/.test(value));
                updateRule(ruleLowercase, /[a-z]/.test(value));
                updateRule(ruleNumber, /[0-9]/.test(value));
                updateRule(ruleSpecial, /[@$!%*#?&^_\-]/.test(value));
            });

            form.addEventListener('submit', function (e) {
                let valid = true;

                // Clear previous errors
                emailError.textContent = '';
                passwordError.textContent = '';
                passwordConfirmationError.textContent = '';

                const email = emailInput.value.trim();
                const password = passwordInput.value;
                const confirmPassword = passwordConfirmationInput.value;

                // Email validation
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    emailError.textContent = 'Please enter a valid email address.';
                    valid = false;
                }

                // Password complexity validation
                const rules = [
                    value => value.length >= 8,
                    value => /[A-Z]/.test(value),
                    value => /[a-z]/.test(value),
                    value => /[0-9]/.test(value),
                    value => /[@$!%*#?&^_\-]/.test(value)
                ];
                const allRulesPass = rules.every(rule => rule(password));
                if (!allRulesPass) {
                    passwordError.textContent = 'Password does not meet all complexity requirements.';
                    valid = false;
                }

                // Confirm password check
                if (password !== confirmPassword) {
                    passwordConfirmationError.textContent = 'Passwords do not match.';
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection