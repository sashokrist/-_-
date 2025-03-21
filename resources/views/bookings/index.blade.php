@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <h4 class="mb-3">Създай резервация</h4>
        @foreach($businesses as $biz)
            <a href="{{ route('bookings.create', $biz->id) }}" class="btn btn-primary mb-2">
                Създай резервация за {{ $biz->name }} ({{ $biz->businessType->name }})
            </a>
        @endforeach
    @else
        <a href="#" onclick="showWarning()" class="btn btn-primary mb-3">Запиши нов час</a>
    @endif

    <script>
        function showWarning() {
            alert('Моля, влезте в профила си, за да запазите час.');
        }
    </script>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('bookings.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Тип на бизнеса:</label>
                <select name="business_type_id" class="form-control">
                    <option value="">Всички</option>
                    @foreach($businessTypes as $type)
                        <option value="{{ $type->id }}" {{ request('business_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Бизнес:</label>
                <select name="business_id" class="form-control">
                    <option value="">Всички</option>
                    @foreach($businesses as $business)
                        <option value="{{ $business->id }}" {{ request('business_id') == $business->id ? 'selected' : '' }}>
                            {{ $business->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>От:</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2">
                <label>До:</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2">
                <label>ЕГН</label>
                <input type="text" name="personal_id" class="form-control" value="{{ request('personal_id') }}" placeholder="Въведи ЕГН">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-info w-100">Филтър</button>
            </div>
        </div>
    </form>

    <!-- Booking Table -->
    <table class="table table-bordered table-hover">
        <thead class="table-light">
        <tr>
            <th>Дата и час</th>
            <th>Клиент</th>
            <th>ЕГН</th>
            <th>Бизнес</th>
            <th>Услуга</th>
            <th>Метод за нотификация</th>
            <th>Опции</th>
        </tr>
        </thead>
        <tbody>
        @forelse($bookings as $booking)
            <tr>
                <td>{{ $booking->date_time }}</td>
                <td>{{ $booking->client_name }}</td>
                <td>{{ $booking->personal_id }}</td>
                <td>{{ $booking->business->name ?? 'N/A' }}</td>
                <td>
                    @php
                        $type = $booking->business->businessType->name ?? null;
                    @endphp

                    @if($type === 'Doctor')
                        {{ $booking->doctor->name ?? 'N/A' }}
                    @elseif($type === 'Hair Salon')
                        {{ $booking->hairstylist->name ?? 'N/A' }}
                    @elseif($type === 'Restaurant')
                        {{ $booking->table ? 'Маса №' . $booking->table->number : 'N/A' }}
                    @else
                        {{ $booking->description ?? 'N/A' }}
                    @endif
                </td>
                <td>{{ $booking->notification_method }}</td>
                <td>
                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-success btn-sm">Детайли</a>

                    @if(auth()->id() === $booking->user_id)
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning btn-sm">Редактирай</a>
                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Сигурен ли си?')">Изтрий</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Няма намерени записи.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $bookings->links('pagination::bootstrap-4') }}
@endsection
