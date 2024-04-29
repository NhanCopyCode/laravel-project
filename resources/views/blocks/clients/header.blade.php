<header class="section__container header__container">
  <div class="header__image__container">
    <div class="header__content">
      <h1>Thưởng thức kì nghỉ của bạn</h1>
      <p>Đặt xe uy tín và chất lượng rẻ nhất</p>
    </div>
    <div class="booking__container">
      <form method="GET" action="{{route('user.search_vehicle')}}">
        <div class="form__group">
          <select class="form-control background-transparent" name="location_id" id="location_client" value="{{ request()->location_id}}">
              @foreach ($location_list as $location)
                  <option value="{{$location->location_id}}">{{$location->province}}</option>
              @endforeach
          </select>
          <p>Chọn nơi muốn thuê</p>
          @error('location_id')
              <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form__group">
          <input class="form-control background-transparent" type="date" id="start-date" name="start_date" value="{{ request()->start_date}}">
          <p>Ngày bắt đầu</p>
          @error('start_date')
              <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form__group">
          <input class="form-control background-transparent" type="date" id="end-date" name="end_date" value="{{ request()->end_date}}">
          <p>Ngày kết thúc</p>
          @error('end_date')
              <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <button type="submit" class="btn"><i class="ri-search-line"></i></button>
      </form>
    </div>
  </div>
</header>