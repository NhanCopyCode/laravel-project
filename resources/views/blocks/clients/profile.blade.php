<form action="{{route('user.update.profile', $user->user_id)}}" method="POST" enctype="multipart/form-data" class="section__container border rounded p-8 mb-4" id="form_update_profile_user">
  @csrf
  <h2 class="text-center fw-bold">Cập nhật hồ sơ</h2>
  </div>
    <div class="form-row row">
        <div class="col-md-4">  
            <div class="card" style="max-height: 300px;min-height: 200px;">
                <img style="object-fit: cover;" src="{{$user->avatar}}" id="user_avatar" class="card-img-top" alt="Ảnh đại diện">
                
            </div>
            <div class="form-group">
              <div class="mb-3">
                <label for="avatar" class="form-label">Cập nhật ảnh đại diện</label>
                <input class="form-control" type="file" id="avatar" name="avatar">
                @error('avatar')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
        </div>
    </div>
    <div class="form-row row">

      {{-- User name / Email --}}
      <div class="form-group col-md-6">
        <label for="name" >Tên người dùng</label>
        <input type="text" class="form-control" name="name" id="name" value="{{$user->name ? : old('name')}}" placeholder="Nhập tên người dùng">
        @error('name')
            <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-md-6">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" id="email" value="{{$user->email ?: old('email')}}" placeholder="VD: abc@gmail.com">
          @error('email')
            <span class="text-danger">{{$message}}</span>
          @enderror
      </div>
    </div>

    {{-- Số điện thoại /  --}}
    <div class="form-row row">
      <div class="form-group col-md-6">
        <label for="phone_number" >Số điện thoại</label>
        <input type="number" class="form-control" name="phone_number" id="phone_number" value="{{$user->phone_number ? : old('phone_number')}}" placeholder="VD: 0919094701">
        @error('phone_number')
          <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-md-6">
          <label for="CCCD">Số CCCD (Phải nhập đủ 12 số)</label>
          <input type="number" class="form-control" id="CCCD" name="CCCD" value="{{$user->CCCD ?: old('CCCD')}}" placeholder="Nhập CCCD...">
          @error('CCCD')
            <span class="text-danger">{{$message}}</span>
          @enderror
      </div>
    </div>

    {{-- Số điện thoại / Căn cước công dân --}}

    <div class="form-row row">
      @php
          // Assuming $user->date_of_birth is in the format 'Y-m-d H:i:s'
          $date_of_birth = \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d');

      @endphp
      <div class="form-group col-md-6">
          <label for="date_of_birth">Nhập ngày sinh</label>
          <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{$date_of_birth ?: old('date_of_birth')}}" placeholder="Nhập CCCD...">
          @error('date_of_birth')
            <span class="text-danger">{{$message}}</span>
          @enderror
      </div>
    </div>
    
    <button class="btn btn-primary" id="button_submit_update_profile" type="submit">Cập nhật hồ sơ</button>
</form>

@if(session('success'))
    <script>
        Swal.fire({
              title: '{{ session('success') }}',
              icon: 'success',

              showCancelButton: false,
              confirmButtonText: 'OK',
            });
    </script>
@endif

@if (session('msg--need-profile-user'))
    <script>
      Swal.fire({
              title: '{{ session('msg--need-profile-user') }}',
              icon: 'warning',
              showCancelButton: false,
              confirmButtonText: 'OK',
            });
    </script>
@endif

<script>
     $(document).ready(function() {
          $('#avatar').change(function() {
              const file = this.files[0];
              if (file) {
                  const reader = new FileReader();
                  reader.onload = function(e) {
                      $('#user_avatar').attr('src', e.target.result);
                  }
                  reader.readAsDataURL(file);
              }
          });
      });
</script>