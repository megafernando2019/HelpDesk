<div class="mb-3">
    <select class="form-control select2-assignees" name="assignees[]" multiple="multiple" style="width: 100%;">
        
        @foreach($supportUsers as $user)
            <option value="{{ $user->id }}" 
                    data-email="{{ $user?->email }}" 
                    data-initials="{{ $user?->initials }}"
                    data-name="{{ $user?->first_name ?? '' }}  {{ $user?->last_name ?? '' }}"
                    {{ in_array($user?->id, $assignedUserIds ?? []) ? 'selected' : '' }}>
                    {{ $user?->first_name }} {{ $user?->last_name }} ({{ $user?->email }})
            </option>
        @endforeach
    </select>
</div>