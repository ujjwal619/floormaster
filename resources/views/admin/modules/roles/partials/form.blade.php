<div class="m-portlet__body" style="padding: inherit;">
    <div class="form-group m-form__group row">
        <div class="col-lg-6">
            <label class="required">Title</label>
            {!! Form::text('title', null, ['class' => 'form-control' , 'placeholder' => 'Title']) !!}
            @if ($errors->has('title'))
                <span class="m-form__help danger">
                                        {{ $errors->first('title') }}
                                    </span>
            @endif
        </div>
        <div class="col-lg-6">
            <label class="required">Name</label>
            {!! Form::text('name', null, ['class' => 'form-control' , 'placeholder' => 'Name']) !!}
            @if ($errors->has('name'))
                <span class="m-form__help danger">
                                        {{ $errors->first('name') }}
                                    </span>
            @endif
        </div>
    </div>


    <div class="form-group m-form__group row">
        <div class="col-lg-6">
            <button class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>