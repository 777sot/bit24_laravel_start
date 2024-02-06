@extends('app_free')

@section('content')
    <h1>INDEX1</h1>

    <script>
        window.onload = function() {
            axios.get('/api/')
                .then(res => console.log(res.data))
                .catch(err => console.log(res.data));
        }


    </script>
@endsection
