@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">

            <div class="col-md-12">
                <div class="container text-right">
                    <form>
                        <select class="d-inline" name="sort_post" id="sortPostByDate">
                            <option value=''>Sort By</option>
                            <option value='1'>Publication Date</option>
                        </select>
                    </form>
                </div>
                <div id="dataShow">
                    @include('frontend.data')
                </div>

                <div align="center">
                    {!! $posts->appends(['search' => request()->get('search')])->links() !!}
                </div>

            </div>

        </div>
    </div>
    <script>
        $('#sortPostByDate').change(function() {
            var id = $('#sortPostByDate').val();
            
            if (id == 1) 
            {
                $.ajax({
                    url: '/',
                    type: "GET",
                    success: function(data){
                        $data = $(data); // the HTML content that controller has produced
                        $('#dataShow').hide().html($data).fadeIn();
                    }
                });   
            }
        });
    </script>  
@endsection