@extends('myapp')

@section('content')
    <section>
        <div class="container-fluid">
            <div class="jumbotron">
                <h1  class="text-info" align="center">MyUsic</h1><br>
                <form id="form-search" name="form-search" action="{{ route('searchresults') }}" method="get" align="center">
                    <input type="text" id="search_query" name="search_query" class="form-control" placeholder="Search for Music">
                    <br>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-lg gradient">Search!</button>
                    </span>
                </form>
                <div class="col-md-1">
                    <a class="navbar-brand " href="#"></a>
                </div>
            </div>
        </div>
    <script src="./js/searchresults.js" ></script>
    </section>
@endsection