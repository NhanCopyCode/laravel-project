<header class="section__container header__container">
  <div class="header__image__container">
    <div class="header__content">
      <h1>Thưởng thức kì nghỉ của bạn</h1>
      <p>Đặt xe uy tín và chất lượng rẻ nhất</p>
    </div>
    <div class="booking__container">
    <form method="GET" action="{{route('user.search_vehicle')}}" id="form_search_vehicle">
        <div class="form__group">
          <select class="form-control background-transparent" name="location_id" id="location_client" >
              @foreach ($location_list as $location)
                <option value="{{$location->location_id}}" {{ request()->get('location_id') == $location->location_id ? 'selected' : '' }}>
                    {{$location->province}}
                </option>
              @endforeach
          </select>
          <p>Chọn nơi muốn thuê</p>
          @error('location_id')
              <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form__group">
          <input class="form-control" required  type="text" id="search_vehicle_daterange" name="search_vehicle_daterange" value="{{ request()->search_vehicle_daterange}}"/>
          @error('search_vehicle_daterange')
              <span class="text-danger">{{$message}}</span>
          @enderror
          <p>Chọn ngày muốn thuê</p>

        </div>
        
        <button type="submit" name="form_search_vehicle_available" class="btn">
            <ion-icon name="search-outline"></ion-icon>
        </button>
      </form>
    </div>
  </div>
</header>
<script>
   $(function() {
       
        $('input[name="search_vehicle_daterange"]').daterangepicker(
            {
                opens: 'left',
                minDate: new Date(),
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, 
            function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>