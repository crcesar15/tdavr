@extends('layout')

@include('partials.admin_nav_var',$user = session()->get('user'))
@push('styles')
    <style>
        body
        {
            background-color:#f5f5f5;
        }
        .imagePreview {
            width: 100%;
            height: 180px;
            background-position: center center;
            background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
            background-color:#fff;
            background-size: cover;
            background-repeat:no-repeat;
            display: inline-block;
            box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
        }
        .btn-primary
        {
            display:block;
            border-radius:0px;
            box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
            margin-top:-5px;
        }
        .imgUp
        {
            margin-bottom:15px;
        }
        .del
        {
            position:absolute;
            top:0px;
            right:15px;
            width:30px;
            height:30px;
            text-align:center;
            line-height:30px;
            background-color:rgba(255,255,255,0.6);
            cursor:pointer;
        }
        .imgAdd
        {
            width:30px;
            height:30px;
            border-radius:50%;
            background-color:#4bd7ef;
            color:#fff;
            box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);
            text-align:center;
            line-height:30px;
            margin-top:0px;
            cursor:pointer;
            font-size:15px;
        }
    </style>
@endpush
@section('content')
    <div class="row mt-5">
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">
            <div class="card border-primary mt-4">
                <div class="card-header">
                    <h4>Registrar Profesional</h4>
                </div>
                <div class="card-body table-responsive">
                    <form action="{{route('registerEmployee')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-10 col-md-8 col-lg-4 offset-1 offset-md-2 offset-lg-4 imgUp">
                                <div class="imagePreview"></div>
                                <label class="btn btn-primary">
                                    <i class="fa fa-upload"></i>Subir Foto de Perfil<input type="file" class="uploadFile img" name="profile_photo" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                </label>
                            </div><!-- col-2 -->
                        </div><!-- row -->
                        <br>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="">Nombre</label>
                                <input class="form-control" type="text" name="first_name" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Apellido</label>
                                <input class="form-control" type="text" name="last_name" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Usuario</label>
                                <input class="form-control" type="text" name="username" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Contraseña</label>
                                <input class="form-control" type="text" value="sample" disabled name="password">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Profesión/Ocupación</label>
                                <input class="form-control" type="text" name="profession" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">E-mail</label>
                                <input class="form-control" type="email" name="email" autocomplete="off">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="">Teléfono de Contacto</label>
                                <input class="form-control" type="text" name="phone" autocomplete="off">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(".imgAdd").click(function(){
            $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" name="real_image" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
        });
        $(document).on("click", "i.del" , function() {
            $(this).parent().remove();
        });
        $(function() {
            $(document).on("change",".uploadFile", function()
            {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function(){ // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                    }
                }

            });
        });
    </script>
@endpush
