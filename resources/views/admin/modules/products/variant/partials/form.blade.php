<div style="padding: 2%;">
  <div class="form-group m-form__group row">
    <div class="col-lg-6">
      {!! Form::label('name', 'Name', ['class' => 'control-label required']) !!}
      {!! Form::text('name', null, ['class' => 'form-control' .  ($errors->has('name') ? ' input-error' : ''), 'placeholder' => 'Name']) !!}
      @if($errors->has('name'))
        <span class="fm-form__help danger">{{ $errors->first('name') }}</span>
      @endif
    </div>
    <div class="col-lg-6">
      {!! Form::label('type', 'Type', ['class' => 'control-label required']) !!}
      {!! Form::text('type', null, ['class' => 'form-control' .  ($errors->has('type') ? ' input-error' : ''), 'placeholder' => 'Type']) !!}
      @if($errors->has('type'))
        <span class="fm-form__help danger">{{ $errors->first('type') }}</span>
      @endif
    </div>
  </div>
  <div class="form-group m-form__group row">
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</div>
