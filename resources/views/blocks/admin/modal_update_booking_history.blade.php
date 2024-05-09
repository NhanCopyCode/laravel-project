 <!--Update payment Modal -->
 <form method="POST" action="{{ route('admin.booking.vehicle.update') }}" class="modal fade modal-payment" id="form_update_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    @csrf
    <input type="hidden" id="update_payment_id">
    <input type="hidden" id="booking_history_rental_id">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Cập nhật trạng thái thanh toán</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            

            <div class="form-group">
                <label for="payment_status">Trạng thái thanh toán</label>
                <select class="form-control" name="rental_status_id" id="update_payment_status">
                    
                    @foreach ($rental_status_list as $key => $status)
                        <option  
                            value="{{$status->rental_status_id}}"
                        >{{$status->rental_status_name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="admin_payment_is_deleted">Trạng thái thanh toán</label>
                <select class="form-control" name="is_deleted" id="admin_payment_is_deleted">
                    
                    @foreach ($is_deleted_list as $value)
                    
                        @if ($value === 0)
                            <option value="{{$value}}">Còn hiệu lực</option>
                        @elseif($value === 1)
                            <option value="{{$value}}" >Hết hiệu lực</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-submit-update-payment">Cập nhật</button>
        </div>
    </div>
    </div>
</form>