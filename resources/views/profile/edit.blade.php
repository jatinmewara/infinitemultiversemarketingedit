<x-app-layout>
    <div class="main-content">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section class="space-y-6">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Delete Account') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                                </p>
                            </header>

                            <x-danger-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>

                            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                    @csrf
                                    @method('delete')

                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Are you sure you want to delete your account?') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                    </p>

                                    <div class="mt-6">
                                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                                        <x-text-input id="password" name="password" type="password"
                                            class="mt-1 block w-3/4" placeholder="{{ __('Password') }}" />

                                        <x-input-error :messages="$errors->userDeletion->get('password')"
                                            class="mt-2" />
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-danger-button class="ms-3">
                                            {{ __('Delete Account') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </section>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="personal">Personal Information</button>
                <button class="tab-btn" data-tab="notifications">Change Password</button>
                <button class="tab-btn" data-tab="contact">Manage Contact</button>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Personal Information Tab -->
                <div class="tab-pane active" id="personal">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Profile Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                    <div>
                                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                            {{ __('Your email address is unverified.') }}

                                            <button form="send-verification"
                                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>

                    <div class="tab-header">
                        <h2>Personal Information</h2>
                    </div>

                    <form class="settings-form" id="personalForm">
                        <div class="profile-section">
                            <div class="profile-avatar">
                                <img src="/placeholder.svg?height=80&width=80" alt="Profile Avatar" id="avatarImg">
                                <button type="button" class="avatar-edit-btn" id="avatarEditBtn">
                                    <i class="fas fa-camera"></i>
                                </button>
                                <input type="file" id="avatarInput" accept="image/*" style="display: none;">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name:</label>
                                <input type="text" id="firstName" name="firstName" value="Barry">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" id="lastName" name="lastName" value="Tech">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="userName">User Name:</label>
                                <input type="text" id="userName" name="userName" value="BarryBlu">
                            </div>
                            <div class="form-group">
                                <label for="city">City:</label>
                                <input type="text" id="city" name="city" value="Atlanta">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Gender:</label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="gender" value="male" checked>
                                        <span class="radio-custom"></span>
                                        Male
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="gender" value="female">
                                        <span class="radio-custom"></span>
                                        Female
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dateOfBirth">Date Of Birth:</label>
                                <input type="date" id="dateOfBirth" name="dateOfBirth" value="1995-01-26">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="maritalStatus">Marital Status:</label>
                                <select id="maritalStatus" name="maritalStatus">
                                    <option value="single" selected>Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <select id="age" name="age">
                                    <option value="18-25">18-25</option>
                                    <option value="26-32">26-32</option>
                                    <option value="33-45" selected>33-45</option>
                                    <option value="46-55">46-55</option>
                                    <option value="55+">55+</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="country">Country:</label>
                                <select id="country" name="country">
                                    <option value="usa" selected>USA</option>
                                    <option value="canada">Canada</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="australia">Australia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="state">State:</label>
                                <select id="state" name="state">
                                    <option value="georgia" selected>Georgia</option>
                                    <option value="california">California</option>
                                    <option value="texas">Texas</option>
                                    <option value="florida">Florida</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="address">Address:</label>
                            <textarea id="address" name="address" rows="4"
                                placeholder="37 Cardinal Lane&#10;Petersburg, VA 23803&#10;United States of America&#10;Zip Code: 85001"></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Tab -->
                <div class="tab-pane" id="notifications">
                    <div class="tab-header">
                        <h2>Change Password</h2>
                    </div>

                    <form class="settings-form" id="passwordForm">
                        <div class="form-group full-width">
                            <label for="currentPassword">Current Password:</label>
                            <input type="password" id="currentPassword" name="currentPassword"
                                placeholder="Enter current password">
                        </div>

                        <div class="form-group full-width">
                            <label for="newPassword">New Password:</label>
                            <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password">
                        </div>

                        <div class="form-group full-width">
                            <label for="verifyPassword">Verify Password:</label>
                            <input type="password" id="verifyPassword" name="verifyPassword"
                                placeholder="Confirm new password">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Manage Contact Tab -->
                <div class="tab-pane" id="contact">
                    <div class="tab-header">
                        <h2>Manage Contact</h2>
                    </div>

                    <form class="settings-form" id="contactForm">
                        <div class="form-group full-width">
                            <label for="contactNumber">Contact Number:</label>
                            <input type="tel" id="contactNumber" name="contactNumber" value="(00) 2635 123 456">
                        </div>

                        <div class="form-group full-width">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="barrytech@demo.com">
                        </div>

                        <div class="form-group full-width">
                            <label for="url">URL:</label>
                            <input type="url" id="url" name="url" value="https://getbootstrap.com">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: #2a2d3a;
        color: #ffffff;
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        background-color: #2a2d3a;
    }

    /* Tab Navigation */
    .tab-navigation {
        display: flex;
        background-color: #2a2d3a;
        border-bottom: 1px solid #3a3d4a;
    }

    .tab-btn {
        flex: 1;
        padding: 16px 24px;
        background-color: #3a3d4a;
        color: #8b8d97;
        border: none;
        border-right: 1px solid #2a2d3a;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
    }

    .tab-btn:last-child {
        border-right: none;
    }

    .tab-btn:hover {
        background-color: #4a4d5a;
        color: #ffffff;
    }

    .tab-btn.active {
        background-color: #4f46e5;
        color: #ffffff;
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #4f46e5;
    }

    /* Tab Content */
    .tab-content {
        background-color: #2a2d3a;
        min-height: 600px;
    }

    .tab-pane {
        display: none;
        padding: 30px;
        animation: fadeIn 0.3s ease;
    }

    .tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tab-header {
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #3a3d4a;
    }

    .tab-header h2 {
        font-size: 24px;
        font-weight: 600;
        color: #ffffff;
    }

    /* Forms */
    .settings-form {
        max-width: 800px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
        margin-bottom: 24px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #e5e7eb;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px 16px;
        background-color: #3a3d4a;
        border: 1px solid #4a4d5a;
        border-radius: 6px;
        color: #ffffff;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #8b8d97;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Profile Section */
    .profile-section {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }

    .profile-avatar {
        position: relative;
        display: inline-block;
    }

    .profile-avatar img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4a4d5a;
    }

    .avatar-edit-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 28px;
        height: 28px;
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: background-color 0.3s ease;
    }

    .avatar-edit-btn:hover {
        background-color: #4338ca;
    }

    /* Radio Buttons */
    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 8px;
    }

    .radio-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 14px;
        color: #e5e7eb;
    }

    .radio-label input[type="radio"] {
        display: none;
    }

    .radio-custom {
        width: 18px;
        height: 18px;
        border: 2px solid #4a4d5a;
        border-radius: 50%;
        margin-right: 8px;
        position: relative;
        transition: all 0.3s ease;
    }

    .radio-label input[type="radio"]:checked+.radio-custom {
        border-color: #4f46e5;
        background-color: #4f46e5;
    }

    .radio-label input[type="radio"]:checked+.radio-custom::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        background-color: white;
        border-radius: 50%;
    }

    /* Checkboxes */
    .notification-section {
        margin-bottom: 30px;
    }

    .notification-section h3 {
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 16px;
    }

    .checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 14px;
        color: #e5e7eb;
        padding: 8px 0;
    }

    .checkbox-label input[type="checkbox"] {
        display: none;
    }

    .checkbox-custom {
        width: 18px;
        height: 18px;
        border: 2px solid #4a4d5a;
        border-radius: 4px;
        margin-right: 12px;
        position: relative;
        transition: all 0.3s ease;
    }

    .checkbox-label input[type="checkbox"]:checked+.checkbox-custom {
        border-color: #4f46e5;
        background-color: #4f46e5;
    }

    .checkbox-label input[type="checkbox"]:checked+.checkbox-custom::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 5px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    /* Buttons */
    .form-actions {
        display: flex;
        gap: 16px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #3a3d4a;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 100px;
    }

    .btn-primary {
        background-color: #4f46e5;
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #4338ca;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #6b7280;
        color: #ffffff;
    }

    .btn-secondary:hover {
        background-color: #5b6370;
        transform: translateY(-1px);
    }

    .btn:active {
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .tab-navigation {
            flex-direction: column;
        }

        .tab-btn {
            border-right: none;
            border-bottom: 1px solid #2a2d3a;
        }

        .tab-btn:last-child {
            border-bottom: none;
        }

        .tab-pane {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .form-actions {
            flex-direction: column;
        }

        .radio-group {
            flex-direction: column;
            gap: 12px;
        }
    }

    @media (max-width: 480px) {
        .tab-btn {
            padding: 12px 16px;
            font-size: 13px;
        }

        .tab-pane {
            padding: 15px;
        }

        .profile-avatar img {
            width: 60px;
            height: 60px;
        }

        .avatar-edit-btn {
            width: 24px;
            height: 24px;
            font-size: 10px;
        }
    }

    /* Success/Error Messages */
    .message {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .message.success {
        background-color: rgba(5, 150, 105, 0.1);
        border: 1px solid #059669;
        color: #10b981;
    }

    .message.error {
        background-color: rgba(220, 38, 38, 0.1);
        border: 1px solid #dc2626;
        color: #ef4444;
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .loading .btn {
        position: relative;
    }

    .loading .btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the tabbed interface
        initializeTabs();
        initializeForms();
        initializeAvatarUpload();
    });

    // Tab functionality
    function initializeTabs() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const targetTab = this.getAttribute('data-tab');

                // Remove active class from all tabs and panes
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));

                // Add active class to clicked tab and corresponding pane
                this.classList.add('active');
                document.getElementById(targetTab).classList.add('active');

                // Trigger animation
                const activePane = document.getElementById(targetTab);
                activePane.style.animation = 'none';
                setTimeout(() => {
                    activePane.style.animation = 'fadeIn 0.3s ease';
                }, 10);
            });
        });
    }

    // Form functionality
    function initializeForms() {
        // Personal Information Form
        const personalForm = document.getElementById('personalForm');
        personalForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleFormSubmit('personal', this);
        });

        // Change Password Form
        const passwordForm = document.getElementById('passwordForm');
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (validatePasswordForm(this)) {
                handleFormSubmit('password', this);
            }
        });

        // Notifications Form
        const notificationsForm = document.getElementById('notificationsForm');
        notificationsForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleFormSubmit('notifications', this);
        });

        // Contact Form
        const contactForm = document.getElementById('contactForm');
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (validateContactForm(this)) {
                handleFormSubmit('contact', this);
            }
        });

        // Cancel buttons
        const cancelBtns = document.querySelectorAll('.btn-secondary');
        cancelBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('form');
                resetForm(form);
                showMessage('Changes cancelled', 'info');
            });
        });
    }

    // Avatar upload functionality
    function initializeAvatarUpload() {
        const avatarEditBtn = document.getElementById('avatarEditBtn');
        const avatarInput = document.getElementById('avatarInput');
        const avatarImg = document.getElementById('avatarImg');

        avatarEditBtn.addEventListener('click', function () {
            avatarInput.click();
        });

        avatarInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        avatarImg.src = e.target.result;
                        showMessage('Profile picture updated successfully', 'success');
                    };
                    reader.readAsDataURL(file);
                } else {
                    showMessage('Please select a valid image file', 'error');
                }
            }
        });
    }

    // Form validation
    function validatePasswordForm(form) {
        const currentPassword = form.querySelector('#currentPassword').value;
        const newPassword = form.querySelector('#newPassword').value;
        const verifyPassword = form.querySelector('#verifyPassword').value;

        if (!currentPassword) {
            showMessage('Please enter your current password', 'error');
            return false;
        }

        if (!newPassword) {
            showMessage('Please enter a new password', 'error');
            return false;
        }

        if (newPassword.length < 6) {
            showMessage('New password must be at least 6 characters long', 'error');
            return false;
        }

        if (newPassword !== verifyPassword) {
            showMessage('New password and verify password do not match', 'error');
            return false;
        }

        if (currentPassword === newPassword) {
            showMessage('New password must be different from current password', 'error');
            return false;
        }

        return true;
    }

    function validateContactForm(form) {
        const email = form.querySelector('#email').value;
        const url = form.querySelector('#url').value;

        if (email && !isValidEmail(email)) {
            showMessage('Please enter a valid email address', 'error');
            return false;
        }

        if (url && !isValidURL(url)) {
            showMessage('Please enter a valid URL', 'error');
            return false;
        }

        return true;
    }

    // Utility functions
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidURL(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    }

    // Form submission handler
    function handleFormSubmit(formType, form) {
        const submitBtn = form.querySelector('.btn-primary');
        const originalText = submitBtn.textContent;

        // Show loading state
        submitBtn.textContent = 'Submitting...';
        submitBtn.disabled = true;
        form.classList.add('loading');

        // Simulate API call
        setTimeout(() => {
            // Reset loading state
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            form.classList.remove('loading');

            // Get form data
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            // Handle different form types
            switch (formType) {
                case 'personal':
                    handlePersonalInfoSubmit(data);
                    break;
                case 'password':
                    handlePasswordSubmit(data);
                    break;
                case 'notifications':
                    handleNotificationsSubmit(form);
                    break;
                case 'contact':
                    handleContactSubmit(data);
                    break;
            }
        }, 1500);
    }

    // Specific form handlers
    function handlePersonalInfoSubmit(data) {
        console.log('Personal Info Data:', data);
        showMessage('Personal information updated successfully', 'success');
    }

    function handlePasswordSubmit(data) {
        console.log('Password changed');
        showMessage('Password changed successfully', 'success');

        // Clear password fields
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('verifyPassword').value = '';
    }

    function handleNotificationsSubmit(form) {
        const emailNotification = form.querySelector('input[name="emailNotification"]').checked;
        const smsNotification = form.querySelector('input[name="smsNotification"]').checked;

        const whenToEmail = Array.from(form.querySelectorAll('input[name="whenToEmail"]:checked'))
            .map(cb => cb.value);

        const whenToEscalate = Array.from(form.querySelectorAll('input[name="whenToEscalate"]:checked'))
            .map(cb => cb.value);

        const notificationData = {
            emailNotification,
            smsNotification,
            whenToEmail,
            whenToEscalate
        };

        console.log('Notification Settings:', notificationData);
        showMessage('Notification preferences updated successfully', 'success');
    }

    function handleContactSubmit(data) {
        console.log('Contact Data:', data);
        showMessage('Contact information updated successfully', 'success');
    }

    // Reset form
    function resetForm(form) {
        const formId = form.id;

        switch (formId) {
            case 'personalForm':
                // Reset to original values
                document.getElementById('firstName').value = 'Barry';
                document.getElementById('lastName').value = 'Tech';
                document.getElementById('userName').value = 'BarryBlu';
                document.getElementById('city').value = 'Atlanta';
                document.querySelector('input[name="gender"][value="male"]').checked = true;
                document.getElementById('dateOfBirth').value = '1995-01-26';
                document.getElementById('maritalStatus').value = 'single';
                document.getElementById('age').value = '33-45';
                document.getElementById('country').value = 'usa';
                document.getElementById('state').value = 'georgia';
                document.getElementById('address').value = '';
                break;
            case 'passwordForm':
                form.reset();
                break;
            case 'contactForm':
                document.getElementById('contactNumber').value = '(00) 2635 123 456';
                document.getElementById('email').value = 'barrytech@demo.com';
                document.getElementById('url').value = 'https://getbootstrap.com';
                break;
            default:
                form.reset();
        }
    }

    // Show message
    function showMessage(text, type = 'info') {
        // Remove existing messages
        const existingMessages = document.querySelectorAll('.message');
        existingMessages.forEach(msg => msg.remove());

        // Create new message
        const message = document.createElement('div');
        message.className = `message ${type}`;
        message.textContent = text;

        // Insert message at the top of active tab pane
        const activePane = document.querySelector('.tab-pane.active');
        const form = activePane.querySelector('.settings-form');
        form.insertBefore(message, form.firstChild);

        // Auto remove message after 5 seconds
        setTimeout(() => {
            if (message.parentNode) {
                message.remove();
            }
        }, 5000);

        // Scroll to message
        message.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey || e.metaKey) {
            switch (e.key) {
                case '1':
                    e.preventDefault();
                    document.querySelector('[data-tab="personal"]').click();
                    break;
                case '2':
                    e.preventDefault();
                    document.querySelector('[data-tab="password"]').click();
                    break;
                case '3':
                    e.preventDefault();
                    document.querySelector('[data-tab="notifications"]').click();
                    break;
                case '4':
                    e.preventDefault();
                    document.querySelector('[data-tab="contact"]').click();
                    break;
            }
        }
    });

    // Auto-save functionality (optional)
    function enableAutoSave() {
        const forms = document.querySelectorAll('.settings-form');

        forms.forEach(form => {
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                input.addEventListener('change', function () {
                    // Save to localStorage
                    const formId = form.id;
                    const fieldName = this.name || this.id;
                    const value = this.type === 'checkbox' ? this.checked : this.value;

                    localStorage.setItem(`${formId}_${fieldName}`, JSON.stringify(value));
                });
            });
        });
    }

    // Load saved data (optional)
    function loadSavedData() {
        const forms = document.querySelectorAll('.settings-form');

        forms.forEach(form => {
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                const formId = form.id;
                const fieldName = input.name || input.id;
                const savedValue = localStorage.getItem(`${formId}_${fieldName}`);

                if (savedValue !== null) {
                    const value = JSON.parse(savedValue);

                    if (input.type === 'checkbox') {
                        input.checked = value;
                    } else {
                        input.value = value;
                    }
                }
            });
        });
    }

    // Initialize auto-save (uncomment to enable)
    // enableAutoSave();
    // loadSavedData();
</script>