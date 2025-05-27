@extends('layouts.app')

@section('content')
    <div class="container mt-4" style="max-width: 600px;">
        <h3 class="mb-4 text-center">Paramètres du profil</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm p-4">
            <form method="POST" action="{{ route('profile.settings.update') }}" enctype="multipart/form-data">
                @csrf

                {{-- Avatar --}}
                <div class="mb-4 text-center">
                    <img id="avatarPreview"
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                         class="rounded-circle mb-2"
                         style="width: 100px; height: 100px; object-fit: cover;"
                         alt="Avatar Preview">
                    <div>
                    <label for="avatarInput" class="btn btn-outline-primary btn-sm">Choisir un fichier</label>
                    <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*">
                    </div>
                    @error('avatar') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Nouveau mot de passe (optionnel)</label>
                    <input type="password" name="password" class="form-control">
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('avatarInput').addEventListener('change', function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endsection
