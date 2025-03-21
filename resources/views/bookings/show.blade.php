@extends('layouts.app')

@section('content')
    <h3>Детайли за резервацията</h3>

    <p><strong>Бизнес:</strong> {{ $booking->business->name ?? 'N/A' }}</p>
    <p><strong>Тип:</strong> {{ $booking->business->businessType->name ?? 'N/A' }}</p>
    <p><strong>Дата и час:</strong> {{ $booking->date_time }}</p>
    <p><strong>Клиент:</strong> {{ $booking->client_name }}</p>
    <p><strong>ЕГН:</strong> {{ $booking->personal_id }}</p>

    <!-- Show specific service -->
    @php
        $type = $booking->business->businessType->name ?? null;
    @endphp

    @if($type === 'Doctor' && $booking->doctor)
        <p><strong>Доктор:</strong> {{ $booking->doctor->name }}</p>
    @elseif($type === 'Hair Salon' && $booking->hairstylist)
        <p><strong>Фризьор:</strong> {{ $booking->hairstylist->name }}</p>
    @elseif($type === 'Restaurant' && $booking->table)
        <p><strong>Маса:</strong> №{{ $booking->table->number }} ({{ $booking->table->seats }} места)</p>
    @endif

    <p><strong>Описание:</strong> {{ $booking->description ?? 'N/A' }}</p>
    <p><strong>Метод за нотификация:</strong> {{ $booking->notification_method }}</p>

    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Обратно</a>

    @if(isset($upcomingBookings) && $upcomingBookings->count())
        <h4 class="mt-4">Предстоящи часове за {{ $booking->client_name }}</h4>
        <ul>
            @foreach($upcomingBookings as $upcoming)
                <li>{{ $upcoming->date_time }} —
                    <a href="{{ route('bookings.show', $upcoming) }}">Детайли</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
