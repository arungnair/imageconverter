<!DOCTYPE html>
<html lang="en">

<head>
    <title>File Converter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style type="text/css">
        body {
            background: #f7f7f7;
        }

        .form-heading {
            text-align: center;
            padding-bottom: 40px;
        }

        .form-heading h1 {
            margin-bottom: 0px;
            font-size: 32px;
            color: #555555;
        }

        .img-conveter-form {
            padding: 70px 50px;
            border: 1px solid #f1f1f1;
            background: #fff;
        }

        .logo {
            width: 180px;
            margin: 80px auto;
        }
    </style>
</head>

<body>
  @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
						<ul>
							<li class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ $error }}</li>
						</ul>
        @endforeach
  @endif
	@if (Session::has('success'))
			<p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
	@endif
    <div class="container">
        <div class="logo">
            <img src="images/logo.png" class="w-100">
        </div>
        <div class="row">
            <div class="col-md-5 m-auto">
                <div class="img-conveter-form">
                    <div class="form-heading">
                        <h1>Image Converter</h1>
                    </div>
                    <form>
                      <!-- @csrf -->
                        <div class="form-group" >
                            <input type="text" name="source" class="form-control source" placeholder="source">
                        </div>
                        <div class="form-group">
                            <input type="text" name="destination" class="form-control destination" placeholder="destination">
                        </div>
                        <div class="form-group">
                            <input type="text" name="maxwidth" class="form-control maxwidth" placeholder="Max Width">
                        </div>
                        <div class="form-group">
                            <input type="text" name="maxheight" class="form-control maxheight" placeholder="Max Height">
                        </div>
                        <div class="form-group">
                            <input type="text" name="imgquality" class="form-control imgquality" placeholder="Quality">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary">Convert</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <input id="baseURL" type="text" value="{{ url('/') }}" />
    </div>
    <!-- /.container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(".btn-primary").click(function(){
         var baseURL = $("#baseURL").val();
        $.post(baseURL+"/api/upload",
        {
    source: $(".source").val(),
    destination: $(".destination").val(),
    maxwidth: $(".maxwidth").val(),
    maxheight: $(".maxheight").val(),
    imgquality: $(".imgquality").val(),

  },
  function(data, status){

  });
});

    </script>
</body>

</html>
