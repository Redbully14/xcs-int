$(function() {
  $('#tableElement').DataTable({
   ordering: false,
   serverSide: true,
   ajax: baseURL + '/member_admin/get_users',
   columns: [
    { data: 'id', name: 'id', searchable: true },
    { data: 'name', name: 'name', searchable: true },
    { data: 'username', name: 'username', searchable: true },
    { data: 'website_id', name: 'website_id', searchable: true },
    // the fucking part below was made thanks to stackoverflow
    // fucking <th>
    // MAN FUCK PHP->JSON CONVESION, I JUST SPENT ONE FUCKING HOUR CAUSE I HAD TO LITTERALLY DEFINE THE FACT THAT ROLES HAS TWO TREE ARRAYS FUCK THAT SHIT
    { data: 'roles[0].slug', name: 'role', searchable: false, render: function (data, type, row) {
      console.log(data);
        try {
           if($constants_access[data] == null) throw "Antelope Developer"; 
           else return $constants_access[data];
        } 
        catch(e) {
          return e;
        } 
      } 
    },
    { data: 'antelope_status', searchable: false, name: 'antelope_status', render: function (data, type, row) {
        return '<div class="badge badge-outline-'+$constants_status_color[data]+' badge-pill">'+$constants_status_text[data]+'</div>';
      } 
    },
    // dude wtf is going on
    { data: 'id', searchable: false, render: function(data, type, row) { return '<button class="btn btn-outline-primary" id="ajax_open_modal_edit" value="'+data+'"><i class="mdi mdi-lead-pencil"></i> Edit</button>'; } },
   ]
  });
});