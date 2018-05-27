
<!-- Modal -->
<div class="modal fade" id="contactUsPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="padding-top:10%;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                {{--<div class="modal-header">--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                {{--<h4 class="modal-title" id="myModalLabel">Login / Register</h4>--}}
                {{--</div>--}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="comment-form-wrapper contact-from clearfix">
                                {!! Form::open(['url'=>'contact-submit','id'=>'contact-form', 'class'=>'comment-form row altered'])!!}
                                @if($errors->has('msg'))
                                    <div class="field col-sm-12 text-center">
                                        <span class="help-block" style="color: red;">{{$errors->first()}}</span>
                                    </div>
                                @endif
                                <div class="field col-sm-12 {{ $errors->has('name') ? ' has-error' : '' }}"style="margin-top: 30px;padding: 0 30px;">
                                    <h4>Nama</h4>
                                    <input type="text" id="namecontact" name="namecontact">
                                    @if ($errors->has('namecontact'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('namecontact') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="field col-sm-12 {{ $errors->has('email') ? ' has-error' : '' }}" style="margin-top: 30px;padding: 0 30px;">
                                    <h4>Alamat E-mail</h4>
                                    <input type="email" id="emailContact" name="emailContact">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="field col-sm-12 {{ $errors->has('phone') ? ' has-error' : '' }}" style="padding: 0 30px;">
                                    <h4>No Handphone</h4>
                                    <input type="number" id="phone" id="phone" name="phone">
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="field col-sm-12 {{ $errors->has('description') ? ' has-error' : '' }}" style="margin-top: 30px;padding: 0 30px;">
                                    <h4>Pertanyaan</h4>
                                    <textarea id="description" id="description" name="description">

                                        </textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="field col-sm-12" style="text-align: center;margin-top: 30px;">
                                    <button class="btn btn-big btn-solid"><span>Kirim</span></button>
                                </div>
                                {!! Form::close() !!}
                                <form class="comment-form row altered" method="POST" action="{{ route('contact-submit') }}">

                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
    var urlLinkContactUs = '{{route('contact-submit')}}';
</script>