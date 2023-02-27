<!-- Modal -->
<div class="modal fade" id="tansferInventory" tabindex="-1" aria-labelledby="tansferInventoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tansferInventoryLabel">Tansfer Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{route('transfer.inventory')}}" id="transferInventoryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="tansferID" name="transferID" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="date_delivered">Date Deliver</label>
                        <input type="date" class="form-control" name="date_delivered" id="date_delivered">
                        <span class="text-danger error-text date_delivered_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="out_delivered">Out Delivered</label>
                        <input type="number" class="form-control" name="out_delivered" id="out_delivered">
                        <span class="text-danger error-text out_delivered_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>