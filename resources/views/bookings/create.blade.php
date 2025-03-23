@extends('layouts.app')

@section('content')
    <h3>Запиши нов час</h3>

    <form method="POST" action="{{ route('bookings.store') }}">
        @csrf

        <div class="mb-3">
            <label>Бизнес</label>
            <select id="business_id" name="business_id" class="form-control" required>
                <option value="{{ $business->id }}" selected>{{ $business->name }}</option>
            </select>
            @error('business_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <input type="hidden" name="provider_type" value="{{ strtolower(str_replace(' ', '_', $business->businessType->name)) }}">

        <div class="mb-3">
            <label>Услуга (Лекар, Фризьор или Маса)</label>
            <select name="service_provider_id" class="form-control" required>
                <option value="">Изберете услуга</option>

                @isset($doctors)
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                    @endforeach
                @endisset

                @isset($hairstylists)
                    @foreach($hairstylists as $stylist)
                        <option value="{{ $stylist->id }}">{{ $stylist->name }} ({{ $stylist->specialization }})</option>
                    @endforeach
                @endisset

                @isset($tables)
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">Маса №{{ $table->number }} ({{ $table->seats }} места)</option>
                    @endforeach
                @endisset
            </select>
        </div>

        <div class="mb-3">
            <label>Дата и час</label>
            <input type="datetime-local" name="date_time" class="form-control" value="{{ old('date_time') }}" required>
            @error('date_time')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Клиент</label>
            <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $userName) }}" readonly>
            @error('client_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>ЕГН</label>
            <input type="text" name="personal_id" class="form-control" value="{{ old('personal_id') }}" required>
            @error('personal_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Описание (незадължително)</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Метод за нотификация</label>
            <select name="notification_method" class="form-control">
                <option value="SMS" {{ old('notification_method') == 'SMS' ? 'selected' : '' }}>SMS</option>
                <option value="Email" {{ old('notification_method') == 'Email' ? 'selected' : '' }}>Email</option>
            </select>
            @error('notification_method')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Запиши</button>
    </form>

    <script>
        document.getElementById('business_id').addEventListener('change', function () {
            const businessId = this.value;
            const providerSelect = document.getElementById('service_provider_id');
            const providerType = document.getElementById('provider_type');

            providerSelect.innerHTML = '<option value="">Зареждане...</option>';
            providerSelect.disabled = true;
            providerType.value = '';

            if (businessId) {
                fetch(`/api/service-providers?business_id=${businessId}`)
                    .then(res => res.json())
                    .then(data => {
                        providerType.value = data.type;
                        providerSelect.innerHTML = '<option value="">Изберете услуга</option>';
                        data.data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.text = item.name + (item.specialization ? ` (${item.specialization})` : '');
                            providerSelect.appendChild(option);
                        });
                        providerSelect.disabled = false;
                    })
                    .catch(error => {
                        providerSelect.innerHTML = '<option value="">Грешка при зареждане</option>';
                        console.error('Fetch error:', error);
                    });
            } else {
                providerSelect.innerHTML = '<option value="">Първо изберете бизнес</option>';
                providerSelect.disabled = true;
            }
        });
    </script>
@endsection
