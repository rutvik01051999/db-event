<!-- Modal -->
<div class="modal fade" id="eventeditmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Event edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="d-flex justify-content-center">
        <div class="form-group">
          <label for="language-editor">Select Language:</label>
          <select name="languages" id="languageDropDown"
              class="form-control">
              <option value="en">English</option>
              <option value="hi">Hindi</option>
              <option value="gu">Gujarati</option>
              <option value="mr">Marathi</option>
          </select>
        </div>
      </div>

      <form method="post">
        <div id="errorMessages" style="color:red;text-align:center;"></div>

        <input type="hidden" value="{{ $event->id }}" id="event_id">
        <div class="modal-body">
          @csrf
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" name="event_title" placeholder="Enter ..."
                  value="{{ $event->name }}" id="event_title" data-translatable="true">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Description</label>
                <input type="text" name="event_desc" class="form-control" placeholder="Enter ..."
                  value="{{ $event->description }}" data-translatable="true" id="event_desc">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Uploaded image</label><br>
                <img width="80px" src="{{ url('storage/images') . '/' . $event->image }}">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Start event</label>
                <input type="text" name="event_start" class="form-control datepicker"
                  placeholder="Enter ..." id="datepicker" value="{{ $event->start_date }}">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>End event</label>
                <input type="text" name="event_end" class="form-control datepicker"
                  placeholder="Enter ..." id="datepicker2" value="{{ $event->close_date }}">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Response</label>
                <input type="text" name="event_response" class="form-control" placeholder="Enter ..."
                  id="event_response" data-translatable="true">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category_name" id="category_name">
                  @foreach ($category as $item)
                  <option value="{{ $item->id }}"
                    {{ $item->id == $event->category_id ? 'selected' : '' }}>
                    {{ $item->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Departmen</label>
                <select class="form-control" name="departmen_name" id="departmen_name">
                  @foreach ($departmen as $item)
                  <option value="{{ $item->id }}"
                    {{ $item->id == $event->department_id ? 'selected' : '' }}>
                    {{ $item->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Upload new image</label>
                <input type="file" name="logo" class="form-control" placeholder="Enter ..."
                  id="logo">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" data-id="{{ $event->id }}" class="btn btn-primary event-update">Save
            changes</button>
        </div>
      </form>
    </div>
  </div>
</div>