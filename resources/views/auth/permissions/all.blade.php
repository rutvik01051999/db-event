@foreach ($permissions as $collection => $perms)
    <h3>{{ Str::ucfirst($collection) }}</h3>
    <div class="d-flex justify-content-start align-items-center gap-3">
        @foreach ($perms as $permission)
            {{-- Show checkboxes --}}
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                        id="{{ $permission->name }}" @checked(in_array($permission->id, $userPermissions))>
                    <label class="form-check-label cursor-pointer" for="{{ $permission->name }}">
                        {{ Str::title($permission->name) }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
