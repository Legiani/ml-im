<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Přidaní udalosi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="data">
        <form action="" method="POST" id="addForm">
          <div class="control-group d-inline">
            <div data-toggle="buttons" class="d-inline">    
              <label class="btn btn-warning">
                <input type="radio" name="action" value="reser" checked> Vyhrazeno k výuce
              </label>
            </div>
            <div data-toggle="buttons" class="d-inline">    
              <label class="btn btn-danger">
                <input type="radio" name="action" value="teach"> Hodina
              </label>
            </div>
          </div>


          <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <div class="input-group date" id="timeFrom" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" data-target="#timeFrom" name="timeFrom"/>
                          <div class="input-group-append" data-target="#timeFrom" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6">
                  <div class="form-group">
                      <div class="input-group date" id="timeTo" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" data-target="#timeTo" name="timeTo"/>
                          <div class="input-group-append" data-target="#timeTo" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        

          <div class="form-group">
              <div class="input-group date" id="dateDay" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" data-target="#dateDay" name="date"/>
                  <div class="input-group-append" data-target="#dateDay" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
              </div>
          </div>
        </form>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" form="addForm">Save changes</button>
        </div>
      </div>
    </div>
  </div>