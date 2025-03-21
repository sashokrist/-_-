@extends('layouts.app')

@section('content')
    <h3>Редактирай резервация</h3>

    <form method="POST" action="{{ route('bookings.update', $booking->id) }}">
        @csrf
        @method('PUT')

        @php
            // Determine selected business type
            $selectedType = $booking->doctor_id ? 'doctor' : ($booking->hairstylist_id ? 'hair_salon' : ($booking->table_id ? 'restaurant' : ''));
        @endphp

            <!-- Hidden fields for unified processing -->
        <input type="hidden" name="provider_type" value="{{ $selectedType }}">
        <input type="hidden" name="business_id" value="{{ $booking->business_id }}">

        <!-- Business Type Display -->
        <div class="mb-3">
            <label>Тип бизнес</label>
            <input type="text" class="form-control" value="@switch($selectedType)
                @case('doctor') Доктор @break
                @case('hair_salon') Фризьорски салон @break
                @case('restaurant') Ресторант @break
                @default Неизвестен
            @endswitch" disabled>
        </div>

        <!-- Service Provider (Unified) -->
        <div class="mb-3">
            <label>Услуга</label>
            <select name="service_provider_id" class="form-control" required>
                <option value="">Изберете</option>

                @if($selectedType === 'doctor')
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ $booking->doctor_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                @elseif($selectedType === 'hair_salon')
                    @foreach($hairstylists as $stylist)
                        <option value="{{ $stylist->id }}" {{ $booking->hairstylist_id == $stylist->id ? 'selected' : '' }}>
                            {{ $stylist->name }} ({{ $stylist->specialization }})
                        </option>
                    @endforeach
                @elseif($selectedType === 'restaurant')
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}" {{ $booking->table_id == $table->id ? 'selected' : '' }}>
                            Маса №{{ $table->number }} ({{ $table->seats }} места)
                        </option>
                    @endforeach
                @endif
            </select>
            @error('service_provider_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Date and Time -->
        <div class="mb-3">
            <label>Дата и час</label>
            <input type="datetime-local" name="date_time" class="form-control"
                   value="{{ old('date_time', $booking->date_time->format('Y-m-d\TH:i')) }}" required>
            @error('date_time')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Client Name -->
        <div class="mb-3">
            <label>Име на клиента</label>
            <input type="text" name="client_name" class="form-control"
                   value="{{ old('client_name', $booking->client_name) }}" readonly>
        </div>

        <!-- Personal ID -->
        <div class="mb-3">
            <label>ЕГН</label>
            <input type="text" name="personal_id" class="form-control"
                   value="{{ old('personal_id', $booking->personal_id) }}" required>
            @error('personal_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Описание</label>
            <textarea name="description" class="form-control">{{ old('description', $booking->description) }}</textarea>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Notification Method -->
        <div class="mb-3">
            <label>Метод за нотификация</label>
            <select name="notification_method" class="form-control">
                <option value="SMS" {{ old('notification_method', $booking->notification_method) == 'SMS' ? 'selected' : '' }}>SMS</option>
                <option value="Email" {{ old('notification_method', $booking->notification_method) == 'Email' ? 'selected' : '' }}>Email</option>
            </select>
            @error('notification_method')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Редактирай</button>
    </form>
@endsection
