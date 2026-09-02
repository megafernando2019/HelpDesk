<div class="mb-3">
    <select class="form-control select2-assignees"
            name="assign"
            style="width: 100%;">

        @if ($currentUserAssing === 0)
            <option selected>
                Seleccionar encargados de soporte...
            </option>
        @endif

        @foreach($supportUsers as $user)
            <option value="{{ $user->id }}" 
                    data-email="{{ $user?->email }}" 
                    data-initials="{{ $user?->initials }}"
                    data-name="{{ $user?->first_name ?? '' }}  {{ $user?->last_name ?? '' }}"
                    {{ $user?->id === $currentUserAssing ? 'selected' : '' }}>
                    {{ $user?->first_name }} {{ $user?->last_name }} ({{ $user?->email }})
            </option>
        @endforeach
    </select>
</div>