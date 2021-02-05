<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    <label for="title" class='col-md-2 control-label'>Title</label>

    <div class="col-md-8">
        <input type="text" id="title" name="title" class="form-control" required autofocus>

        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    </div>
</div>

<div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
    <label for="body" class='col-md-2 control-label'>Body</label>

    <div class="col-md-8">
        <textarea id="body" class=form-control name="body" required>
        </textarea>

        <span class="help-block">
            <strong>{{ $errors->first('body') }}</strong>
        </span>
    </div>
</div>
