@extends('layouts.layout')

@section('title', __('profile.addresses_title') . ' — Double Helix')

@section('content')

<section style="padding: 80px 0 120px; background: #F7F7F7; min-height: 70vh;">
    <div class="container" style="max-width: 860px;">

        <span class="dh-label">{{ __('orders.label') }}</span>
        <h1 class="dh-section-title mb-5">{{ __('profile.addresses_title') }}</h1>

        {{-- Añadir nueva dirección --}}
        <div style="background: #fff; padding: 36px; margin-bottom: 32px;">
            <h5 class="mb-4" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                {{ __('profile.new_address') }}
            </h5>
            <form method="POST" action="{{ route('profile.addresses.store') }}" class="row g-3">
                @csrf
                <div class="col-12">
                    <input class="form-control" name="street" placeholder="{{ __('profile.field_street') }}" required>
                </div>
                <div class="col-md-6">
                    <input class="form-control" name="city" placeholder="{{ __('profile.field_city') }}" required>
                </div>
                <div class="col-md-6">
                    <input class="form-control" name="province" placeholder="{{ __('profile.field_province') }}" required>
                </div>
                <div class="col-md-4">
                    <input class="form-control" name="postal_code" placeholder="{{ __('profile.field_postal') }}" required>
                </div>
                <div class="col-md-4">
                    <input class="form-control" name="country" placeholder="{{ __('profile.field_country') }}" required>
                </div>
                <div class="col-md-4">
                    <input class="form-control" name="phone" placeholder="{{ __('profile.field_phone') }}" required>
                </div>
                <div class="col-12 d-flex align-items-center gap-4">
                    <label class="d-flex align-items-center gap-2" style="font-size: 0.88rem; color: var(--dh-text); cursor: pointer;">
                        <input type="checkbox" name="is_default" value="1">
                        {{ __('profile.field_default') }}
                    </label>
                    <button class="btn btn-dh" type="submit" style="padding: 10px 28px; font-size: 0.88rem;">
                        {{ __('profile.save_address') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Direcciones existentes --}}
        @foreach ($addresses as $address)
            <div style="background: #fff; padding: 36px; margin-bottom: 24px;">
                <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
                    <div>
                        <p class="mb-1" style="font-size: 0.95rem; font-weight: 600; color: var(--dh-text);">
                            {{ $address->street }}, {{ $address->city }}
                        </p>
                        <p class="mb-0" style="font-size: 0.85rem; color: var(--dh-muted);">
                            {{ $address->province }} · {{ $address->postal_code }} · {{ $address->country }}<br>
                            Tel. {{ $address->phone }}
                        </p>
                    </div>
                    @if ($address->is_default)
                        <span class="badge"
                              style="background: var(--dh-primary-light, #FBE9F2); color: var(--dh-primary); font-weight: 500; font-size: 0.72rem; border-radius: 2px; white-space: nowrap; padding: 5px 10px;">
                            {{ __('profile.badge_default') }}
                        </span>
                    @endif
                </div>

                <form method="POST" action="{{ route('profile.addresses.update', $address->id) }}" class="row g-3 mb-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <input class="form-control" name="street" value="{{ $address->street }}" required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" name="city" value="{{ $address->city }}" required>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" name="province" value="{{ $address->province }}" required>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" name="postal_code" value="{{ $address->postal_code }}" required>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" name="country" value="{{ $address->country }}" required>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" name="phone" value="{{ $address->phone }}" required>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <label class="d-flex align-items-center gap-2" style="font-size: 0.88rem; color: var(--dh-text); cursor: pointer;">
                            <input type="checkbox" name="is_default" value="1" @checked($address->is_default)>
                            {{ __('profile.field_default') }}
                        </label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-dh" type="submit" style="padding: 8px 20px; font-size: 0.85rem;">
                                {{ __('profile.update_address') }}
                            </button>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('profile.addresses.destroy', $address->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm"
                            style="border: 1px solid #fee2e2; color: #dc2626; border-radius: 2px; background: transparent; padding: 6px 16px; font-size: 0.82rem;"
                            type="submit">
                        {{ __('profile.delete_address') }}
                    </button>
                </form>
            </div>
        @endforeach

        {{-- Cambiar idioma --}}
        <div style="background: #fff; padding: 36px; margin-top: 32px;">
            <h5 class="mb-4" style="font-weight: 600; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 1px; color: var(--dh-text);">
                {{ __('profile.language_title') }}
            </h5>
            <form action="{{ route('profile.language.update') }}" method="POST" class="d-flex gap-3 align-items-center">
                @csrf
                <select class="form-select" name="language" style="max-width: 200px; font-size: 0.88rem;">
                    <option value="es" @selected(app()->getLocale() === 'es')>{{ __('profile.language_es') }}</option>
                    <option value="en" @selected(app()->getLocale() === 'en')>{{ __('profile.language_en') }}</option>
                </select>
                <button class="btn btn-dh" type="submit" style="padding: 10px 24px; font-size: 0.88rem;">
                    {{ __('profile.language_update') }}
                </button>
            </form>
        </div>

    </div>
</section>

@endsection
