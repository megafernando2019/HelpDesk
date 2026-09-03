@if ($currentUserAssing)
    @inject('getInitials', 'App\Helpers\GetInitials')

    @php
        $nameCurrentUserAssigned = null;
        $userAssingInitial = '';
        $foundUser = false;

        if (!empty($supportUsers)) {
            foreach ($supportUsers as $key => $value) {
                $userId = (int) $value?->id ?? 0;

                if ($userId === $currentUserAssing) {
                    
                    $nameCurrentUserAssigned = sprintf(
                        '%s %s',
                         $value?->first_name ?? '',
                         $value?->last_name ?? '',
                    );
                    
                    $foundUser = true;
                }
            }
        }

    @endphp

    <div style="border: 1px solid #eee; background:#fafafa;" class="p-3 current-rounded">
        <div class="d-flex gap-2 align-items-center">
            <div class="minimalist-avatar">
                <div class="bg-avatar">
                    <span style="
                        background-color: #fa995c; 
                        color: #fff !important;
                        padding: .5em;
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        font-weight: bold;
                        text-align: center;" class="profile-acount-initials">
                        {{$foundUser ? $getInitials($nameCurrentUserAssigned) : ''}}
                    </span>
                </div>
            </div>
            <div class="info-user-auth-heldesk">
                    <p class="p-0 m-0">
                        {{$nameCurrentUserAssigned}}
                    </p>
                    
            </div>
        </div>
    </div>
@else 
    <div style="border: 1px solid #eee; background:#fafafa;" class="p-2 current-rounded">
        <div class="d-flex gap-2 align-items-center">
            <div class="minimalist-avatar">
                <div class="bg-avatar">
                    <span style="
                        background-color: #e5e9eb; 
                        color: #e5e9eb !important;
                        padding: .5em;
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        font-weight: bold;
                        text-align: center;" class="profile-acount-initials">
                        NA
                    </span>
                </div>
            </div>
            <div class="info-user-auth-heldesk">
                    <p class="p-0 m-0">
                        Sin usuario asignado
                    </p>
                    <small class="text-muted">Asignar</small>
            </div>
        </div>
    </div>
@endif