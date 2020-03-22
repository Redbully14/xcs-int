@if(Auth::user()->level() >= $constants['access_level']['admin'])
<!-- Adding a Member - Modal -->
<div class="modal fade" id="memberAddModal" tabindex="-1" role="dialog" aria-labelledby="memberAddModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="memberAddModalLabel">Adding a Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="ajax_add_member">
          <div class="modal-body">

            <div class="form-group">
              <label>Name</label><sup class="text-danger">*</sup>
              <input type="text" class="form-control p_input" require id="name" name="name" placeholder="John D." autocomplete="off" autofocus>
              <label id="add-name-error" class="error mt-2 text-danger" for="name" hidden></label>
            </div>

            <div class="form-group">
              <label>Username</label><sup class="text-danger">*</sup>
              <div class="input-group" data-target-input="nearest">
                <input type="text" class="form-control p_input" require id="username" name="username" placeholder="sahpjohnd" autocomplete="off" >
                <div class="input-group-append">
                  <button class="btn btn-sm btn-secondary" type="button" id="add_generate_username"><i class="mdi mdi-reload"></i></button>
                </div>
              </div>
              <label id="add-username-error" class="error mt-2 text-danger" for="username" hidden></label>
            </div>

            <div class="form-group">
              <label>Temporary Password</label><sup class="text-danger">*</sup>
              <div class="input-group" data-target-input="nearest">
                <input type="password" class="form-control p_input" require id="password" name="password" autocomplete="off" placeholder="********">
                <div class="input-group-append">
                  <button class="btn btn-sm btn-secondary" type="button" id="add_generate_password"><i class="mdi mdi-reload"></i></button>
                </div>
              </div>
              <label id="add-password-error" class="error mt-2 text-danger" for="password" hidden></label>
            </div>

            <div class="form-group">
              <label>{{ $constants['department']['department_callsign'] }}</label>
              <input type="text" class="form-control p_input" require id="department_id" name="department_id" placeholder="5D or 5S-123">
              <label id="add-department_id-error" class="error mt-2 text-danger" for="department_id" hidden></label>
            </div>

            <div class="form-group">
              <label>Website ID</label><sup class="text-danger">*</sup>
              <input type="text" class="form-control p_input" require id="website_id" name="website_id" placeholder="519" autocomplete="off">
              <label id="add-website_id-error" class="error mt-2 text-danger" for="website_id" hidden></label>
            </div>

            <div class="form-group">
              <label>Antelope Permission Level</label>
              <select class="js-example-basic-single" style="width:100%" id="role" name="role">
                @foreach($constants['role'] as $item => $value)
                  @if (!$loop->first)
                  <option value="{{ $item }}" {{ $item == 'member' ? ' selected' : '' }}>{{ $value }}</option>
                  @endif
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Rank</label>
              <select class="js-example-basic-single" style="width:100%" id="rank" name="rank">
                @foreach($constants['rank'] as $rank => $value)
                  <option value="{{ $rank }}" {{ $rank == 'probationary' ? ' selected' : '' }}>{{ $value }}</option>
                @endforeach
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="add_member_clipboard">From Clipboard</button>
            <button type="submit" class="btn btn-success">Add</button>
            <button type="button" class="btn btn-light" data-dismiss="modal" id="cancelAddMember">Cancel</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
 var $url_clipboard_url = '{{ url('member_admin/clipboard') }}';
 var $url_add_member_modal = '{{ url('member_admin/new') }}';
 var $url_generate_username = '{{ url('admin/getusername') }}';
 var $url_generate_password = '{{ url('admin/getpassword') }}';
 var $base_url = '{{ url('/') }}'
</script>
<script src="/js/modals/add_member_action_modal.js"></script>
@endif