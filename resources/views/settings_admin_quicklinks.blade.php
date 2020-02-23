@foreach($quicklinks as $quicklink)
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label for="admin_manage_quicklink-type-{{ $quicklink['id'] }}">Type</label>
                <select class="antelope_global_select_single-noclear-nosearch" style="width:100%" id="admin_manage_quicklink-type-{{ $quicklink['id'] }}" required>
                    @foreach($constants['quicklink_types'] as $item => $value)
                        <option value="{{ $item }}" {{ $item == $quicklink[0] ? ' selected' : '' }}>{{ $value['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="admin_manage_quicklink-title-{{ $quicklink['id'] }}">Quicklink Title</label>
                <input type="text" class="form-control" id="admin_manage_quicklink-title-{{ $quicklink['id'] }}" autocomplete="off" required value="{{ $quicklink[1] }}">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="admin_manage_quicklink-link-{{ $quicklink['id'] }}">Link</label>
                <input type="url" class="form-control" id="admin_manage_quicklink-link-{{ $quicklink['id'] }}" autocomplete="off" value="{{ $quicklink[2] }}" required>
            </div>
        </div>
    </div>
@endforeach
