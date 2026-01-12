<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talks - Share Your Thoughts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function startEdit(talkId) {
            const talkContent = document.getElementById('talk-content-' + talkId).innerText;
            const textarea = document.getElementById('chat-textarea');
            const form = document.getElementById('talk-form');
            const submitBtn = document.getElementById('submit-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const talkIdInput = document.getElementById('talk_id');

            // Populate textarea with talk content
            textarea.value = talkContent;

            // Change form action to update route
            form.action = '{{ route("talks.update", ":id") }}'.replace(':id', talkId);

            // Change method to PUT
            document.querySelector('input[name="_method"]').value = 'PUT';

            // Set talk ID
            talkIdInput.value = talkId;

            // Change button text to Update
            submitBtn.innerText = 'Update';

            // Show cancel button
            cancelBtn.style.display = 'inline-block';

            // Scroll to top to focus on the form
            window.scrollTo({ top: 0, behavior: 'smooth' });
            textarea.focus();
        }

        function cancelEdit() {
            const textarea = document.getElementById('chat-textarea');
            const form = document.getElementById('talk-form');
            const submitBtn = document.getElementById('submit-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const talkIdInput = document.getElementById('talk_id');

            // Clear textarea
            textarea.value = '';

            // Reset form action to store route
            form.action = '{{ route("talks.store") }}';

            // Reset method to POST
            document.querySelector('input[name="_method"]').value = 'POST';

            // Clear talk ID
            talkIdInput.value = '';

            // Change button text back to Talk
            submitBtn.innerText = 'Talk';

            // Hide cancel button
            cancelBtn.style.display = 'none';
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('current_password');
                const icon = this.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });

            document.getElementById('toggleNewPassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('new_password');
                const icon = this.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });

            document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('password_confirmation');
                const icon = this.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    </script>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-4 fs-md-3" href="{{ route('home') }}">Talks</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @ {{ Auth::user()->username }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</button></li>
                                <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('user.delete') }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item btn btn-danger text-white rounded-pill" style="background-color: #dc3545 !important; width: 90%; margin-left: 10px;" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">Delete Account</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
            </br>
                @auth
                <!-- Post Input Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3 p-md-4">
                        <form method="POST" action="{{ route('talks.store') }}" id="talk-form">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="talk_id" id="talk_id">
                            <div class="d-flex align-items-start">
                                <div class="avatar-placeholder bg-primary bg-opacity-10 rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-primary fw-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <textarea name="chat" id="chat-textarea" class="form-control border-0 fs-6 fs-md-5 mb-3" rows="3" placeholder="What's happening?" style="resize: none;" required></textarea>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="submit" id="submit-btn" class="btn btn-primary px-4 py-2 fw-bold rounded-pill">Talk</button>
                                        <button type="button" id="cancel-btn" class="btn btn-secondary px-4 py-2 fw-bold rounded-pill" style="display: none;" onclick="cancelEdit()">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endauth

                <!-- Recent Talks -->
                <div class="mb-4">
                    <h3 class="h5 text-muted mb-4">Recent Talks</h3>
                    @forelse($talks as $talk)
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-3 p-md-4">
                                <div class="d-flex">
                                    <div class="avatar-placeholder bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <span class="text-primary fw-bold">{{ substr($talk->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="fw-bold me-1">{{ $talk->user->name }}</span>
                                            <span class="text-muted">@ {{ $talk->user->username }}  ·  {{ $talk->updated_at->diffForHumans() }}</span>
                                            @if($talk->created_at != $talk->updated_at)
                                                <span class="badge bg-secondary ms-2">edited</span>
                                            @endif
                                            @if(Auth::check() && $talk->user_id == Auth::id())
                                                <div class="dropdown ms-auto">
                                                    <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                                        </svg>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><button class="dropdown-item" onclick="startEdit({{ $talk->id }})">Edit</button></li>
                                                        <li><form method="POST" action="{{ route('talks.destroy', $talk) }}" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form></li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <p id="talk-content-{{ $talk->id }}" class="mb-3">{{ $talk->chat }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No talks yet. Be the first to share your thoughts!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    @auth
    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="profileForm" method="POST" action="{{ route('user.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="avatar-placeholder bg-primary bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-primary fw-bold fs-2" id="avatarLetter">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <h4 id="displayName">{{ Auth::user()->name }}</h4>
                            <p class="text-muted" id="displayUsername">@ {{ Auth::user()->username }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label"><strong>Name</strong></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label"><strong>Username</strong></label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" id="username" name="username" value="{{ Auth::user()->username }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><strong>Email</strong></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Member Since:</strong>
                            </div>
                            <div class="col-sm-6">
                                {{ Auth::user()->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.changePassword') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="current_password" class="form-label"><strong>Current Password</strong></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><strong>New Password</strong></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label"><strong>Confirm New Password</strong></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <!-- Footer -->
    <footer class="py-4 bg-dark text-light w-100 position-fixed bottom-0">
        <div class="container text-center">
            <p class="mb-0">&copy;{{ date('Y') }} Talks. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
